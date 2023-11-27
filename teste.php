/**
*
*este arquivo e somente para teste de querys 
*
*/
<?php 

try
  { 
    $pdo = new PDO("mysql:host=localhost;dbname=sudomaster", "root", "123");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $conectando = True;
  }
  catch(PDOException $e)
  {
    $conectando = False;
  }
  
##Caso a conexao seja reprovada, exibe na tela uma mensagem de erro
if(!$conectando) die ("
<p align='center'>
<br/>
<b>Banco de dados desconectado!</b>
<br/>
Tente acessar o site dentro de alguns instantes, ou entre em contato!</p>
<br/>
");

//$pdoo = new PDO("mysql:host=localhost;dbname=submaster", "root", "thbomfim");
echo "<br>";

$sql = "SELECT comment FROM sudo_topic WHERE id = :idTopic";
      $stmt = $pdo->prepare($sql);
      $stmt->bindValue(":idTopic", 1);
      $stmt->execute();
      $res = $stmt->fetch();

      

    var_dump($novovalor + $res["comment"] + 1;);
?>