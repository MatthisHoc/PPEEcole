<?php
    include(__DIR__."/../commandesBdd.php");

    if(isset($_POST['id']))
    {
        $params =
        [
            new BindParam('libelle', $_POST['libelle'], PDO::PARAM_STR),
        ];

        if (
        CommandesBdd::updateElement('classe', $params, [new BindParam('id', $_POST['id'], PDO::PARAM_INT)]))
        {
            redirectFromIndex('controller/classe/selectClasse.php');
        }
    }
    else
    {
        echo '<script> alert("Tous les champs ne sont pas remplis"); </script>';
        redirect("empty");
    }
?>