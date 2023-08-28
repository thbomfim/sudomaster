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
    <h1>Reristro</h1>
    <br>
    <form action="registeruser.php" method="post">
        <div class="mb-3">
            <label for="user">usuario:</label>
            <input type="text" name="user" id="">
        </div>
        <div class="mb-3">
            <label for="password">Senha:</label>
            <input type="password" name="password" id="">
        </div>
        <div class="mb-3">
            <label for="PasswordComfirm">Comfirme a senha:</label>
            <input type="password" name="PasswordComfirm" id="">
        </div>
        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="">
        </div>
        <button type="submit" class="btn btn-outline-success">Cadastrar</button>
    </form>

    <script src="bootstrap/@popperjs/core/dist/umd/popper.js"></script>
    <script src="bootstrap/dist/js/bootstrap.js"></script>
</body>

</html>