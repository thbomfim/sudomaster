<?php 
//session_start();
include ("config.inc.php");

function getIdUser() 
{
    global $pdo;

    $sql = "SELECT id FROM sudo_users WHERE id = :iduser";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":iduser", ID_USER);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row["id"];
}

function getNameUser() 
{
    global $pdo;

    $sql = "SELECT user FROM sudo_users WHERE id = :iduser";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":iduser", getIdUser());
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row["user"];

}

function isAdmin() 
{
    global $pdo;

    $sql = "SELECT perm FROM sudo_users WHERE id = :iduser";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":iduser", getIdUser());
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin["perm"] == '1') 
    {
    
        return true;
    }else 
    {
        return false;
    }


}

function isMod() 
{
    global $pdo;
    
    $sql = "SELECT perm FROM sudo_users WHERE id = :iduser";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":iduser", getIdUser());
    $stmt->execute();
    $mod = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($mod["perm"] == '1' OR $mod["perm"] =='2') {
        
        return true;
    }else 
    {
        return false;
    }


}


?>