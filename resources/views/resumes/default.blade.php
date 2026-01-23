<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resume - {{ $basics['name'] ?? 'Student' }}</title>
    <style>
        @page {
            margin: 0;
            size: A4;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.25;
            margin: 0;
            padding: 0;
            font-size: 9pt;
        }
        
        /* Layout */
        .header {
            background-color: #2d3e50;
            color: #ffffff;
            padding: 30px 40px 20px 40px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .contact-strip {
            background-color: #252f39;
            color: #ffffff;
            padding: 8px 40px;
            font-size: 8pt;
        }
        .contact-table {
            width: 100%;
            border-collapse: collapse;
        }
        .content {
            padding: 20px 40px;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
        }
        .col-left {
            width: 60%;
            padding-right: 30px;
            vertical-align: top;
        }
        .col-right {
            width: 40%;
            vertical-align: top;
        }

        /* Profile Image */
        .profile-image-container {
            width: 110px;
            text-align: right;
            vertical-align: top;
        }
        .profile-image {
            display: inline-block;
            width: 100px;
            height: 100px;
            border: 2px solid #4cb4bc;
            border-radius: 50%;
            overflow: hidden;
            background-color: #252f39;
        }
        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Typography */
        h1 {
            margin: 0;
            font-size: 26pt;
            font-weight: normal;
            letter-spacing: 0.5px;
        }
        .title {
            color: #4cb4bc;
            font-size: 16pt;
            margin: 2px 0 5px 0;
            text-transform: capitalize;
        }
        .basics-summary {
            font-size: 9pt;
            color: #e0e0e0;
            margin-top: 5px;
            text-align: justify;
        }

        h3 {
            color: #4cb4bc;
            text-transform: uppercase;
            font-size: 12pt;
            margin: 0 0 8px 0;
            border-bottom: 2px solid #4cb4bc;
            padding-bottom: 2px;
        }

        /* Contact Items */
        .contact-item {
            margin-bottom: 2px;
        }
        .contact-icon {
            color: #4cb4bc;
            font-weight: bold;
            margin-right: 3px;
        }

        /* Section Content */
        .section {
            margin-bottom: 15px;
        }
        .item-title {
            font-weight: bold;
            font-size: 11pt;
            color: #000;
        }
        .item-subtitle {
            font-weight: bold;
            font-size: 10pt;
            color: #333;
        }
        .item-meta {
            color: #4cb4bc;
            font-style: italic;
            font-size: 8.5pt;
            margin-bottom: 2px;
        }
        .item-score {
            float: right;
            color: #4cb4bc;
            font-style: italic;
            font-size: 8.5pt;
        }
        .bullet-list {
            margin: 3px 0 0 0;
            padding: 0;
            list-style: none;
        }
        .bullet-list li {
            position: relative;
            padding-left: 12px;
            margin-bottom: 2px;
            font-size: 8.5pt;
            text-align: justify;
        }
        .bullet-list li::before {
            content: "\2022";
            color: #4cb4bc;
            position: absolute;
            left: 0;
            font-weight: bold;
        }

        /* Tags */
        .tag {
            display: inline-block;
            background-color: #9ba6b0;
            color: #ffffff;
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 8pt;
            margin: 0 3px 4px 0;
        }
        .interest-tag {
            display: inline-block;
            border: 1px solid #9ba6b0;
            color: #333;
            padding: 2px 8px;
            border-radius: 3px;
            margin: 0 3px 4px 0;
            font-size: 8pt;
        }

        /* Languages */
        .lang-item {
            margin-bottom: 8px;
            width: 48%;
            display: inline-block;
            vertical-align: top;
        }
        .lang-name {
            font-weight: bold;
        }
        .lang-level {
            color: #4cb4bc;
            font-style: italic;
            font-size: 8pt;
        }

        /* Prevent breaks inside sections */
        .section-item, .section {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td style="vertical-align: top;">
                    <h1>{{ $basics['name'] ?? '' }}</h1>
                    <div class="title">{{ $basics['label'] ?? '' }}</div>
                    @if(!empty($basics['summary']))
                        <div class="basics-summary">{{ $basics['summary'] }}</div>
                    @endif
                </td>
                @if(!empty($basics['image_data']))
                <td class="profile-image-container">
                    <div class="profile-image">
                        <img src="{!! $basics['image_data'] !!}" alt="">
                    </div>
                </td>
                @endif
            </tr>
        </table>
    </div>

    <div class="contact-strip">
        <table class="contact-table">
            <tr>
                <td width="50%" style="vertical-align: top;">
                    @if(!empty($basics['email']))
                        <div class="contact-item"><span class="contact-icon">@</span> {{ $basics['email'] }}</div>
                    @endif
                    @if(!empty($basics['location']['city']))
                        <div class="contact-item"><span class="contact-icon">L</span> {{ $basics['location']['city'] }}{{ !empty($basics['location']['region']) ? ', ' . $basics['location']['region'] : '' }}</div>
                    @endif
                    @if(!empty($basics['profiles']['github']))
                        <div class="contact-item"><span class="contact-icon">git</span> github.com/{{ $basics['profiles']['github'] }}</div>
                    @endif
                </td>
                <td style="vertical-align: top;">
                    @if(!empty($basics['phone']))
                        <div class="contact-item"><span class="contact-icon">#</span> {{ $basics['phone'] }}</div>
                    @endif
                    @if(!empty($basics['profiles']['linkedin']))
                        <div class="contact-item"><span class="contact-icon">in</span> linkedin.com/in/{{ $basics['profiles']['linkedin'] }}</div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <table class="main-table">
            <tr>
                <td class="col-left">
                    <!-- Education -->
                    @if(!empty($education))
                    <div class="section">
                        <h3>Education</h3>
                        @foreach($education as $edu)
                        <div class="section-item" style="margin-bottom: 10px;">
                            @if(!empty($edu['score']))
                                <span class="item-score">{{ $edu['score'] }}</span>
                            @endif
                            <div class="item-title">{{ $edu['studyType'] ?? '' }}</div>
                            <div class="item-subtitle">{{ $edu['institution'] ?? '' }}</div>
                            <div class="item-meta">{{ $edu['startDate'] ?? '' }} - {{ $edu['endDate'] ?? '' }}</div>
                            @if(!empty($edu['area']))
                                <ul class="bullet-list">
                                    <li>{{ $edu['area'] }}</li>
                                </ul>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Personal Projects -->
                    @if(!empty($projects))
                    <div class="section">
                        <h3>Personal Projects</h3>
                        @foreach($projects as $project)
                        <div class="section-item" style="margin-bottom: 12px;">
                            <div class="item-title">{{ $project['name'] ?? '' }} ({{ $project['startDate'] ?? '' }} - {{ $project['endDate'] ?? '' }})</div>
                            <ul class="bullet-list">
                                <li>{{ $project['description'] ?? '' }}</li>
                            </ul>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Work Experience -->
                    @if(!empty($work))
                    <div class="section">
                        <h3>Work Experience</h3>
                        @foreach($work as $exp)
                        <div class="section-item">
                            <div class="item-title">{{ $exp['position'] ?? '' }}</div>
                            <div class="item-subtitle">{{ $exp['company'] ?? '' }}</div>
                            <div class="item-meta">{{ $exp['startDate'] ?? '' }} - {{ $exp['endDate'] ?? '' }}</div>
                            @if(!empty($exp['summary']))
                                <div style="font-size: 8.5pt; text-align: justify;">{{ $exp['summary'] }}</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                </td>

                <td class="col-right">
                    <!-- Skills -->
                    @if(!empty($skills))
                    <div class="section">
                        <h3>Skills</h3>
                        <div class="tag-container">
                            @foreach($skills as $skill)
                                @if(!empty($skill['keywords']))
                                    @foreach($skill['keywords'] as $keyword)
                                        <span class="tag">{{ $keyword }}</span>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Achievements -->
                    @php $validAchievements = array_filter($achievements); @endphp
                    @if(!empty($validAchievements))
                    <div class="section">
                        <h3>Achievements</h3>
                        @foreach($validAchievements as $ach)
                            <div style="font-size: 8.5pt; margin-bottom: 6px; line-height: 1.2;">{{ $ach }}</div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Certificates -->
                    @if(!empty($certificates))
                    @php $validCerts = array_filter($certificates, fn($c) => !empty($c['name'])); @endphp
                    @if(!empty($validCerts))
                    <div class="section">
                        <h3>Certificates</h3>
                        @foreach($validCerts as $cert)
                            <div style="font-size: 9pt; margin-bottom: 6px;">
                                <strong>{{ $cert['name'] }}</strong>
                                @if(!empty($cert['date']))
                                    ({{ $cert['date'] }})
                                @endif
                            </div>
                        @endforeach
                    </div>
                    @endif
                    @endif

                    <!-- Languages -->
                    @if(!empty($languages))
                    <div class="section">
                        <h3>Languages</h3>
                        @foreach($languages as $lang)
                        <div class="lang-item">
                            <span class="lang-name">{{ $lang['language'] ?? '' }}</span><br>
                            <span class="lang-level">{{ $lang['fluency'] ?? '' }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Interests -->
                    @php $validInterests = array_filter($interests); @endphp
                    @if(!empty($validInterests))
                    <div class="section">
                        <h3>Interests</h3>
                        <div class="tag-container">
                            @foreach($validInterests as $interest)
                                <span class="interest-tag">{{ $interest }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
