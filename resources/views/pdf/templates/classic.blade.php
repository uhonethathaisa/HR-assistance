{{-- resources/views/pdf/templates/classic.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>CV - {{ $user->name ?? 'Candidate' }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; color: #000; padding: 40px; max-width: 850px; margin: auto; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 15px; }
        .name { font-size: 28px; font-weight: bold; text-transform: uppercase; letter-spacing: 3px; }
        .title { font-size: 18px; font-weight: normal; }
        .contact { font-size: 14px; margin-top: 5px; }
        .section-title { font-weight: bold; font-size: 18px; text-transform: uppercase; border-bottom: 1px solid #000; padding-bottom: 3px; margin: 20px 0 10px; }
        .exp-header { display: flex; justify-content: space-between; font-weight: bold; }
        .exp-company { font-weight: normal; font-style: italic; }
        .bullet { margin-left: 20px; }
        .skill-tag { background: #f0f0f0; padding: 2px 10px; border: 1px solid #ccc; display: inline-block; margin: 3px; font-size: 12px; }
        .ats { border: 1px solid #000; padding: 8px; text-align: center; margin: 15px 0; }
        .empty-state { color: #666; font-style: italic; padding: 10px 0; }
        .footer { text-align: center; font-size: 11px; margin-top: 30px; border-top: 1px solid #ccc; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="name">{{ $user->name ?? 'Candidate Name' }}</div>
        <div class="title">{{ $jobTitle ?? 'Position' }}</div>
        <div class="contact">{{ $user->email ?? '' }}{{ !empty($user->email) && !empty($user->phone) ? ' | ' : '' }}{{ $user->phone ?? '' }}</div>
    </div>

    @php $score = $atsScore ?? 0; @endphp
    <div class="ats">
        ATS Compatibility: {{ $score }}% –
        @if($score >= 80) Excellent
        @elseif($score >= 60) Good
        @elseif($score >= 40) Fair
        @else Needs Improvement
        @endif
    </div>

    <div class="section-title">Professional Profile</div>
    <p>{{ $summary ?? 'No summary available.' }}</p>

    <div class="section-title">Employment History</div>
    @if(!empty($experiences))
        @foreach($experiences as $exp)
        <div style="margin-bottom: 12px;">
            <div class="exp-header">
                <span>{{ $exp['job_title'] ?? 'Position' }}</span>
                <span>{{ $exp['start_date'] ?? '' }} – {{ $exp['end_date'] ?? 'Current' }}</span>
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
        <div style="margin-bottom: 5px;">
            <strong>{{ $edu['degree'] ?? 'Degree' }}</strong>{{ !empty($edu['institution']) ? ', ' . $edu['institution'] : '' }}
            ({{ $edu['start_date'] ?? '' }} – {{ $edu['end_date'] ?? 'Present' }})
        </div>
        @endforeach
    @else
        <div class="empty-state">No education data available.</div>
    @endif

    <div class="section-title">Professional Skills</div>
    @if(!empty($skills))
    <div>
        @foreach($skills as $skill)
        <span class="skill-tag">{{ is_array($skill) ? ($skill['name'] ?? '') : $skill }}</span>
        @endforeach
    </div>
    @else
        <div class="empty-state">No skills listed.</div>
    @endif

    <div class="footer">Generated {{ $generatedAt ?? now()->format('F d, Y') }}</div>
</body>
</html>
