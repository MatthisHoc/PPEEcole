<?php
    include(__DIR__.'/../commandesBdd.php');

    if(CommandesBdd::deleteElement('cours', new BindParam('id', $_GET['id'], PDO::PARAM_INT)))
    { 
        redirect("empty");
    }
?>