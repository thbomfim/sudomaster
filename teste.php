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

$sql = "SELECT user, user_id, aws, idtopic FROM sudo_aws WHERE commentid = :id";
      $cmd = $pdo->prepare($sql);
      $cmd->bindValue(":id", 1);
      $cmd->execute();
      $result = $cmd->fetchAll();
      
      

    var_dump($result);
    echo "<hr>";

    var_dump($result[0]);
?>