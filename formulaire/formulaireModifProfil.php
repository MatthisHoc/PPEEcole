<?php
   session_start();
   include(__DIR__."\..\controller\adresse\adresse.php");

   $adresse = getAdresseById($_SESSION['user']['id_adresse']);
?>

<form action ="controller/user/modifProfil.php" method="POST">
  <div class="form-row">
    <div class="form-group col-md-5">
      <label>NOM</label>
      <input type="text" class="form-control" placeholder="Nom" name="nom" value=<?php echo $_SESSION['user']['nom']; ?> required>
    </div>
    <div class="form-group col-md-5">
      <label >Prenom</label>
      <input type="text" class="form-control"  placeholder="Prenom" name="prenom" value=<?php echo $_SESSION['user']['prenom']; ?> required>
    </div>
    <div class="form-group col-md-2">
      <label >Date de naissance</label>
      <input type="Date" class="form-control" name="datenaiss" value=<?php echo $_SESSION['user']['datenaiss']; ?> required>
    </div>
    <div class="form-group col-md-4">
      <label>Email</label>
      <input type="email" class="form-control" placeholder="Email" name="email" value=<?php echo $_SESSION['user']['email']; ?> required>
    </div>
  </div>
  <div class ="form-row">
    <div class="form-group col-md-4">
      <label>Mot de passe</label>
      <input type="password" class="form-control" placeholder="Nouveau Mot de passe" name="mdp">
    </div>
  </div>
  <div class="form-row">
    <div class ="form-group col-md-6">
      <label>Adresse</label>
      <input type="text" class="form-control" placeholder="12 Avenue Napoleon" name="rue" value=<?php echo "'".$adresse['rue']."'"; ?> required>
    </div>
    <div class="form-group col-md-4">
      <label>Ville</label>
      <input type="text" class="form-control" placeholder = "Paris" name="ville" value=<?php echo "'".$adresse['ville']."'"; ?> required>
    </div>
    <div class="form-group col-md-2">
      <label>Code Postal</label>
      <input type="text" class="form-control" placeholder = "12345" name="cp" value=<?php echo $adresse['cp']; ?> required>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Modifier</button>
</form>
