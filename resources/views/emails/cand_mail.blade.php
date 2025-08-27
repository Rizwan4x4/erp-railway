<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Interview Invitation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafc;
            color: #333;
            padding: 30px;
        }

        .email-container {
            /* background-color: #ffffff; */
            padding: 25px 30px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            max-width: 600px;
            margin: auto;
        }

        h2 {
            color: #2c3e50;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999;
            text-align: center;
        }

        p {
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h2>Invitation to Interview</h2>

        <p>Dear {{ $candidate['name'] }},</p>

        <p>
            Thank you for applying for the position of <strong>{{ $candidate['post_title'] }}</strong>.
            We would like to invite you to attend an interview for this position.
        </p>

        <p>
            <strong>Your interview has been scheduled as follows:</strong><br>
            <strong>Date:</strong> {{ \Carbon\Carbon::parse($candidate['date'])->format('F d, Y') }}<br>
            <strong>Time:</strong> {{ $candidate['from'] }} to {{ $candidate['to'] }}<br>
            <strong>Location:</strong> {{ $candidate['location'] }}
        </p>

        @if (!empty($candidate['instructions']))
            <p>
                <strong>Additional Instructions:</strong> {{ $candidate['instructions'] }}
            </p>
        @endif

        <p>
            If you have any questions or need to reschedule, please call me at
             or email me at
            <strong>{{ $candidate['contact_email'] }}</strong>.
        </p>

        <p>Sincerely,<br><br>
            {{ $candidate['contact_person'] }}<br>
            HR Department</p>

        <div class="footer">
            This is an auto-generated email. Please do not reply to this message.
        </div>
    </div>
</body>

</html>
