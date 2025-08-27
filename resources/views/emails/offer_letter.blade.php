<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Offer Letter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            padding: 40px;
            line-height: 1.7;
        }
        .header, .footer {
            margin-bottom: 20px;
        }
        .signature {
            margin-top: 50px;
        }
        .company-info {
            font-size: 14px;
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="company-info">
        <strong>{{ $offer['company_name'] }}</strong><br>
        {{ $offer['company_address'] }}<br>
        {{ $offer['company_city'] }}<br>
        {{ $offer['company_phone'] }}<br>
        <br>
        <strong>Date:</strong> {{ $offer['date'] }}
    </div>

    <div class="recipient-info">
        <strong>{{ $offer['candidate_name'] }}</strong><br>
        {{ $offer['email'] }}
    </div>

    <p>Dear {{ $offer['candidate_name'] }},</p>

    <p>
        We are pleased to offer you the position of <strong>{{ $offer['post_title'] }}</strong>
        in the <strong>{{ $offer['department'] }}</strong> department at {{ $offer['company_name'] }}.
    </p>

    <p>
        If you accept this offer, your starting salary will be <strong>PKR {{ number_format($offer['salary']) }}</strong>.
        Your official start date will be <strong>{{ $offer['start_date'] }}</strong>.
    </p>

    <p>
        Please confirm your acceptance of this offer by <strong>{{ $offer['response_deadline'] }}</strong>.
        Upon confirmation, your hire date will be considered as <strong>{{ $offer['hire_date'] }}</strong>.
    </p>

    <p>
        You will report to <strong>{{ $offer['reporting_person'] }}</strong>. If you have any questions
        or require further information, feel free to contact us at <a href="mailto:{{ $offer['contact_email'] }}">{{ $offer['contact_email'] }}</a>
        or call us at {{ $offer['contact_phone'] }}.
    </p>

    <p>We look forward to having you on our team and wish you a successful journey with us.</p>

    <div class="signature">
        Sincerely,<br>
        {{ $offer['sender_name'] }}<br>
        {{ $offer['sender_title'] }}<br>
        {{ $offer['company_name'] }}
    </div>

</body>
</html>
