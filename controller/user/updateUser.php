<?php
    include(__DIR__."/../commandesBdd.php");
    include(__DIR__."/../adresse/adresse.php");

    if(are_set($_POST, array('nom', 'prenom', 'datenaiss', 'email', 'rue', 'ville', 'cp')))
    {
        $params =
        [
            new BindParam('nom', $_POST['nom'], PDO::PARAM_STR),
            new BindParam('prenom', $_POST['prenom'], PDO::PARAM_STR),
            new BindParam('datenaiss', $_POST['datenaiss'], PDO::PARAM_STR),
            new BindParam('email', $_POST['email'], PDO::PARAM_STR),
            new BindParam('id_role', $_POST['role'], PDO::PARAM_STR),
        ];
        if(CommandesBdd::updateElement('user', $params, [new BindParam('id', $_POST['id'], PDO::PARAM_INT)]) &&
        updateAdresse($_POST['id_adresse'], $_POST['rue'], $_POST['ville'], $_POST['cp']))
        {
            redirectFromIndex("controller/user/selectUser.php");
        }
    }
    else
    {
        echo '<script> alert("Tous les champs ne sont pas remplis"); </script>';
        redirect("empty");
    }
?>