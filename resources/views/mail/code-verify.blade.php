<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifique seu Endereço de Email</title>
</head>
<body>
    <h1>Verifique seu Endereço de Email</h1>
    <p>Obrigado por se registrar! </p>
    <p>Por favor, utilize o seguinte código para verificar seu endereço de email:</p>
    <p><strong>{{ $user->code_verify }}</strong></p>
    <p>Se você não se registrou para uma conta, por favor, ignore este email.</p>
</body>
</html>
