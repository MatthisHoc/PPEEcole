<?php

    include(__DIR__.'/../commandesBdd.php');
    include(__DIR__.'/../adresse/adresse.php');

    if(are_set($_POST, ['rue', 'ville', 'cp', 'date']) && $_POST['mat'] != '0')
    {          
        $id = insertUniqueAdresse($_POST['rue'], $_POST['ville'], $_POST['cp']);
        if ($id == -1)
        {
            echo '<script> alert("Erreur insertion adresse"); </script>';
            redirect("empty");
        }

        $params = [
            new BindParam('date', $_POST['date'], PDO::PARAM_STR),
            new BindParam('id_adresse', $id, PDO::PARAM_INT),
            new BindParam('id_matiere', $_POST['mat'], PDO::PARAM_INT)
        ];
        if(CommandesBdd::insertElement('epreuve', $params)) { redirectFromIndex("controller/epreuve/selectEpreuve.php"); }
    }
    else
    {
        echo '<script> alert("Tous les champs ne sont pas remplis"); </script>';
        redirect("formulaire/formulaireEpreuve.php");
    }

?>