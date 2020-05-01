<?php
    include_once(__DIR__.'/../commandesBdd.php');
    include_once(__DIR__.'/../connect.php');
    include_once(__DIR__.'/creneauxCours.php');
    if(are_set($_POST, ['date', 'matiere', 'classe', 'prof', 'heure']))
    {
        $heureDebut = HORAIRES[$_POST['heure']];
        $heureFin = HORAIRES[$_POST['heure'] + 1];
        $params = 
        [
            new BindParam('date', $_POST['date'], PDO::PARAM_STR),
            new BindParam('id_classe', $_POST['classe'], PDO::PARAM_INT),
            new BindParam('id_prof', $_POST['prof'], PDO::PARAM_INT),
            new BindParam('debut', $heureDebut, PDO::PARAM_STR),
            new BindParam('fin', $heureFin, PDO::PARAM_STR)
        ];

        if(CommandesBdd::insertElement('cours', $params)) { redirectFromIndex("controller/cours/selectCours.php"); }
    }
    else
    {
        echo '<script> alert("Tous les champs ne sont pas remplis"); </script>';
        redirect("empty");
    }
?>