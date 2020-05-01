<?php
    include(__DIR__.'/../commandesBdd.php');

    if(isset($_POST['libelle']))
    {
        $params = 
        [
            new BindParam('libelle', $_POST['libelle'], PDO::PARAM_STR),
        ];
        if(CommandesBdd::insertElement('classe', $params)) { redirect("empty"); }
    }
    else
    {
        echo '<script> alert("Tous les champs ne sont pas remplis"); </script>';
        redirectFromIndex("formulaire/formulaireClasse.php");
    }
?>