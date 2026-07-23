{{-- resources/views/pdf/templates/professional.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Professional CV - {{ $user->name ?? 'Candidate' }}</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #1a1a2e; padding: 40px; }
        .header { text-align: center; border-bottom: 3px solid #6D28D9; padding-bottom: 20px; }
        .name { font-size: 28px; font-weight: bold; color: #1a1a2e; }
        .title { color: #6D28D9; font-size: 18px; }
        .section-title { border-bottom: 2px solid #e5e7eb; padding-bottom: 5px; margin: 20px 0 15px; font-size: 18px; font-weight: bold; color: #1a1a2e; }
        .contact { color: #6b7280; font-size: 14px; margin-top: 5px; }
        .exp-header { display: flex; justify-content: space-between; }
        .exp-company { color: #6D28D9; }
        .bullet { margin-top: 5px; margin-bottom: 10px; }
        .bullet li { margin-bottom: 3px; }
        .skill-tag { background: #f3f4f6; padding: 4px 12px; border-radius: 15px; display: inline-block; margin: 3px; font-size: 13px; }
        .empty-state { color: #9ca3af; font-style: italic; padding: 10px 0; }
        .footer { text-align: center; font-size: 12px; color: #9ca3af; margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 15px; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="name">{{ $user->name ?? 'Candidate Name' }}</div>
        <div class="title">{{ $jobTitle ?? 'Position' }} at {{ $companyName ?? 'Company' }}</div>
        <div class="contact">{{ $user->email ?? '' }}{{ !empty($user->email) && !empty($user->phone) ? ' | ' : '' }}{{ $user->phone ?? '' }}</div>
    </div>

    <!-- ATS Score Banner -->
    @php $score = $atsScore ?? 0; @endphp
    <div style="background: #6D28D9; color: white; padding: 10px 20px; border-radius: 8px; margin: 20px 0;">
        <span>ATS Score: {{ $score }}%</span>
        <span style="float: right;">
            @if($score >= 80) 🌟 Excellent
            @elseif($score >= 60) ⭐ Good
            @elseif($score >= 40) ⚡ Fair
            @else 📈 Needs Improvement
            @endif
        </span>
    </div>

    <!-- Professional Summary -->
    <div class="section-title">Professional Summary</div>
    <p>{{ $summary ?? 'No summary available.' }}</p>

    <!-- Work Experience -->
    <div class="section-title">Work Experience</div>
    @if(!empty($experiences))
        @foreach($experiences as $exp)
        <div style="margin-bottom: 15px;">
            <div class="exp-header">
                <strong>{{ $exp['job_title'] ?? 'Position' }}</strong>
                <span style="color: #6b7280;">{{ $exp['start_date'] ?? '' }} - {{ $exp['end_date'] ?? 'Present' }}</span>
            </div>
            <div class="exp-company">{{ $exp['company_name'] ?? 'Company' }}</div>
            @if(!empty($exp['optimized_bullets']))
                <ul class="bullet">
                    @foreach($exp['optimized_bullets'] as $bullet)
                    <li>{{ $bullet }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        @endforeach
    @else
        <div class="empty-state">No work experience data available.</div>
    @endif

    <!-- Education -->
    <div class="section-title">Education</div>
    @if(!empty($educations))
        @foreach($educations as $edu)
        <div style="margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between;">
                <strong>{{ $edu['degree'] ?? 'Degree' }}</strong>
                <span style="color: #6b7280;">{{ $edu['start_date'] ?? '' }} - {{ $edu['end_date'] ?? 'Present' }}</span>
            </div>
            <div>{{ $edu['institution'] ?? '' }}</div>
            @if(!empty($edu['field_of_study']))
            <div style="color: #6b7280;">Field: {{ $edu['field_of_study'] }}</div>
            @endif
        </div>
        @endforeach
    @else
        <div class="empty-state">No education data available.</div>
    @endif

    <!-- Skills -->
    <div class="section-title">Skills</div>
    @if(!empty($skills))
    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
        @foreach($skills as $skill)
        <span class="skill-tag">{{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}</span>
        @endforeach
    </div>
    @else
        <div class="empty-state">No skills listed.</div>
    @endif

    <!-- Qualifications -->
    @if(!empty($qualifications))
    <div class="section-title">Certifications</div>
    @foreach($qualifications as $qual)
    <div style="margin-bottom: 5px;">
        <strong>{{ $qual['name'] ?? 'Certification' }}</strong>
        @if(!empty($qual['issuing_organization'])) – {{ $qual['issuing_organization'] }} @endif
    </div>
    @endforeach
    @endif

    <!-- Suggestions -->
    @if(!empty($suggestions))
    <div style="background: #fefce8; border: 1px solid #f59e0b; border-radius: 8px; padding: 15px; margin-top: 20px;">
        <strong style="color: #d97706;">💡 Suggestions</strong>
        <ul>
            @foreach($suggestions as $suggestion)
            <li>{{ $suggestion }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="footer">
        Generated on {{ $generatedAt ?? now()->format('F d, Y') }} • Optimized for {{ $jobTitle ?? 'Position' }} at {{ $companyName ?? 'Company' }}
    </div>
</body>
</html>
