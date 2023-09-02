<?php 
include("inc/config.inc.php");

$user = $_POST["user"];
$password = $_POST["password"];

//verificar se foi preenchido os campos usuario e senha

if (empty($user) || empty($password)) {
    echo'Todos os campos devem ser preenchidos <br>';
    echo '<a href="index.php">Voltar ao login</a>';
    exit;
}

$sql = "SELECT * FROM sudo_users WHERE user = :user AND password = :pass";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":user", $user);
$stmt->bindParam(":pass", $password);
$stmt->execute();

//verificar se o usuario exister
if ($stmt->rowCount() === 0) {
    echo 'Usuario ou senha invalidos<br>';
    echo '<a href="index.php">Voltar ao login</a>';
    exit;
}

//obtendo info do usuario
$row = $stmt->fetch(PDO::FETCH_ASSOC);

session_start();
$_SESSION["id"] = $row["id"];
$_SESSION["user"] = $row["user"];

header("Location: page.php?page=main");
?>