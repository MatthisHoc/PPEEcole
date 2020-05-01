<?php 
    include(__DIR__."/../connect.php");
    
    if (are_set($_POST, array('nom', 'prenom', 'datenaiss', 'email', 'rue', 'ville', 'cp')))
    {
        if ($_POST['mdp'] != '')
        {
            // Requete qui modifie egalement le mdp
            $bdd->requete('UPDATE user SET nom=:nom,prenom=:prenom, datenaiss=:datenaiss, email=:email, mdp=:mdp WHERE id=:id');
            // Bind mdp
            $hashpw = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
            $bdd->bindParam(":mdp", $hashpw, PDO::PARAM_STR);
        }
        else
        {
            $bdd->requete('UPDATE user SET nom=:nom,prenom=:prenom, datenaiss=:datenaiss, email=:email WHERE id=:id');
        }
        
        session_start();
        // Bind valeurs
        $bdd->bindParam(":id", $_SESSION['user']['id'], PDO::PARAM_INT);
        $bdd->bindParam(":nom", $_POST['nom'], PDO::PARAM_STR);
        $bdd->bindParam(":prenom", $_POST['prenom'], PDO::PARAM_STR);
        $bdd->bindParam(":datenaiss", $_POST['datenaiss'], PDO::PARAM_STR);
        $bdd->bindParam(":email", $_POST['email'], PDO::PARAM_STR);
        
        if ($bdd->execute())
        {
            
            // Mettre à jour l'adresse
            $bdd->requete('UPDATE adresse SET rue=:rue, ville=:ville, cp=:cp WHERE id=:id');
            
            $bdd->bindParam(":id", $_SESSION['user']['id_adresse'], PDO::PARAM_STR);
            $bdd->bindParam(":rue", $_POST['rue'], PDO::PARAM_STR);
            $bdd->bindParam(":ville", $_POST['ville'], PDO::PARAM_STR);
            $bdd->bindParam(":cp", $_POST['cp'], PDO::PARAM_INT);
            
            if($bdd->execute())
            {    
                redirect("empty");
            }
        }
    }
    else
    {
        echo '<script> alert("Tous les champs ne sont pas remplis"); </script>';
        redirect("empty");
    }
?>