<?php
    include(__DIR__."\..\commandesBdd.php");
    $var = json_encode(CommandesBdd::getProfMatiere($_GET['id_classe'], $_GET['id_matiere']));
    echo $var;
?>