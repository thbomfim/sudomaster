<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<?php 
include("inc/config.inc.php");
include("inc/helpers.inc.php");
include("inc/navbar.inc.php");

if (isAdmin() == false) {
    echo "Você não é um admin";

    header("Location: index.php");
}else{
    echo "ola ".NAME_USER."";
    
}

?>
        <script src="bootstrap/@popperjs/core/dist/umd/popper.js"></script>
        <script src="bootstrap/dist/js/bootstrap.js"></script>
</body>
</html>