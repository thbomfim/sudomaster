/**
*
*este arquivo e somente para teste de querys 
*
*/
<?php 
session_start();
include("inc/config.inc.php");

$pdoo = new PDO("mysql:host=localhost;dbname=submaster", "root", "thbomfim");


$tinfo = $pdoo->query("SELECT name, text, authorid, crdate, views, fid, pollid from fun_topics WHERE id='1'")->fetch();   

echo "<pre>nome: $tinfo[0]<br>
      texto: $tinfo[1]<br>
      views: $tinfo[2]<br></pre>";
echo "$tnm";

$fcats = $pdo->query("SELECT id, name FROM sudo_fcat ORDER BY position, id")->fetchAll();

//$fcats = $pdo->query("SELECT id FROM sudo_subcat WHERE catid ='2'")->fetch();

var_dump($fcats);

echo "<br>";
$forums = $pdoo->query("SELECT id, name FROM fun_forums WHERE cid='1' AND clubid='0' ORDER BY position, id, name")->fetch();
var_dump($forums);

?>