<form id ="formu" action ="controller/epreuve/insertEpreuve.php" method="POST" >
  <div class="form-row">
    <div class="form-row">
      <div class ="form-group col-md-6">
        <label>Adresse</label>
        <input type="text" class="form-control" placeholder="12 Avenue Napoleon" name="rue" required>
      </div>
      <div class="form-group col-md-4">
        <label>Ville</label>
        <input type="text" class="form-control" placeholder = "Paris" name="ville" required>
      </div>
      <div class="form-group col-md-2">
        <label>Code Postal</label>
        <input type="text" class="form-control" placeholder = "12345" name="cp" required>
      </div>
    </div>
    <div class="form-group col-md-6">
      <label>Date</label>
      <input type="Date" class="form-control" placeholder="date" name="date">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">Matières</label>
      <select name="mat" class="form-control">
        <option selected disabled hidden value = 0 >Choisir...</option>
        <?php 
          include("../controller/matiere/matieres.php");
          foreach($matieres as $valeur) {
            echo '<option value="'.$valeur['id'].'">'.$valeur['libelle'].'</option>';
        }?>
      </select>
    </div>
  </div>
  <br>
  <button type="submit" class="btn btn-primary">Ajouter</button>
</form>