<?php
    include(__DIR__."/../commandesBdd.php");
    
    $isSelected = ($_GET['isSelected'] == 'true') ? true : false;
    if ($isSelected)
    {
        CommandesBdd::insererClasseProf($_GET['user_id'], $_GET['id_classe']);
    }
    else
    {
        CommandesBdd::deleteClasseProf($_GET['user_id'], $_GET['id_classe']);
    }
    redirect("empty");
?>