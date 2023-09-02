<?php 
session_start();
include("inc/config.inc.php");

function buscarId() {
    global $pdo;
    $sql = $pdo->query("SELECT id FROM sudo_users WHERE id='".$_SESSION['id']."'")->fetch();

    return $sql[0];
}
echo buscarId();
echo "<br>";
$sql = $pdo->query("SELECT id FROM sudo_users WHERE id='".$_SESSION['id']."'")->fetch();

print_r($sql[0]);

//echo "$sql";
echo "<br>";
function get_user_id() {
    global $pdo;
    // Verifique se o usuário está logado
    if (!isset($_SESSION['id'])) {
      // O usuário não está logado, redirecione para a página de login
      header("Location: login.php");
      exit;
    }
  
    
    // Selecione o usuário do banco de dados
    $sql = "SELECT id FROM sudo_users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $_SESSION['id']);
    $stmt->execute();
  
    // Obtenha o ID do usuário
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // Retorne o ID do usuário
    return $row['id'];
  }

  echo get_user_id();


echo "<br>";
echo "<pre>";
var_dump($_SESSION["user"]);
echo "</pre>";

?>