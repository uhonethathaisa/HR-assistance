<?php
// app/Http/Controllers/ImportController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeepSeekService;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Log;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        try {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filePath = $file->getRealPath();

            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Uploaded file not found on the server.',
                ]);
            }

            // Extract text based on file type
            if ($extension === 'pdf') {
                $text = $this->extractTextFromPdf($filePath);
            } elseif (in_array($extension, ['doc', 'docx'])) {
                $text = $this->extractTextFromWord($filePath);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Unsupported file format. Please upload PDF, DOC, or DOCX files.',
                ]);
            }

            if (empty(trim($text))) {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not extract any text from the file. The file may be empty or contain only images.',
                ]);
            }

            // Call DeepSeek API to parse the CV
            $deepSeek = new DeepSeekService();
            $parsedData = $deepSeek->parseCvToStructuredJson($text);

            if ($parsedData === null) {
                return response()->json([
                    'success' => false,
                    'message' => 'AI parsing returned an empty response. Please try again or check your API key.',
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $parsedData,
                'message' => 'CV parsed successfully!',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage(), [
                'file' => $request->file('file') ? $request->file('file')->getClientOriginalName() : 'unknown',
                'trace' => $e->getTraceAsString(),
            ]);

            $userMessage = 'An error occurred while processing your file.';
            if (str_contains($e->getMessage(), 'API')) {
                $userMessage = 'AI service is temporarily unavailable. Please try again later.';
            } elseif (str_contains($e->getMessage(), 'PDF')) {
                $userMessage = 'Could not read this PDF file. It may be corrupted or password-protected.';
            } elseif (str_contains($e->getMessage(), 'Word')) {
                $userMessage = 'Could not read this Word document. It may be corrupted.';
            }

            return response()->json([
                'success' => false,
                'message' => $userMessage,
            ]);
        }
    }

    /**
     * Extract text from a PDF file using Smalot PDF Parser
     */
    private function extractTextFromPdf(string $filePath): string
    {
        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            $text = $pdf->getText();

            // Clean up excessive whitespace
            $text = preg_replace('/\s+/', ' ', $text);
            $text = trim($text);

            return $text;
        } catch (\Exception $e) {
            Log::error('PDF extraction failed: ' . $e->getMessage());
            throw new \Exception('PDF parsing error: ' . $e->getMessage());
        }
    }

    /**
     * Extract text from a Word document (DOCX/DOC) using PhpWord
     */
    private function extractTextFromWord(string $filePath): string
    {
        try {
            $phpWord = IOFactory::load($filePath);
            $text = '';

            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $text .= $element->getText() . "\n";
                    } elseif (method_exists($element, 'getElements')) {
                        $text .= $this->extractTextFromElements($element->getElements()) . "\n";
                    }
                }
            }

            // Clean up excessive whitespace
            $text = preg_replace('/\s+/', ' ', $text);
            $text = trim($text);

            return $text;
        } catch (\Exception $e) {
            Log::error('Word extraction failed: ' . $e->getMessage());
            throw new \Exception('Word parsing error: ' . $e->getMessage());
        }
    }

    /**
     * Recursively extract text from PhpWord element collections
     */
    private function extractTextFromElements(array $elements): string
    {
        $text = '';
        foreach ($elements as $element) {
            if (method_exists($element, 'getText')) {
                $text .= $element->getText() . ' ';
            } elseif (method_exists($element, 'getElements')) {
                $text .= $this->extractTextFromElements($element->getElements()) . ' ';
            }
        }
        return $text;
    }
}
