<?php
if (!session_id())
{
    session_start();
}
include_once(__DIR__.'\..\connect.php');
include_once(__DIR__.'\..\roles\rolesFunctions.php');


if (isProf())
{
    $bdd->requete("SELECT * FROM classe JOIN enseigner ON enseigner.id_classe = classe.id WHERE enseigner.id_prof = :id_prof");
    $bdd->bindParam(":id_prof", $_SESSION['user']['id'], PDO::PARAM_INT);
}
else
{
    $bdd->requete("SELECT id AS id_classe, libelle FROM classe");
}
    $bdd->execute();    
    $classes = $bdd->getStmt()->fetchAll(PDO::FETCH_ASSOC);
?>