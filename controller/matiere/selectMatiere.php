<?php

  include(__DIR__.'\..\connect.php');

  $bdd->requete("SELECT * FROM matiere");
  $bdd->execute();
  $matieres = $bdd->getStmt()->fetchALL(PDO::FETCH_ASSOC);

  if (!empty($matieres))
  {
    $res = http_build_query($matieres); 
    header("Location: ../../vue/listeMatieres.php?".$res);
  }
  else
  {   
    echo '<script> alert("Matieres vides!");</script>';
    redirect("empty");
  }

?>