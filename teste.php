/**
*
*este arquivo e somente para teste de querys 
*
*/
<?php 
session_start();
include("inc/config.inc.php");

//$pdoo = new PDO("mysql:host=localhost;dbname=submaster", "root", "thbomfim");


        $sql = $pdo->query("SELECT id, name FROM sudo_subcat");

        while ($sqls = $sql->fetch()) {
            echo "$sqls[0]";
            echo "$sqls[1]";
        }

?>