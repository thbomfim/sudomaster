<?php 
$page = $_GET["page"];
include_once("inc/config.inc.php");
include_once("inc/helpers.inc.php");
include_once("inc/navbar.inc.php");
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <title><?=$title?></title>
</head>

<body>
    <?php 
//verifica se o usuario estar logado
if (!isset($_SESSION['id'])) 
{
    // O usuário não está logado, redirecione para a página de login
    header("Location: index.php");
    exit;
  }

if (isAdmin() == false) 
{
    echo "Você não é um admin";

    header("Location: index.php");
}else
{
    ///Painel Admin
    if ($page == "cpanel") 
    {
        echo "<div class=\"container\">";
       echo "<p class=\"linha1\">ola ".NAME_USER." todas suas ações seram registradas em logs fique ciente</p><br>";

       echo "<a href=\"admincp.php?page=delTopics\">Deletar topico</a><br>";
       echo "<a href=\"admincp.php?page=delSubCats\">Deletar Subcategoria</a><br>";
       echo "<a href=\"admincp.php?page=delCats\">Deletar Categoria</a><br>"; 
       echo "<hr>";
       echo "<a href=\"admincp.php?page=addcats\">Adicionar categorias</a><br>";
       echo "<a href=\"admincp.php?page=addsubcats\">Adicionar Subcategorias</a><br>";
       //echo "<a href=\"admin.php?page=addcat\">Adicionar categorias</a><br>";
       echo "</div>";    
    
    }elseif ($page == "delTopics") 
    {
        $idTopic = $_POST["idTopic"] ?? '';
        echo "<p>Digite o id do Topico</p><br>";
        
        echo "<form action=\"admincp.php?page=delTopic\" method=\"POST\">";
        
        echo "<div class=\"mb-3\">";
        echo "<label for=\"idTopic\">Id:</label>";
        echo "<input type=\"text\" name=\"idTopic\" id=\"idTopic\">";
        echo "</div>";
        echo "<button type=\"submit\" class=\"btn btn-outline-success\">Deletar</button>";
        
        echo "</form>";

    }elseif ($page == "delTopic") 
    {
        $idTopic = $_POST["idTopic"];

        $sql = "DELETE FROM sudo_topic WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id","$idTopic");
        $stmt->execute();

        if ($stmt->rowCount() >= 1) 
        {
            echo "Topico deletado com sucesso!";
        }else 
        {
            echo "Ocoreu um erro";
        }
        
    }elseif ($page == "delSubCats") 
    {
        $idSubCat = $_POST["idSubCat"] ?? '';
        echo "<p>Digite o id do Topico</p><br>";
        
        echo "<form action=\"admincp.php?page=delSubCat\" method=\"POST\">";
        
        echo "<div class=\"mb-3\">";
        echo "<label for=\"idSubCat\">Id:</label>";
        echo "<input type=\"text\" name=\"idSubCat\" id=\"idSubCat\">";
        echo "</div>";
        echo "<button type=\"submit\" class=\"btn btn-outline-success\">Deletar</button>";
        
        echo "</form>";
    }elseif ($page == "delSubCat") 
    {
        $idSubCat = $_POST["idSubCat"];

        $sql = "DELETE FROM sudo_subcat WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id","$idSubCat");
        $stmt->execute();

        if ($stmt->rowCount() >= 1) 
        {
            echo "Topico deletado com sucesso!";
        }else 
        {
            echo "Ocoreu um erro";
        }
    }elseif ($page == "delCats") 
    {
        $idCat = $_POST["idCat"] ?? '';
        echo "<p>Digite o id do Topico</p><br>";
        
        echo "<form action=\"admincp.php?page=delCat\" method=\"POST\">";
        
        echo "<div class=\"mb-3\">";
        echo "<label for=\"idCat\">Id:</label>";
        echo "<input type=\"text\" name=\"idCat\" id=\"idCat\">";
        echo "</div>";
        echo "<button type=\"submit\" class=\"btn btn-outline-success\">Deletar</button>";
        
        echo "</form>";
    }elseif ($page == "delCat") 
    {
        $idCat = $_POST["idCat"];

        $sql = "DELETE FROM sudo_fcat WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":id","$idCat");
        $stmt->execute();

        if ($stmt->rowCount() >= 1) 
        {
            echo "Topico deletado com sucesso!";
        }else 
        {
            echo "Ocoreu um erro";
        }
    }
    elseif ($page == "addcats") 
    {
        echo "<div class=\"container\"><br>";
        echo "<form class=\"gy-2 gx-3 align-items-center\" action=\"admincp.php?page=addcat\" method=\"POST\">";
        echo "<div class=\"mb-3\">";
        echo "<label for=\"nameCat\" class=\"col-sm-2 col-form-label\">Nome da categoria:</label>";
        echo "<input type=\"text\" name=\"nameCat\" id=\"nameCat\"><br>";
        echo "</div>";
        echo "<div class=\"mb-3\">";
        echo "<label for=\"position\">posição da categoria:</label>";
        echo "<input type=\"number\" name=\"position\" id=\"position\"><br>";
        echo "</div>";
        echo "<button type=\"submit\" class=\"btn btn-outline-primary\">Adicionar categoria</button>";
        echo "</div>";
    }
    elseif ($page == "addcat") 
    {
        $nameCat = $_POST["nameCat"];
        $position = $_POST["position"];

        if (empty($nameCat)) 
        {
            echo "Digite o nome da categoria";
        }elseif (empty($position)) 
        {
            echo "Digite a posição da categoria";
        }else 
        {
            $sql = "INSERT INTO sudo_fcat (name, position) VALUES(:name, :position)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":name", $nameCat);
            $stmt->bindValue(":position", $position);
            $stmt->execute();

            echo "Categoria adicionada!";
        }
    }elseif ($page == "addsubcats") 
    {
        
        echo "<div class=\"container\"><br>";
        echo "<form class=\"gy-2 gx-3 align-items-center\" action=\"admincp.php?page=addsub1cat\" method=\"POST\">";
        echo "<div class=\"mb-3\">";
        echo "<label for=\"nameCat\" class=\"col-sm-2 col-form-label\">Nome da categoria:</label>";
        echo "<input type=\"text\" name=\"nameSubCat\" id=\"nameSubCat\"><br>";
        echo "</div>";
        echo "<div class=\"mb-3\">";
        $option = $pdo->query("SELECT id,name FROM sudo_fcat");
        while ($options = $option->fetch()) {
        echo "<select class=\"form-select form-select-lg mb-3\" aria-label=\"Large select example\">";
        echo "<option selected>selecione</option>";
            echo "<option value=\"\" name=\"catid\">$options[1]</option>";
            echo "</select>";

        }
        echo "<div class=\"mb-3\">";
        echo "<label for=\"position\">posição da categoria:</label>";
        echo "<input type=\"number\" name=\"position\" id=\"position\"><br>";
        echo "</div>";
        echo "<button type=\"submit\" class=\"btn btn-outline-primary\">Adicionar categoria</button>";
        echo "</div>";
    }elseif ($page == "addsubcat") 
    {
        $nameSubCat = $_POST["nameSubCat"];
        $catid = $_POST["catid"];
        $position = $_POST["position"];

        if (empty($nameSubCat)) 
        {
            echo "Digite o nome da categoria";
        }elseif (empty($position)) 
        {
            echo "Digite a posição da categoria";
        }else 
        {
            $sql = "INSERT INTO sudo_subcat (name, position) VALUES(:name, :position)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":name", $nameSubCat);
            $stmt->bindValue(":position", $position);
            $stmt->execute();

            echo "Categoria adicionada!";
        }
    }
    
}

?>
    <script src="bootstrap/@popperjs/core/dist/umd/popper.js"></script>
    <script src="bootstrap/dist/js/bootstrap.js"></script>
</body>

</html>