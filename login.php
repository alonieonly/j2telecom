<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style-geral.css">
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="container-login">
        <img src="assets/logo.jpg" alt="" class="logo">
        <div class="form">
            <form class="form-pass" method="post">
                <spam class="login-label">Login</spam>
                <input type="text" class="login" name="user">
                <spam class="pass-label">Senha</spam>
                <input type="password" class="pass" name="pass">
                <a href="home.php" type="submit" name="acao" value="logar" class="send-button"></a>
            </form>
        </div>
    </div>
</body>
</html>