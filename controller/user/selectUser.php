<?php
  
  include(__DIR__."/../connect.php");
  include_once(__DIR__."/../commandesBdd.php");
  include_once(__DIR__."/../roles/roles.php");

  $bdd->requete('SELECT id, nom, prenom, datenaiss, email, id_matiere, id_classe, id_role, id_adresse FROM user WHERE id_role = :role');

  $defrole = (CommandesBdd::getUserCount(Roles::$Etudiant) == 0) ? Roles::$Prof : Roles::$Etudiant;
  $role = (isset($_GET['id'])) ? $_GET['id'] : $defrole;
  $bdd->bindParam(":role", $role, PDO::PARAM_STR);
  if ($bdd->execute())
  {
    $etudiants = $bdd->getStmt()->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($etudiants))
    {
      // Envoyer les etudiants via la methode GET
      $res = http_build_query($etudiants);
      header("Location:../../vue/listeUsers.php?".$res);
    }
    else
    {
      echo '<script> alert("Il n\'y a aucun utilisateur");</script>';
      redirect("empty");
    }
  }
?>
 