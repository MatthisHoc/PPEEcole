<form id ="formu" action ="controller/classe/updateClasse.php" method="POST" >
  <div class="form-row">
    <div class ="form-group col-md-4">
        <label>Nom</label>
        <input hidden value = <?php echo $_GET['id']; ?> name = "id">
        <input value = "<?php echo $_GET['libelle']; ?>" type="text" class="form-control" placeholder="SIO 1.2" name="libelle" required>
    </div>
    <div class ="form-group col-md-4">
        <button style="margin-top:35" type="submit" class="btn btn-primary">Modifier</button>
    </div>
  </div>
  <br>
</form>