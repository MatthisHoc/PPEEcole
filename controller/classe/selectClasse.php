<?php

    include(__DIR__."/../connect.php");
    include(__DIR__."/../commandesBdd.php");
    include_once(__DIR__."/../roles/rolesFunctions.php");
    include_once(__DIR__."/../roles/roles.php");

    // Cette requete permet de selectionner tous les professeurs de la classe
    // séléctionnée et tous les utilisateurs ayant un id_classe (donc étudiants)
    $columns = " user.id, user.nom, user.prenom, user.email, user.id_role, user.id_matiere ";
    
    if (!session_id())
    {
        session_start();
    }

    if (isAdmin())
    {
        $requete =
        "SELECT".$columns."FROM user ".
        "JOIN enseigner ON enseigner.id_prof = user.id ".
        "JOIN classe ON classe.id = enseigner.id_classe ".
        "WHERE classe.id = :id_classe AND id_role = '".Roles::$Prof."'".
        "UNION SELECT".$columns."FROM user WHERE id_classe = :id_classe AND id_role = '".Roles::$Etudiant."'";
    }
    else
    {
        $requete =
        "SELECT".$columns."FROM user ".
        "WHERE id_classe = :id_classe AND id_role = '".Roles::$Etudiant."'";
    }

    $bdd->requete($requete);
    $id = null;
    if (isset($_GET['id_classe']))
    {
        $id = $_GET['id_classe'];
        $bdd->bindParam(':id_classe', $id, PDO::PARAM_INT);
    }
    // Si aucune classe n'est séléctionné utiliser la premiere existante
    else
    {
        $object = CommandesBdd::getFirstValidElement('classe');
        if($object)
        {
            $id = $object['id'];
            $bdd->bindParam(':id_classe', $id, PDO::PARAM_INT);
            if ($bdd->execute())
            {
                // Créer un tableau contenant tous les utilisateurs avec comme premier
                // élément l'id de la classe
                $users[0] = $id;
                $users []= $bdd->getStmt()->fetchAll(PDO::FETCH_ASSOC);
                $res = http_build_query($users);
                header("Location: ../../vue/listeClasses.php?".$res);
            }
            else
            {
                echo "<script>alert('Erreur lors de l'execution de la requete)";
            }
        }
        else
        {
            echo "<script>alert('Il n'y a aucune classe');</script>";
            redirect('empty');
        }
    }
?>