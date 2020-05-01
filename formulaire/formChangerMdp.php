<?php
  session_start();
  if(!isset($_GET['id']) && isset($_SESSION['user']))
  {
    $_GET['id'] = $_SESSION['user']['id'];
  }
?>

<div>
    <form action= "controller/user/changerMdp.php" method="POST">
      <div class="form-group">
        <label for="passwordInput">Mot de passe</label>
        <input required type="password" class="form-control" id="passwordInput" placeholder="Mot de passe" name="mdp">
      </div>
      <div class="form-group">
        <label for="passwordInputConf">Confirmer mot de passe</label>
        <input required type="password" class="form-control" id="passwordInputConf" placeholder="Confirmer Mot de passe" name="mdpconf">
      </div>
      <input type="hidden" name = 'id' value = <?php echo $_GET['id']; ?> >
      <button type="submit" class="btn btn-primary">Enregistrer</button>
  </form>    
</div>