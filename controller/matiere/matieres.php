<?php
include_once(__DIR__.'\..\connect.php');

$bdd->requete("SELECT * FROM matiere");
$bdd->execute();    
$matieres = $bdd->getStmt()->fetchAll(PDO::FETCH_ASSOC);
?>