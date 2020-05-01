<?php
    include_once(__DIR__.'\..\connect.php');

    class Roles
    {
        static $Etudiant = "ROLE_ETUDIANT";
        static $Prof = "ROLE_PROF";
        static $Admin = "ROLE_ADMIN";
    }

    $bdd->requete("SELECT * FROM roles WHERE id <> 'ROLE_ADMIN'");
    $bdd->execute();    
    $roles = $bdd->getStmt()->fetchAll(PDO::FETCH_ASSOC);
?>