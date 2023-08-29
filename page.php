<?php 
include("inc/config.inc.php");

session_start();
$page = $_GET["page"] ?? '';

//verifica se o usuario estar logado
if (!isset($_SESSION['id'])) {
    // O usuário não está logado, redirecione para a página de login
    echo "Voce nao esta logado <a href=\"index.php\">Fazer login</a>";
    exit;
  }

if($page == "main") {

  echo "ola <strong>$_SESSION[user]</strong>";
}

?>