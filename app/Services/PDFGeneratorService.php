<?php
// app/Services/PDFGeneratorService.php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class PDFGeneratorService
{
    public function generateOptimizedCV($experiences, $educations, $skills, $qualifications, $atsScore, $atsBreakdown, $summary, $jobTitle, $companyName, $template = 'professional')
    {
        $data = [
            'user' => auth()->user(),
            'experiences' => $experiences,
            'educations' => $educations,
            'skills' => $skills,
            'qualifications' => $qualifications,
            'atsScore' => $atsScore,
            'atsBreakdown' => $atsBreakdown,
            'summary' => $summary,
            'jobTitle' => $jobTitle,
            'companyName' => $companyName,
            'suggestions' => $suggestions ?? [],
            'generatedAt' => now()->format('F d, Y'),
        ];

        // Determine which template view to load
        $view = 'pdf.templates.' . $template;

        // Fallback to professional if template not found
        if (!view()->exists($view)) {
            $view = 'pdf.templates.professional';
        }

        $pdf = Pdf::loadView($view, $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('optimized-cv-' . auth()->id() . '-' . now()->format('Ymd') . '.pdf');
    }
}
