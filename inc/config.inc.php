<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
ini_set("memory_limit", "256M");
##Hora local 
date_default_timezone_set("Brazil/East");

  /**
  * Conexao com o servidor
  */
  try
  { 
    $pdo = new PDO("mysql:host=localhost;dbname=sudomaster", "root", "thbomfim");
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
<img src='' alt='*'/>
<br/>
<b>Banco de dados desconectado!</b>
<br/>
<br/>
Tente acessar o site dentro de alguns instantes, ou entre em contato!</p>
<br/>
");
?>