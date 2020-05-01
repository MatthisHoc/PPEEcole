<?php
 
  include(__DIR__.'/../connect.php');

  $bdd->requete("SELECT epreuve.id, date, libelle, rue, ville, cp, epreuve.id_adresse FROM epreuve, matiere, adresse WHERE epreuve.id_matiere = matiere.id AND epreuve.id_adresse = adresse.id");
  if($bdd->execute())
  {    
    $epreuves = $bdd->getStmt()->fetchALL(PDO::FETCH_ASSOC);

    if (!empty($epreuves))
    {
      $res = http_build_query($epreuves);
      header("Location:../../vue/ListeEpreuves.php?".$res);
    }
    else
    {    
      echo '<script> alert("Epreuves vides!");</script>';
      redirect("empty");
    }
  }
?>