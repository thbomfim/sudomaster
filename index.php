<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/dist/css/style.css">
    <title>SudoMaster</title>
</head>

<body>
    <h1>Login</h1>
    <form action="login.php" method="post">
        <div class="mb-3">
            <label for="usuario">Nome de usuario</label>
            <input type="text" name="user">
        </div>
        <div class="mb-3">
            <label for="password">senha</label>
            <input type="password" name="password" id=""><br>
            <button type="submit" class="btn btn-outline-success">Fazer login</button>
        </div>
    </form>
    <br>
    <a href="register.php">Faça o seu cadatro</a>

    <script src="bootstrap/@popperjs/core/dist/umd/popper.js"></script>
    <script src="bootstrap/dist/js/bootstrap.js"></script>
</body>

</html>