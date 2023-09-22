/**
*
*este arquivo e somente para teste de querys 
*
*/
<?php 
session_start();
include("inc/config.inc.php");

$pdoo = new PDO("mysql:host=localhost;dbname=submaster", "root", "thbomfim");


        $sql = $pdo->prepare("DELETE FROM sudo_topic WHERE id = '1' "); 
        $sql->rowCount();
            
        if ($sql >= 0) {
            echo "seila";
        }else {
            echo "ja nem sei mas..";
        }
        
            /*
            echo"<pre>";
            echo "var_dump($sql)";
            echo "</pre>";
            */
$fcats = $pdo->query("SELECT id, name FROM sudo_fcat ORDER BY position, id")->fetchAll();

//$fcats = $pdo->query("SELECT id FROM sudo_subcat WHERE catid ='2'")->fetch();

//var_dump($fcats);

echo "<br>";
$forums = $pdoo->query("SELECT id, name FROM fun_forums WHERE cid='1' AND clubid='0' ORDER BY position, id, name")->fetch();
//var_dump($forums);

?>