<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Optimized CV - {{ $user->name }}</title>
    <style>
        /* Reset & Base */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1a1a2e;
            line-height: 1.5;
            font-size: 10pt;
            padding: 0;
            margin: 0;
        }

        /* Header Section */
        .header {
            background: linear-gradient(135deg, #1a1a2e 0%, #2d1b69 100%);
            color: white;
            padding: 35px 40px 30px 40px;
            margin-bottom: 25px;
        }
        .header h1 {
            font-size: 26pt;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        .header .title {
            font-size: 13pt;
            color: #a78bfa;
            font-weight: 500;
            margin-bottom: 10px;
        }
        .header .contact-info {
            font-size: 9pt;
            color: #c4b5fd;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .header .contact-info span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* ATS Score Badge */
        .ats-badge {
            display: inline-block;
            background: {{ $atsScore >= 70 ? '#10B981' : ($atsScore >= 50 ? '#F59E0B' : '#EF4444') }};
            color: white;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 9pt;
            font-weight: 600;
            margin-top: 8px;
        }

        /* Content Sections */
        .content { padding: 0 40px; }

        .section {
            margin-bottom: 22px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 12pt;
            font-weight: 700;
            color: #2d1b69;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border-bottom: 2px solid #7c3aed;
            padding-bottom: 6px;
            margin-bottom: 12px;
        }

        /* Professional Summary */
        .summary-text {
            font-size: 10pt;
            color: #374151;
            line-height: 1.7;
            text-align: justify;
        }

        /* Experience Entries */
        .experience {
            margin-bottom: 16px;
            page-break-inside: avoid;
        }
        .experience-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 3px;
        }
        .experience-header h3 {
            font-size: 11pt;
            font-weight: 700;
            color: #1a1a2e;
        }
        .experience-header .company {
            font-size: 10pt;
            color: #7c3aed;
            font-weight: 600;
        }
        .experience-header .dates {
            font-size: 9pt;
            color: #6b7280;
            font-weight: 400;
        }
        .experience .location {
            font-size: 9pt;
            color: #9ca3af;
            margin-bottom: 5px;
        }
        .experience .description {
            font-size: 9.5pt;
            color: #374151;
            line-height: 1.6;
            padding-left: 12px;
            border-left: 2px solid #e5e7eb;
        }
        .experience .description ul {
            list-style: none;
            padding: 0;
        }
        .experience .description ul li {
            position: relative;
            padding-left: 14px;
            margin-bottom: 3px;
        }
        .experience .description ul li:before {
            content: '•';
            position: absolute;
            left: 0;
            color: #7c3aed;
            font-weight: bold;
        }

        /* Skills */
        .skills-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }
        .skill-tag {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 3px;
            font-size: 9pt;
            background: #f3e8ff;
            color: #6d28d9;
            border: 1px solid #e9d5ff;
        }
        .skill-tag.matched {
            background: #d1fae5;
            color: #065f46;
            border-color: #a7f3d0;
        }

        /* Education */
        .education {
            margin-bottom: 10px;
        }
        .education h4 {
            font-size: 10.5pt;
            font-weight: 600;
            color: #1a1a2e;
        }
        .education .meta {
            font-size: 9pt;
            color: #6b7280;
        }

        /* Qualifications */
        .qualification {
            margin-bottom: 8px;
            padding: 6px 10px;
            background: #f9fafb;
            border-left: 3px solid #7c3aed;
        }
        .qualification h4 {
            font-size: 10pt;
            font-weight: 600;
            color: #1a1a2e;
        }
        .qualification .meta {
            font-size: 8.5pt;
            color: #6b7280;
        }

        /* ATS Breakdown */
        .ats-section {
            margin-top: 25px;
            padding: 15px 20px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            page-break-inside: avoid;
        }
        .ats-section h3 {
            font-size: 11pt;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 10px;
        }
        .ats-bar {
            display: flex;
            align-items: center;
            margin-bottom: 6px;
        }
        .ats-bar .label {
            width: 140px;
            font-size: 8.5pt;
            color: #6b7280;
            flex-shrink: 0;
        }
        .ats-bar .bar-track {
            flex: 1;
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            margin: 0 10px;
        }
        .ats-bar .bar-fill {
            height: 100%;
            border-radius: 4px;
        }
        .ats-bar .score {
            width: 30px;
            text-align: right;
            font-size: 9pt;
            font-weight: 600;
        }

        /* Footer */
        .footer {
            text-align: center;
            font-size: 7.5pt;
            color: #9ca3af;
            padding: 15px 40px;
            border-top: 1px solid #e5e7eb;
            margin-top: 30px;
        }

        /* Page break */
        .page-break { page-break-before: always; }

        /* Print optimization */
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .header { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .ats-badge { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .skill-tag { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .skill-tag.matched { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .ats-section { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <div class="header">
        <h1>{{ $user->name }}</h1>
        <div class="title">{{ $user->email }}</div>
        <div class="contact-info">
            <span>📧 {{ $user->email }}</span>
            @if($user->phone)
                <span>📞 {{ $user->phone }}</span>
            @endif
            @if($user->location)
                <span>📍 {{ $user->location }}</span>
            @endif
        </div>
        <div class="ats-badge">ATS Score: {{ $atsScore }}/100</div>
    </div>

    <!-- CONTENT -->
    <div class="content">
        <!-- Professional Summary -->
        @if(!empty($summary))
            <div class="section">
                <div class="section-title">Professional Summary</div>
                <div class="summary-text">
                    {{ $summary }}
                </div>
            </div>
        @endif

        <!-- Experience -->
        @if(count($experiences) > 0)
            <div class="section">
                <div class="section-title">Professional Experience</div>
                @foreach($experiences as $exp)
                    @php
                        $startDate = !empty($exp['start_date']) ? date('M Y', strtotime($exp['start_date'])) : '';
                        $endDate = !empty($exp['end_date']) ? date('M Y', strtotime($exp['end_date'])) : (!empty($exp['is_current']) ? 'Present' : '');
                        $dateRange = $startDate && $endDate ? $startDate . ' - ' . $endDate : ($startDate ?: '');
                    @endphp
                    <div class="experience">
                        <div class="experience-header">
                            <div>
                                <h3>{{ $exp['job_title'] ?? '' }}</h3>
                                <span class="company">{{ $exp['company_name'] ?? '' }}</span>
                            </div>
                            <span class="dates">{{ $dateRange }}</span>
                        </div>
                        @if(!empty($exp['location']))
                            <div class="location">{{ $exp['location'] }}</div>
                        @endif
                        <div class="description">
                            {!! nl2br(e($exp['optimized_description'] ?? $exp['original_description'] ?? '')) !!}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Skills -->
        @if(count($skills) > 0)
            <div class="section">
                <div class="section-title">Skills & Competencies</div>
                <div class="skills-grid">
                    @foreach($skills as $skill)
                        <span class="skill-tag {{ !empty($skill['matched']) ? 'matched' : '' }}">
                            {{ $skill['name'] ?? '' }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Education section removed - using Work History only -->
        <!-- Qualifications section removed - using Work History only -->

        <!-- ATS Breakdown -->
        @if(!empty($atsBreakdown))
            <div class="ats-section">
                <h3>📊 ATS Compatibility Analysis</h3>
                @foreach($atsBreakdown as $key => $score)
                    @php
                        $labels = [
                            'keywords_match' => 'Keywords Match',
                            'skills_match' => 'Skills Match',
                            'experience_relevance' => 'Experience Relevance',
                            'education_match' => 'Education Match',
                            'format_quality' => 'Format Quality',
                        ];
                        $label = $labels[$key] ?? ucwords(str_replace('_', ' ', $key));
                        $color = $score >= 70 ? '#10B981' : ($score >= 50 ? '#F59E0B' : '#EF4444');
                    @endphp
                    <div class="ats-bar">
                        <span class="label">{{ $label }}</span>
                        <div class="bar-track">
                            <div class="bar-fill" style="width: {{ $score }}%; background: {{ $color }};"></div>
                        </div>
                        <span class="score" style="color: {{ $color }};">{{ $score }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Generated on {{ $generatedAt }} · ATS-Optimized CV · Resume Optimizer
    </div>
</body>
</html>
