<?php
    
    include(__DIR__.'/../connect.php');

    if(are_set($_POST, array('email', 'mdp')))
    {
        $bdd->requete('SELECT * from user where email=:email');
        $bdd->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        if($bdd->execute())
        {
            $user = $bdd->getStmt()->fetch(PDO::FETCH_ASSOC);

            // Verifier le mdp de l'utilisateur
            if (!empty($user) && password_verify($_POST['mdp'], $user['mdp']))
            { 
                // Si le mdp de l'utilisateur a déja été changé, revenir à l'accueil
                if ($user['pass_changed'] == 0)
                {
                    echo '<script>alert("Connexion réussie! Vous devez changer votre mot de passe lors de votre première connexion");</script>';
                    redirectFromIndex("formulaire/formChangerMdp.php?id=".$user['id']);
                }
                else
                {  
                    // Stocker l'utilisateur dans le $_SESSION avec une clé correspondant
                    // à son role
                    session_start();
                    switch ($user['id_role'])
                    {
                        case "ROLE_ETUDIANT" :  $_SESSION['etudiant'] = $user;
                                                break;
                        case "ROLE_ADMIN" : $_SESSION['admin'] = $user;
                                            break;
                        case "ROLE_PROF" : $_SESSION['prof'] = $user;
                                            break;
        
                    } 
                    // L'utilisateur est aussi stocké dans la clé user pour y acceder
                    // quelque soit son role
                    $_SESSION['user'] = $user;
                    redirect("empty");
                }
            }
            else
            {
                // Afficher message erreur et revenir à la page de connexion
                echo '<script>
                alert("Votre email ou mot de passe sont invalides");
                </script>';

                redirectFromIndex("formulaire/formConnexion.php");
            }
        }
    }
?>