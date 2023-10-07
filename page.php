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
    < class="container">
        <div class="comtainer-fluid p-2 mb-2 bg-primary rounded">Forum</div>
        <?php
    echo "ola <strong> ".NAME_USER." </strong><br>";
    $fcats = $pdo->query("SELECT id, name FROM sudo_fcat ORDER BY position, id");
    while ($fcat = $fcats->fetch()) {
        $fcatlink = "<a href=\"page.php?page=viewsubcat&fcat=$fcat[0]\">$fcat[1]</a><br>";
        echo "$fcatlink";
    }
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
    ?>
        <div class="container text-center">
            <div class="col align-self-end">
                <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom"><span
                        class="material-symbols-rounded">note_add</span></button>

                <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom"
                    aria-labelledby="offcanvasBottomLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasBottomLabel">Crie seu novo topico</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body small">
                        ...
                    </div>
                </div>
            </div>
        </div>
        <?php
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
  }elseif ($page == "createtopic") 
  {
    # code...
  }
  
  ?>
        <script src="bootstrap/@popperjs/core/dist/umd/popper.js"></script>
        <script src="bootstrap/dist/js/bootstrap.js"></script>

</body>

</html>