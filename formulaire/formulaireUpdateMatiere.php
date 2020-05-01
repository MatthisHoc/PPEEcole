 <form id ="formu" action ="controller/matiere/updateMatiere.php" method="POST" >
  <div class="form-row">
    <div class="form-group col-md-6">
     <input id="Id"  type="hidden" value="<?php echo $_GET['codemat'];?>" name="codemat">
      <label>Intitulé</label>
      <input type="text" class="form-control" value="<?php echo urldecode($_GET['libelle']);?>" name="libelle">
    </div>
    <div class="form-group col-md-6">
      <label>Coefficient</label>
      <input type="text" class="form-control" value="<?php echo $_GET['coef'];?>" name="coef">
    </div>
  </div>
  <br>
  <button type="submit" class="btn btn-primary">Modifier</button>
</form>