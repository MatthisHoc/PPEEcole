<script>
  $(document).ready(function(){
    $("#roles").load("formulaire/inputRoles.php");
  });
</script>
<form action ="controller/user/insertUser.php" method="POST">
  <div class="form-row">
    <div class="form-group col-md-5">
      <label>NOM</label>
      <input type="text" class="form-control" placeholder="Nom" name="nom" required>
    </div>
    <div class="form-group col-md-5">
      <label >Prenom</label>
      <input type="text" class="form-control"  placeholder="Prenom" name="prenom" required>
    </div>
    <div class="form-group col-md-2">
      <label >Date de naissance</label>
      <input type="Date" class="form-control" name="dateN" required>
    </div>
    <div class="form-group col-md-4">
      <label>Email</label>
      <input type="email" class="form-control" placeholder="Email" name="email" required>
    </div>
  </div>
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
  <div class="form-row" id="roles">
  </div>
  <button type="submit" class="btn btn-primary">Inscrire</button>
</form>
