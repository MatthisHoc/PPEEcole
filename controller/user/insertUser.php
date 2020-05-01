<?php

    include(__DIR__.'/../commandesBdd.php');
    include(__DIR__.'/../adresse/adresse.php');
    include(__DIR__.'/../mail.php');
    include(__DIR__.'/../roles/roles.php');

    function rand_pass() : string
    {
        // Longueur du mot de passe
        $length = 16;
        // Liste des caractères qui peuvent figurer dans le mdp
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!?#&";
        $randmax = mb_strlen($chars) - 1;
        // Contiendra le mot de passe final
        $pass = [];
        for($i = 0; $i < $length; ++$i)
        {
            $pass []= $chars[random_int(0, $randmax)];  // L'operateur []= ajoute un élément à la fin du tableau
        }

        return implode('',$pass);
    }

    $conditionProf = ($_POST['role'] == Roles::$Prof && $_POST['matiere'] != '0' && count($_POST['classes']) > 0);
    $conditionEtu = ($_POST['role'] == Roles::$Etudiant && $_POST['classe'] != '0');
    $conditionAutre = (($_POST['role'] != "0" && $_POST['role'] != Roles::$Prof && $_POST['role'] != Roles::$Etudiant));
    $conditionSpe =  $conditionProf || $conditionEtu || $conditionAutre;
    if(are_set($_POST, ['rue', 'ville', 'cp', 'nom', 'prenom', 'dateN', 'email']) && 
    $conditionSpe)
    {         
        // Verifier si l'email est déja utilisée
        $param = null;
        if (!CommandesBdd::checkIfEmpty('user', [new BindParam('email', $_POST['email'], PDO::PARAM_STR)], $param))
        {
            echo '<script> alert("L\'adresse mail est déjà utilisée"); </script>';
            redirect("formulaire/formulaireUser.php");
        }

        $idAdresse = insertUniqueAdresse($_POST['rue'], $_POST['ville'], $_POST['cp']);
        if ($idAdresse == -1)
        {
            echo '<script> alert("Erreur insertion adresse"); </script>';
            redirect("empty");
        }

        $pw = rand_pass();
        $params =
        [
            new BindParam('nom', $_POST['nom'], PDO::PARAM_STR),
            new BindParam('prenom', $_POST['prenom'], PDO::PARAM_STR),
            new BindParam('datenaiss', $_POST['dateN'], PDO::PARAM_STR),
            new BindParam('email', $_POST['email'], PDO::PARAM_STR),
            new BindParam('mdp', password_hash($pw, PASSWORD_BCRYPT), PDO::PARAM_STR),
            new BindParam('id_role', $_POST['role'], PDO::PARAM_STR),
            new BindParam('id_adresse', $idAdresse, PDO::PARAM_STR)
        ];

        switch($_POST['role'])
        {
            case Roles::$Etudiant:
            $params []= new BindParam('id_classe', $_POST['classe'], PDO::PARAM_INT);
            break;
            case Roles::$Prof:
            $params []= new BindParam('id_matiere', $_POST['matiere'], PDO::PARAM_INT);
            default:
            break;
        }
       
        if(CommandesBdd::insertElement('user', $params))
        {
            if ($_POST['role'] == Roles::$Prof)
            {
                $id_prof = CommandesBdd::getLastInsertId();
                // Inserer les classes choisie si professeur
                foreach($_POST['classes'] as $id)
                {
                    CommandesBdd::insererClasseProf($id_prof, $id);
                }
            }

            // Envoyer l'email avc le mdp temporaire
            $msg = "Bonjour ".$_POST['prenom']."<br>Votre mot de passe temporaire pour vous connecter est <br><br><b>".$pw."</b><br>Il faudra le changer lors de la premiere connexion.";
            if (sendMail("Votre mot de passe temporaire", $msg, $_POST['email']))
            {
                redirect("empty");
            }
        } 
    }
    else
    {
        echo '<script> alert("Tous les champs ne sont pas remplis"); </script>';
        redirectFromIndex("formulaire/formulaireUser.php");
    }


?>