<?php
    include_once(__DIR__."\..\connect.php");
    include_once(__DIR__."\..\commandesBdd.php");
    include_once(__DIR__."/../roles/rolesFunctions.php");
    include_once(__DIR__."\creneauxCours.php");


    $date = (isset($_GET['date'])) ? $_GET['date'] : date('Y-m-d');
    $getDate = $date;
    
    // Recuperer l'indice du jour de la semaine (0 lundi, 1 mardi, etc..)
    $jourSemaineIndice = (int)date('w', strtotime($date));
    $jourSemaineIndice -= 1;

    // L'indice de dimanche est à -1
    if ($jourSemaineIndice < 0) { $jourSemaineIndice = 6; }
    
    // Si la date est un samedi ou un dimanche aller à la semaine suivante
    if ($jourSemaineIndice ==  5 || $jourSemaineIndice == 6)
    {
        // Vaut 2 si samedi, 1 si dimanche
        $jourAAjouter = 7 - $jourSemaineIndice;
        $date = date('Y-m-d', strtotime($date. ' + '.$jourAAjouter.' days'));
        $jourSemaineIndice = 0;
    }

    // Recuperer la date du lundi de la semaine
    $jourDebutSemaine = date('Y-m-d', strtotime($date. ' - '.$jourSemaineIndice.' days'));

    // Récuperer les dates de la semaine du lundi au vendredi seulement
    $semaine = [];
    for ($i = 0; $i < 5; ++$i)
    {
        $semaine []= date('Y-m-d', strtotime($jourDebutSemaine.' + '.$i.' days'));
    }

    if(!session_id())
    {
        session_start();
    }

    // Seuls les cours appartenant à ces classes
    // seront affichés
    $classes = [];
    if (isStudent())
    {
        $classes []= $_SESSION['user']['id_classe'];
    }
    else if (isAdmin())
    {
        // Si un element est dans le $_GET l'utiliser, sinon prendre la premiere classe
        if (isset($_GET['classe']))
        {
            $classes []= $_GET['classe'];
        }
        else
        {
            $classes []= CommandesBdd::getFirstValidElement('classe');
        }
    }
    else
    {
        // Récuperer par défaut toute les classes du prof sinon le $_GET
        if (isset($_GET['classe']))
        {
            $classes []= $_GET['classe'];
        }
        else
        {
            $array = CommandesBdd::getProfClasses($_SESSION['user']['id']);
            foreach($array as $id)
            {
                $classes []= $id;
            }
        }
    }

    // Selectionner les cours et les envoyer à la page d'affichage
    $cours = [];
    for($i = 0; $i < count(HORAIRES) - 1; $i += 2)
    {
        $debut = HORAIRES[$i];
        $fin = HORAIRES[$i + 1];

        foreach($semaine as $jour)
        {
            if (isProf())
            {
                $cours [] = CommandesBdd::selectCours($jour, $debut, $fin, $classes, $_SESSION['user']['id']);
            }
            else
            {
                $cours [] = CommandesBdd::selectCours($jour, $debut, $fin, $classes);
            }
        }
    }

    $getCours = http_build_query($cours);
    if (isset($_GET['classe']))
    {
        redirect("vue/cours.php?".$getCours."&date=".$getDate."&classe=".$_GET['classe']."&dateLundi=".$jourDebutSemaine);
    }
    else
    {
        redirect("/vue/cours.php?".$getCours."&date=".$getDate."&dateLundi=".$jourDebutSemaine);
    }
?>