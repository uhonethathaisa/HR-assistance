{{-- resources/views/pdf/templates/minimal.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $user->name ?? 'Candidate' }} - CV</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; color: #111; padding: 30px; max-width: 800px; margin: auto; }
        .name { font-size: 32px; font-weight: 300; letter-spacing: 2px; }
        .title { font-size: 18px; color: #555; margin-bottom: 20px; }
        .section-title { font-weight: 600; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin: 20px 0 15px; }
        .exp-item { margin-bottom: 15px; }
        .exp-header { display: flex; justify-content: space-between; font-weight: 600; }
        .exp-company { color: #333; font-weight: 400; }
        .bullet { margin-left: 20px; }
        .skill-tag { background: #eee; padding: 3px 10px; border-radius: 3px; display: inline-block; margin: 3px; }
        .ats-banner { background: #f5f5f5; padding: 10px; border-radius: 4px; margin: 20px 0; text-align: center; }
        .empty-state { color: #999; font-style: italic; padding: 10px 0; }
        .footer { text-align: center; font-size: 11px; color: #999; margin-top: 30px; border-top: 1px solid #eee; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="name">{{ $user->name ?? 'Candidate Name' }}</div>
    <div class="title">{{ $jobTitle ?? 'Position' }} at {{ $companyName ?? 'Company' }}</div>
    <div style="color: #666; margin-bottom: 20px;">{{ $user->email ?? '' }}</div>

    @php $score = $atsScore ?? 0; @endphp
    <div class="ats-banner">
        ATS Score: {{ $score }}% –
        @if($score >= 80) 🌟 Excellent
        @elseif($score >= 60) ⭐ Good
        @elseif($score >= 40) ⚡ Fair
        @else 📈 Needs Improvement
        @endif
    </div>

    <div class="section-title">Summary</div>
    <p>{{ $summary ?? 'No summary available.' }}</p>

    <div class="section-title">Experience</div>
    @if(!empty($experiences))
        @foreach($experiences as $exp)
        <div class="exp-item">
            <div class="exp-header">
                <span>{{ $exp['job_title'] ?? 'Position' }}</span>
                <span>{{ $exp['start_date'] ?? '' }} - {{ $exp['end_date'] ?? 'Present' }}</span>
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

    <div class="section-title">Education</div>
    @if(!empty($educations))
        @foreach($educations as $edu)
        <div style="margin-bottom: 8px;">
            <div><strong>{{ $edu['degree'] ?? 'Degree' }}</strong> – {{ $edu['institution'] ?? '' }}</div>
            <div style="color: #666; font-size: 14px;">{{ $edu['start_date'] ?? '' }} - {{ $edu['end_date'] ?? 'Present' }}</div>
        </div>
        @endforeach
    @else
        <div class="empty-state">No education data available.</div>
    @endif

    <div class="section-title">Skills</div>
    @if(!empty($skills))
    <div>
        @foreach($skills as $skill)
        <span class="skill-tag">{{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}</span>
        @endforeach
    </div>
    @else
        <div class="empty-state">No skills listed.</div>
    @endif

    <div class="footer">Generated on {{ $generatedAt ?? now()->format('F d, Y') }}</div>
</body>
</html>
