<?php
// app/Http/Controllers/OptimizedCVDownloadController.php

namespace App\Http\Controllers;

use App\Services\PDFGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OptimizedCVDownloadController extends Controller
{
    public function download(Request $request)
    {
        try {
            // Retrieve optimization data from session
            $data = session('cv_optimization_data');

            if (!$data) {
                return redirect()->route('cv-optimizer')
                    ->with('error', 'Session expired. Please re-optimize your CV.');
            }

            $template = $request->query('template', $data['template'] ?? 'professional');

            $service = new PDFGeneratorService();

            return $service->generateOptimizedCV(
                $data['experiences'],
                $data['educations'],
                $data['skills'],
                $data['qualifications'],
                $data['ats_score'],
                $data['ats_breakdown'],
                $data['summary'],
                $data['job_title'],
                $data['company_name'],
                $template
            );

        } catch (\Exception $e) {
            Log::error('PDF Download Error: ' . $e->getMessage());

            return redirect()->route('cv-optimizer')
                ->with('error', 'Failed to generate PDF: ' . $e->getMessage());
        }
    }
}
