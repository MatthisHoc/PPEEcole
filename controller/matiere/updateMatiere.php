<?php
    include(__DIR__.'/../commandesBdd.php');

    if (are_set($_POST, array('libelle', 'coef', 'codemat')))
    {
        $params =
        [
            new BindParam('libelle', $_POST['libelle'], PDO::PARAM_STR),
            new BindParam('coef', $_POST['coef'], PDO::PARAM_STR),
        ];
        if (CommandesBdd::updateElement('matiere', $params, [new BindParam('id', $_POST['codemat'], PDO::PARAM_INT)]))
        {  
            redirectFromIndex("controller/matiere/selectMatiere.php");
        }
    }
    else
    {
        echo '<script> alert("Tous les champs ne sont pas remplis"); </script>';
        redirect("empty");
    }
?>