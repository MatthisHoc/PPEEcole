<?php
    include(__DIR__.'/../commandesBdd.php');

    if(are_set($_POST, ['libelle', 'coef']))
    {
        $params = 
        [
            new BindParam('libelle', $_POST['libelle'], PDO::PARAM_STR),
            new BindParam('coef', $_POST['coef'], PDO::PARAM_INT)
        ];
        if(CommandesBdd::insertElement('matiere', $params)) { redirectFromIndex("controller/matiere/selectMatiere.php"); }
    }
    else
    {
        echo '<script> alert("Tous les champs ne sont pas remplis"); </script>';
        redirect("formulaire/formulaireMatiere.php");
    }
?>