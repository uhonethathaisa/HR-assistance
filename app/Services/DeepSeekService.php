<?php
// app/Services/DeepSeekService.php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Smalot\PdfParser\Parser;

class DeepSeekService
{
    protected $client;
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('DEEPSEEK_API_KEY');
        $this->apiUrl = env('DEEPSEEK_API_URL', 'https://api.deepseek.com/v1/chat/completions');

        $this->client = new Client([
            'timeout' => 120,
            'verify' => app()->environment('local') ? false : true,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ]
        ]);
    }

    /**
     * Extract text from a PDF file
     */
    public function extractTextFromPDF($filePath)
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();

            // Clean up the text
            $text = preg_replace('/\s+/', ' ', $text);
            $text = trim($text);

            return $text;
        } catch (\Exception $e) {
            Log::error('PDF parsing failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Extract text from a Word document
     */
    public function extractTextFromWord($filePath)
    {
        try {
            $zip = new \ZipArchive();
            if ($zip->open($filePath) === true) {
                $content = $zip->getFromName('word/document.xml');
                $zip->close();

                if ($content) {
                    $content = strip_tags($content);
                    $content = preg_replace('/\s+/', ' ', $content);
                    return trim($content);
                }
            }
            throw new \Exception('Could not extract text from Word document');
        } catch (\Exception $e) {
            Log::error('Word parsing failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Parse CV content into structured JSON
     */
    public function parseCvToStructuredJson($cvText)
    {
        try {
            $prompt = "Parse the following CV/resume text into a structured JSON format. Extract:\n";
            $prompt .= "- personal_info: name, email, phone, location\n";
            $prompt .= "- summary: professional summary\n";
            $prompt .= "- work_experience: array of {job_title, company, location, start_date, end_date, description}\n";
            $prompt .= "- education: array of {degree, institution, location, graduation_date}\n";
            $prompt .= "- skills: array of skill names\n";
            $prompt .= "- certifications: array of {name, issuer, date}\n\n";
            $prompt .= "CV Text:\n" . $cvText . "\n\n";
            $prompt .= "Return ONLY valid JSON. No explanations, no markdown formatting.";

            $response = $this->client->post($this->apiUrl, [
                'json' => [
                    'model' => 'deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a CV parsing expert. Extract structured data from CVs and return ONLY valid JSON.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.1,
                    'max_tokens' => 4000,
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['choices'][0]['message']['content'])) {
                $content = $result['choices'][0]['message']['content'];
                // Try to extract JSON from the response
                preg_match('/\{[\s\S]*\}/', $content, $matches);
                if (!empty($matches)) {
                    return json_decode($matches[0], true);
                }
                return json_decode($content, true);
            }

            return null;
        } catch (\Exception $e) {
            Log::error('CV parsing failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Optimize CV content using AI
     */
    public function optimizeCV($cvData, $jobDescription)
    {
        try {
            $prompt = "You are an expert CV optimizer. Optimize the following CV against the job description.\n\n";
            $prompt .= "CV Data:\n" . json_encode($cvData, JSON_PRETTY_PRINT) . "\n\n";
            $prompt .= "Job Description:\n" . $jobDescription . "\n\n";
            $prompt .= "Return a JSON object with:\n";
            $prompt .= "1. 'optimized_experiences': array of optimized work experiences with improved bullet points\n";
            $prompt .= "2. 'optimized_skills': array of relevant skills\n";
            $prompt .= "3. 'suggestions': array of improvement suggestions\n";
            $prompt .= "4. 'ats_score': ATS compatibility score (0-100)\n";
            $prompt .= "5. 'missing_keywords': array of important keywords missing from CV\n\n";
            $prompt .= "Return ONLY valid JSON.";

            $response = $this->client->post($this->apiUrl, [
                'json' => [
                    'model' => 'deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are an expert CV optimizer and ATS specialist.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.3,
                    'max_tokens' => 4000,
                ]
            ]);

            $result = json_decode($response->getBody(), true);

            if (isset($result['choices'][0]['message']['content'])) {
                $content = $result['choices'][0]['message']['content'];
                preg_match('/\{[\s\S]*\}/', $content, $matches);
                if (!empty($matches)) {
                    return json_decode($matches[0], true);
                }
                return json_decode($content, true);
            }

            return null;
        } catch (\Exception $e) {
            Log::error('CV optimization failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate cover letter using AI
     */
    public function generateCoverLetter($cvData, $jobDescription, $companyName)
    {
        try {
            $prompt = "Write a professional cover letter based on the following:\n\n";
            $prompt .= "CV Data:\n" . json_encode($cvData, JSON_PRETTY_PRINT) . "\n\n";
            $prompt .= "Job Description:\n" . $jobDescription . "\n\n";
            $prompt .= "Company: " . $companyName . "\n\n";
            $prompt .= "Write a compelling cover letter that highlights relevant experience and skills.";

            $response = $this->client->post($this->apiUrl, [
                'json' => [
                    'model' => 'deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are an expert cover letter writer.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 2000,
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            return $result['choices'][0]['message']['content'] ?? null;
        } catch (\Exception $e) {
            Log::error('Cover letter generation failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Test API connection
     */
    public function testConnection()
    {
        try {
            $response = $this->client->post($this->apiUrl, [
                'json' => [
                    'model' => 'deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => 'Hello'
                        ]
                    ],
                    'max_tokens' => 10,
                ]
            ]);

            $result = json_decode($response->getBody(), true);
            return isset($result['choices'][0]['message']['content']);
        } catch (\Exception $e) {
            Log::error('API connection test failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Public method for CVOptimizationService to call API
     */
    public function callAPI($prompt)
    {
        try {
            $response = $this->client->post($this->apiUrl, [
                'json' => [
                    'model' => 'deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are an expert CV optimizer. Return ONLY valid JSON. No explanations, no markdown.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.3,
                    'max_tokens' => 4000,
                ]
            ]);

            return json_decode($response->getBody(), true);

        } catch (\Exception $e) {
            Log::error('DeepSeek API call failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
