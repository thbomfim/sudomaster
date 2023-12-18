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
include_once "../config/config.inc.php";

//session_start();
$page = $_GET["page"] ?? '';
include_once "../config/navbar.inc.php";

//verifica se o usuario estar logado
if (!isset($_SESSION['id'])) 
{
    // O usuário não está logado, redirecione para a página de login
    echo "Voce nao esta logado <a href=\"index.php\">Fazer login</a>";
    exit;
  }
  
    ////Pagina do forum 
  if ($page == "viewsubcat") 
  {
    $fcat = $_GET["fcat"];
    $idTopic = $_GET["idTopic"] ?? '';
    
    $sql = "SELECT id, name FROM sudo_subcat WHERE catid = :fcat ORDER BY position, id, name";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":fcat","$fcat");
    $stmt->execute(); 
    
    while ($fsubcat = $stmt->fetch()) {
      echo "<div class=\"container\">";
      $fsubcatlink = "<a href=\"?page=viewtopics&idTopic=$fsubcat[0]\">$fsubcat[1]</a><br>";
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

    echo "<div class=\"container\">";
    while ($tid = $stmt->fetch()) {

        echo "<a href=\"?page=viewtopic&idTopic=$tid[0]\"><div class=\"linha1\">$tid[2]</div><a/><br>";
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

    $sql = "SELECT user_id FROM sudo_votes WHERE idtopic = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", "$idTopic");
    $stmt->execute();
    $res = $stmt->fetch();

    if ($res["user_id"] ?? '' == getIdUser()) {
      echo "Desvotar";
    } else{
    echo "<a href=\"?page=voting&idTopic=$idTopic\">votar</a>";
    }
    echo "Titulo: $ftopic[0]<br>";
    echo "Texto: $ftopic[1]";

    if ($ftopic[2] == getNameUser() OR isAdmin()) 
    {
    echo "<a href=\"?page=editTopics&idTopic=$idTopic\"><span class=\"material-symbols-outlined\">
    edit
    </span></a>";
    }
    echo "<hr><br>";
    echo "<form class=\"gy-2 gx-3 align-items-center\" action=\"?page=comment\" method=\"POST\">";
    echo "<div class=\"mb-3\">";
        echo "<label for=\"titleTopic\">Titulo do topico: </label>";
        echo "<input class=\"form-control\" type=\"text\" name=\"comment\" id=\"title\"><br>";
        echo"<input type=\"hidden\" id=\"idTopic\" name=\"idTopic\" value=\"$idTopic\" />";
        echo "</div>";
        echo "<button type=\"submit\" class=\"btn btn-outline-primary\">Comentar</button>";
        echo "</form><br>";

    $sql = "SELECT id, user, comment, idtopic FROM sudo_comments WHERE idtopic = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", "$idTopic");
    $stmt->execute();

    
    while ($res = $stmt->fetch()) {
      echo "$res[user]: ";
      echo "$res[comment] <a href=\"?page=awss&awsId=$res[id]&idTopic=$idTopic\">Responder</a><br>";
      
      $sql = "SELECT user, user_id, aws, idtopic, commentid FROM sudo_aws WHERE commentid = :id";
      $cmd = $pdo->prepare($sql);
      $cmd->bindValue(":id", "$res[id]");
      $cmd->execute();
      
      if (count($cmd->fetchAll()) >= 1) 
      {
      echo "<span class=\"aws\">";
      echo "$cmd[aws]</span>";
      }
      echo "<hr>";
    }

    echo "</div>";

  }elseif ($page == "newtopics") 
  {
    $tid = $_GET["tid"];

    echo "<div class=\"container\">";
      
    echo "<form class=\"gy-2 gx-3 align-items-center\" action=\"?page=newtopic\" method=\"POST\">";
    echo "<div class=\"mb-3\">";
        echo "<label for=\"titleTopic\">Titulo do topico: </label>";
        echo "<input type=\"text\" name=\"title\" id=\"title\"><br>";
        echo "</div>";

        echo "<div class=\"mb-3\">";
        echo "<label for=\"content\">Conteudo do topico: </label>";
        echo "<input type=\"text\" name=\"content\" id=\"content\"><br>";
        echo "</div>";

        echo "<div class=\"mb-3\">";
        $option = $pdo->query("SELECT id,name,catid FROM sudo_subcat");
        echo "<select class=\"form-select form-select-lg mb-3\" aria-label=\"Large select example\" name=\"tid\">";
        echo "<option selected>selecione</option>";
        while ($options = $option->fetch()) {
            echo "<option value=\"$options[2]\">$options[1]</option>";
        }
        echo "</select>";
        echo "</div>";
        echo "<button type=\"submit\" class=\"btn btn-outline-primary\">Adicionar categoria</button>";
        echo "</form>";
        echo "</div>";

    echo "</div>";
  }elseif ($page == "newtopic") 
  {

    $title = $_POST["title"];
    $content = $_POST["content"];
    $tid = $_POST["tid"]; 

    $sql = "INSERT INTO sudo_topic (author, title, content, datecreate, tid) VALUES(:author, :title, :content, :datecreate, :tid)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":author", getNameUser());
    $stmt->bindValue(":title", $title);
    $stmt->bindValue(":content", $content);
    $stmt->bindValue(":datecreate", date('d/m/Y'));
    $stmt->bindValue(":tid", $tid);
    $stmt->execute();

    echo "<div class=\"container\">";
    if ($stmt == true) {
      echo "topico adicionado";
    }else {
      echo "ocoreu algum erro";
    }
    echo "</div>";
    ///pagina de editar topico
  }elseif ($page == "editTopics") 
  {
    $idTopic = $_GET["idTopic"];

      $sql = "SELECT author, title, content FROM sudo_topic WHERE id = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(":id", "$idTopic");
      $stmt->execute();
      $res = $stmt->fetch();

      $tname = htmlspecialchars($res[1]);
      $tcontent = htmlspecialchars($res[2]);
    
    echo "<div class=\"container\">";

    echo "<form class=\"gy-2 gx-3 align-items-center\" action=\"?page=editTopic&idTopic=$idTopic\" method=\"POST\">";

    echo "<div class=\"mb-3\">";
        echo "<label for=\"titleTopic\" class=\"col-form-label\">Titulo do topico: </label>";
        echo "<input type=\"text\" class=\"form-control\" id=\"exampleFormControlInput1\" name=\"tname\" value=\"$tname\" id=\"title\"><br>";
        echo "</div>";

        echo "<div class=\"mb-3\">";
        echo "<label for=\"content\" class=\"col-from-label\">Conteudo do topico: </label>";
        echo "<textarea class=\"form-control\" id=\"exampleFormControlTextarea1\" rows=\"3\" name=\"tcontent\" id=\"content\">$tcontent</textarea><br>";

        echo "<button type=\"submit\" class=\"btn btn-outline-primary\">Salvar</button>";

        echo "</form>";
        echo "</div>";

    echo "</div>";
    //pagina que envia os dados para editar os topicos
  }elseif ($page == "editTopic")
  {
    $idTopic = $_GET["idTopic"];
    $tname = $_POST["tname"];
    $tcontent = $_POST["tcontent"];

    $sql = "UPDATE sudo_topic SET title= :title, content= :content WHERE id= :idtopic";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":title", "$tname");
    $stmt->bindValue(":content", "$tcontent");
    $stmt->bindValue(":idtopic", "$idTopic");
    $stmt->execute();

    $res = $stmt->rowCount();

    if($res >=1) 
    {
      echo "topico editado com sucesso!";
    }else
    {
      echo "Ocorreu algum erro!";
    }


  }elseif ($page == "voting") {
    
    $idTopic = $_GET["idTopic"];
    
    //verifica se o usuario ja votou no topico
    $sql = "SELECT user_id FROM sudo_votes WHERE idtopic = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":id", "$idTopic");
    $stmt->execute();

    $res = $stmt->fetch();

    if ($res["user_id"] ?? '' == getIdUser()) {
      echo "Você já votou neste tópico";
    }else{
      //buscar o valor total de votos para atualizar
      $sql = "SELECT vote FROM sudo_topic WHERE id = :idtopic";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(":idtopic", "$idTopic");
      $stmt->execute();
      $res = $stmt->fetch();
      
      //aqui irá pegar o valor e atualizar por mas 1
      $novoValor = $res["vote"] + 1;

      //agora irá inserir o novo valor
      $sql = "UPDATE sudo_topic SET vote = :voto WHERE id = :idtopic";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(":voto", "$novoValor");
      $stmt->bindValue(":idtopic", "$idTopic");
      $stmt->execute();

      $sql = "INSERT INTO sudo_votes (user, user_id, idtopic) VALUES (:user, :user_id, :idtopic)";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(":user", getNameUser());
      $stmt->bindValue(":user_id", getIdUser());
      $stmt->bindValue(":idtopic", "$idTopic");
      $stmt->execute();
      $res = $stmt->rowCount();

      if ($res >= 1) {
        echo "Voto adicionado!";
      }else{
        echo "ocoreu algum erro";
      }
    }
  }elseif ($page == "comment") 
  {
    $idTopic = $_POST["idTopic"];
    $comment = $_POST["comment"];

    $sql = "INSERT INTO sudo_comments (user, user_id, comment, idtopic) VALUES (:user, :id, :comment, :idtopic)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":user",getNameUser());
    $stmt->bindValue(":id", getIdUser());
    $stmt->bindValue(":comment", "$comment");
    $stmt->bindValue(":idtopic", "$idTopic");
    $stmt->execute();
    $res = $stmt->rowCount();

    if($res >= 1) 
    {
      //busca o valor total de comentarios no topico
      $sql = "SELECT comment FROM sudo_topic WHERE id = :idTopic";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(":idTopic", "$idTopic");
      $stmt->execute();
      $res = $stmt->fetch();

      $novovalor = $res["comment"] + 1;

      //atualizar o novo valor 
      $sql = "UPDATE sudo_topic SET comment = :comment WHERE id = :idTopic";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(":comment","$novovalor");
      $stmt->bindValue(":idTopic", "$idTopic");
      $stmt->execute();

      echo "Comentario adicionado!";
    }else{
      echo "Ocorreu algum erro";
    }
  }elseif ($page == "awss") {
    $idTopic = $_GET["idTopic"];
    $awsId = $_GET["awsId"];

    echo "<div class=\"container\">";

    echo "<form class=\"gy-2 gx-3 align-items-center\" action=\"?page=aws\" method=\"POST\">";

    echo "<div class=\"mb-3\">";
        echo "<label for=\"titleTopic\" class=\"col-form-label\">Resposta: </label>";
        echo "<input type=\"text\" class=\"form-control\" id=\"exampleFormControlInput1\" name=\"aws\" id=\"resposta\"><br>";
        echo "<input type=\"hidden\" id=\"awsId\" name=\"awsId\" value=\"$awsId\" />";
        echo "<input type=\"hidden\" id=\"idTopic\" name=\"idTopic\" value=\"$idTopic\" />";
        echo "</div>";

        echo "<button type=\"submit\" class=\"btn btn-outline-primary\">Enviar</button>";

        echo "</form>";
        echo "</div>";

  
  }elseif ($page == "aws") 
  {
    $idTopic = $_POST["idTopic"];
    $awsId = $_POST["awsId"];
    $aws = $_POST["aws"];

    $sql = "INSERT INTO sudo_aws (user, user_id, aws, commentid, idtopic) VALUES(:user, :user_id, :aws, :commentid, :idtopic)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":user", getNameUser());
    $stmt->bindValue(":user_id", getIdUser());
    $stmt->bindValue("aws", "$aws");
    $stmt->bindValue(":commentid","$awsId");
    $stmt->bindValue(":idtopic", "$idTopic");
    $stmt->execute();
    $res = $stmt->rowCount();

    if ($res >= 1) {

      //busca o valor total de comentarios no topico
      $sql = "SELECT comment FROM sudo_topic WHERE id = :idTopic";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(":idTopic", "$idTopic");
      $stmt->execute();
      $res = $stmt->fetch();

      $novovalor = $res["comment"] + 1;

      //atualizar o novo valor 
      $sql = "UPDATE sudo_topic SET comment = :comment WHERE id = :idTopic";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(":comment","$novovalor");
      $stmt->bindValue(":idTopic", "$idTopic");
      $stmt->execute();

      echo "Resposta adicionado!";
    }else{
      echo "Ocorreu algum erro";
    }
  }elseif ($page == "")
  {

  }
  ?>
    <script src="../bootstrap/@popperjs/core/dist/umd/popper.js"></script>
    <script src="../bootstrap/dist/js/bootstrap.js"></script>

</body>

</html>