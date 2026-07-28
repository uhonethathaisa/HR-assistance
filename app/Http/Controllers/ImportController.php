<?php
// app/Http/Controllers/ImportController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DeepSeekService;
use Smalot\PdfParser\Parser;
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

            if ($extension === 'pdf') {
                $parser = new Parser();
                $pdf = $parser->parseFile($file->getRealPath());
                $text = $pdf->getText();
            } elseif (in_array($extension, ['doc', 'docx'])) {
                // You can add PhpWord support here if needed
                throw new \Exception('Word files are not yet supported via this endpoint. Please use PDF.');
            } else {
                throw new \Exception('Unsupported file format.');
            }

            if (empty(trim($text))) {
                return response()->json(['success' => false, 'message' => 'Could not extract text from the file.']);
            }

            $deepSeek = new DeepSeekService();
            $parsedData = $deepSeek->parseCvToStructuredJson($text);

            return response()->json([
                'success' => true,
                'data' => $parsedData,
                'message' => 'CV parsed successfully!',
            ]);

        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}