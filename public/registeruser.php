<?php 
include("../config/config.inc.php");


$user = $_POST["user"] ?? '';
$password = $_POST["password"] ?? '';
$PasswordComfirm = $_POST["PasswordComfirm"] ?? '';
$email = $_POST["email"] ?? '';

if(empty($user)) {
    echo'Digite um usuario';
}
elseif (empty($password)) {
    echo'Coloque uma senha';
}
elseif (empty($PasswordComfirm)) {
    echo'Comfirme sua senha';
}
elseif ($password!=$PasswordComfirm) {
    echo 'senhas nao confere!';
}
elseif (empty($email)) {
    echo'Digite um email';
}
else{
    $sql = " INSERT INTO sudo_users (user, pass, email) VALUES (:user, :pass, :email)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':pass', $password);
    //$stmt->bindParam(':passcomfirm', $PasswordComfirm);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    echo "Cadastro realizado com sucesso!";

}
?>