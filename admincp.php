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
$page = $_GET["page"];
include_once("inc/config.inc.php");
include_once("inc/helpers.inc.php");
include_once("inc/navbar.inc.php");

if (isAdmin() == false) 
{
    echo "Você não é um admin";

    header("Location: index.php");
}else
{
    if ($page == "cpanel") 
    {
        echo "<div class=\"container\">";
       echo "ola ".NAME_USER."";
       echo "</div";    
    }
    
}

?>
    <script src="bootstrap/@popperjs/core/dist/umd/popper.js"></script>
    <script src="bootstrap/dist/js/bootstrap.js"></script>
</body>

</html>