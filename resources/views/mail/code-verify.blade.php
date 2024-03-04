<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
</head>
<body>
    <h1>Verify Your Email Address</h1>
    <p>Thank you for registering! Please use the following code to verify your email address:</p>
    <p><strong>{{ $user->code_verify }}</strong></p>
    <p>If you did not register for an account, please ignore this email.</p>
</body>
</html>
