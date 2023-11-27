<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200/">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../app/css/style.css">
    <title>SudoMaster</title>
</head>
<body>
<?php 

include_once("../config/config.inc.php");


//session_start();
$page = $_GET["page"] ?? '';
include("../config/navbar.inc.php");

//verifica se o usuario estar logado
if (!isset($_SESSION['id'])) {
    // O usuário não está logado, redirecione para a página de login
    echo "Voce nao esta logado <a href=\"index.php\">Fazer login</a>";
    exit;
  }
  ///pagina home pricipal
  if($page == "main") 
  {
    $fcat = $_GET["fcat"] ?? '';
    ?>
    <div class="container">
        <a href="forum.php?page=newtopics" class="center">crie um tópico</a><br>
        <?php
    echo "ola <strong> ".NAME_USER."</strong><br>";
    $fcats = $pdo->query("SELECT id, name FROM sudo_fcat ORDER BY position, id");
    while ($fcat = $fcats->fetch()) {
        $fcatlink = "<a href=\"forum.php?page=viewsubcat&fcat=$fcat[0]\">$fcat[1]</a>";
        echo "<div class=\"linha1\">$fcatlink</div><br>";
    }
  }
  ?>
    </div>
     <script src="../bootstrap/@popperjs/core/dist/umd/popper.js"></script>
     <script src="../bootstrap/dist/js/bootstrap.js"></script>

</html>
</body>
