<?php
    include(__DIR__.'/../connect.php');

    if ($_POST['mdp'] != $_POST['mdpconf'])
    {
        echo "<script>alert('Les mot de passe sont différents');</script>";
        redirect("formulaire/formPremierMdp.php");
    }
    else
    {
        $bdd->requete("UPDATE user SET mdp = :mdp, pass_changed = 1 WHERE id = :id");
        $hashpw = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
        $bdd->bindParam(":mdp", $hashpw, PDO::PARAM_STR);
        $bdd->bindParam(":id", $_POST['id'], PDO::PARAM_INT);

        if ($bdd->execute())
        {
            if (session_status() == PHP_SESSION_NONE)
            {
                session_start();
            }
            
            if (isset($_SESSION['user']))
            {
                redirect("empty");
            }
            else
            {
                echo "<script>alert('Mot de passe changé avec succès, veuillez vous reconnecter');</script>";
                redirectFromIndex("formulaire/formConnexion.php");
            }
        }
    }
?>