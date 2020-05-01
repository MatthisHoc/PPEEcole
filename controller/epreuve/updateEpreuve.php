<?php
    include(__DIR__."/../commandesBdd.php");
    include(__DIR__."/../adresse/adresse.php");

    if(are_set($_POST, array('rue', 'ville', 'cp', 'date')))
    {
        $params =
        [
            new BindParam('date', $_POST['date'], PDO::PARAM_STR),
            new BindParam('id_matiere', $_POST['mat'], PDO::PARAM_INT)
        ];

        if (
        CommandesBdd::updateElement('epreuve', $params, [new BindParam('id', $_POST['id'], PDO::PARAM_INT)]) &&
        updateAdresse($_POST['id_adresse'], $_POST['rue'], $_POST['ville'], $_POST['cp']))
        {
            redirectFromIndex("controller/epreuve/selectEpreuve.php");
        }
    }
    else
    {
        echo '<script> alert("Tous les champs ne sont pas remplis"); </script>';
        redirect("empty");
    }
?>