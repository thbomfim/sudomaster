<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200/">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <title>SudoMaster</title>
</head>

<body>

    <?php 
include_once("inc/config.inc.php");

//session_start();
$page = $_GET["page"] ?? '';
include("inc/navbar.inc.php");

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
        <div class="comtainer-fluid p-2 mb-2 bg-primary rounded">Forum</div>
        <?php
    echo "ola <strong> ".NAME_USER." </strong><br>";
    $fcats = $pdo->query("SELECT id, name FROM sudo_fcat ORDER BY position, id");
    while ($fcat = $fcats->fetch()) {
        $fcatlink = "<a href=\"page.php?page=viewsubcat&fcat=$fcat[0]\">$fcat[1]</a><br>";
        echo "$fcatlink";
    }
    echo "</div>";
    ////Pagina do forum 
  }elseif ($page == "viewsubcat") 
  {
    $fcat = $_GET["fcat"];
    $idTopic = $_GET["idTopic"] ?? '';
    
    $sql = "SELECT id, name FROM sudo_subcat WHERE catid = :fcat ORDER BY position, id, name";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":fcat","$fcat");
    $stmt->execute(); 
    
    while ($fsubcat = $stmt->fetch()) {
      echo "<div class=\"container\">";
      $fsubcatlink = "<a href=\"page.php?page=viewtopics&idTopic=$fsubcat[0]\">$fsubcat[1]</a><br>";
      echo "$fsubcatlink";
      echo "</div>";
    }
    ////Pagina de subcategorias do forum
  }elseif ($page == "viewtopics") 
  {
    $idTopic = $_GET["idTopic"] ?? '';
    
    $sql = "SELECT id, author, title FROM sudo_topic WHERE tid = :tid ORDER BY id, title";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":tid","$idTopic");
    $stmt->execute();
    
    $sql2 = "SELECT * FROM sudo_topic WHERE tid = :tid";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->bindParam(":tid",$idTopic);
    $stmt2->execute();

    echo "<div class=\"container\">";
    echo "<a href=\"?page=createtopics\">Criar novo topico</a>";
    while ($tid = $stmt->fetch()) {
      if ($stmt2->columnCount() == 0) {
        echo "Nada por aqui";
      }else{
        echo "<a href=\"page.php?page=viewtopic&idTopic=$tid[0]\">$tid[2]<a/><br>";
    }
  }
  echo "</div>";
    echo "</div>";
  ////Pagina dos topicos
  }elseif ($page == "viewtopic") 
  {
    echo "<div class=\"container\">";
    $idTopic = $_GET["idTopic"] ?? '';

    $ftopics = $pdo->prepare("SELECT title, content, author, datecreate FROM sudo_topic WHERE id= :idTopic");
    $ftopics->bindValue(":idTopic", "$idTopic");
    $ftopics->execute();
    $ftopic = $ftopics->fetch();

    echo "Titulo: $ftopic[0]<br>";
    echo "Texto: $ftopic[1]";
    //echo "Titulo: $ftopics[0]";
    echo "</div>";
  }elseif ($page == "createtopics") 
  {
    echo "<div class=\"container\">";
      
    echo "<form class=\"gy-2 gx-3 align-items-center\" action=\"?page=createtopic\" method=\"POST\">";
    echo "<div class=\"mb-3\">";
        echo "<label for=\"titleTopic\">Titulo do topico: </label>";
        echo "<input type=\"text\" name=\"titleTopic\" id=\"titleTopic\"><br>";
        echo "</div>";

        echo "<div class=\"mb-3\">";
        echo "<label for=\"content\">Conteudo do topico: </label>";
        echo "<input type=\"text\" name=\"cantent\" id=\"content\"><br>";
        echo "</div>";

        echo "<button type=\"submit\" class=\"btn btn-outline-primary\">Adicionar categoria</button>";
        echo "</div>";

    echo "</div>";
  }elseif ($page == "createtopic") {

    $title = $_POST["title"];
    $content = $_POST["content"];

    $sql = "INSERT INTO sudo_topic (author, title, content, tid) VALUES(:author, :title, :content, :tid)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":author", ".NAMER_USER.");
    $stmt->bindValue(":tilte", $titleTopic);
    $stmt->bindValue(":content", $content);
    $stmt->bindValue(":tid", $tid);
    $stmt->execute();

    if ($stmt == "true") {
      echo "topico adicionado";
    }else {
      echo "ocoreu algum erro";
    }
  }
  
  ?>
        <script src="bootstrap/@popperjs/core/dist/umd/popper.js"></script>
        <script src="bootstrap/dist/js/bootstrap.js"></script>

</body>

</html>