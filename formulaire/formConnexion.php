<div>
    <form action= "controller/user/verifierConnexion.php" method="POST">
      <div class="form-group">
        <label for="emailInput">Email address</label>
        <input type="email" class="form-control" id="emailInput" aria-describedby="emailHelp" placeholder="Entrer email" name="email">
      </div>
      <div class="form-group">
        <label for="passwordInput">Mot de passe</label>
        <input type="password" class="form-control" id="passwordInput" placeholder="Password" name="mdp">
      </div>
      <button type="submit" class="btn btn-primary">Soumettre</button>
  </form>    
</div>