<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Rejected</title>
</head>
<body>
    <p>Hello {{ $name }},</p>

    <p>
        Thank you for applying. After careful consideration,
        we regret to inform you that your application has been rejected.
    </p>

    <p>
        <strong>Reason:</strong><br>
        {{ $reason }}
    </p>

    <p>
        Best regards,<br>
        HR Team
    </p>
</body>
</html>
