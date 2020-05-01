<?php
    include_once(__DIR__."\..\commandesBdd.php");
    include_once(__DIR__."\creneauxCours.php");
    $coursProf = CommandesBdd::selectHorairesCoursProf($_GET['id_prof'], $_GET['date']);
    $coursClasse = CommandesBdd::selectHorairesCoursClasse($_GET['id_classe'], $_GET['date']);

    $retval = [];
    if (isset($_GET['id_cours']))
    {
        $arr = CommandesBdd::selectCoursId($_GET['id_cours']);
        $debutCours = $arr[0]['debut'];
        $finCours = $arr[0]['fin'];

        // En cas de modification on souhaite inclure l'horaire actuelle du cours
        // en premier indice
        for($i = 0; $i < count(HORAIRES) - 1; $i += 2)
        {
            $debut = new DateTime(HORAIRES[$i]);
            $fin = new DateTime(HORAIRES[$i+1]);
            
            if ($debut == new DateTime($debutCours) && $fin == new DateTime($finCours))
            {
                $retval []= [$i, $debut->format("G:i"), $fin->format("G:i")];
            }
        }
    }

    for($i = 0; $i < count(HORAIRES) - 1; $i += 2)
    {
        $creneauLibre = true;

        $debut = new DateTime(HORAIRES[$i]);
        $fin = new DateTime(HORAIRES[$i+1]);
        
        foreach($coursClasse as $horaires)
        {
            if ($debut < new DateTime($horaires['fin']) && $fin >= new DateTime($horaires['debut']))
            {
                $creneauLibre = false;
            }
        }

        if ($creneauLibre)
        {
            foreach($coursProf as $horaires)
            {
                if ($debut < new DateTime($horaires['fin']) && $fin >= new DateTime($horaires['debut']))
                {
                    $creneauLibre = false;
                }
            }
        }

        if ($creneauLibre)
        {
            $retval []= [$i, $debut->format("G:i"), $fin->format("G:i")];
        }
    }
    echo json_encode($retval);
?>