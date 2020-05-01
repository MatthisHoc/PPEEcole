<?php
  include(__DIR__."/../controller/adresse/adresse.php");
  $adresse = getAdresseById($_GET['idadresse']);

  if (!$adresse)
  {
    echo "<script>alert('Erreur: Aucune adresse trouvée avec l'ID');</script>";
    redirect("");
  }
?>

<form id ="formu" action ="controller/epreuve/updateEpreuve.php" method="POST" >
  <div class="form-row">
    <div class="form-group col-md-6">
      <input id="Id" type="hidden" value="<?php echo $_GET['id'];?>" name="id">
      <input id="Id_adresse" type="hidden" value="<?php echo $_GET['idadresse'];?>" name="id_adresse">
    </div>
    <div class="form-row">
      <div class ="form-group col-md-6">
        <label>Adresse</label>
        <input type="text" class="form-control" placeholder="12 Avenue Napoleon" value="<?php echo $adresse['rue'];?>" name="rue" required>
      </div>
      <div class="form-group col-md-4">
        <label>Ville</label>
        <input type="text" class="form-control" placeholder = "Paris" name="ville" value="<?php echo $adresse['ville'];?>" required>
      </div>
      <div class="form-group col-md-2">
        <label>Code Postal</label>
        <input type="text" class="form-control" placeholder = "12345" name="cp" value="<?php echo $adresse['cp'];?>" required>
      </div>
    </div>
    <div class="form-group col-md-6">
      <label>Date</label>
      <input type="Date" class="form-control" value = <?php echo urldecode($_GET['date']); ?> placeholder="date" name="date">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">Matières</label>
      <select name="mat" class="form-control">
        <?php 
          include("../controller/matiere/matieres.php");
          foreach($matieres as $cle=>$valeur) {
            if ($valeur['libelle'] == $_GET['libelle'])
            {
              echo '<option selected value="'.$valeur['id'].'">'.$valeur['libelle'].'</option>';
            }
            else
            {
              echo '<option value="'.$valeur['id'].'">'.$valeur['libelle'].'</option>';
            }
          }?>
      </select>
    </div>
  </div>
  <br>
  <button type="submit" class="btn btn-primary">Modifier</button>
</form>