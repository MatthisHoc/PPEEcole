<form id ="formu" action ="controller/matiere/insertMatiere.php" method="POST" >
  <div class="form-row">
    <div class="form-group col-md-6">
      <label>Libellé</label>
      <input type="text" class="form-control" placeholder="Libellé" name="libelle">
    </div>
    <div class="form-group col-md-6">
      <label >Coefficient</label>
      <input type="text" class="form-control" placeholder="Coefficient" name="coef">
    </div>
  </div>
  <br>
  <button type="submit" class="btn btn-primary">Ajouter</button>
</form>