<?php
   session_start();
   include(__DIR__."\..\controller\adresse\adresse.php");

   $adresse = getAdresseById($_GET['idadresse'], $bdd);
?>

<form id ="formu" action ="controller/user/updateUser.php" method="POST" >
  <div class="form-row">
    <input id="Id"  type="hidden" value="<?php echo $_GET['id'];?>" name="id">
    <div class="form-group col-md-5">
      <label>NOM</label>
      <input type="text" class="form-control"  value=<?php echo urldecode($_GET['nom']); ?> name="nom">
    </div>
    <div class="form-group col-md-5">
      <label>Prenom</label>
      <input type="text" class="form-control" value=<?php echo urldecode($_GET['prenom']); ?> name="prenom">
    </div>
    <div class="form-group col-md-2">
      <label>Date de naissance</label>
      <input type="Date" class="form-control" value=<?php echo urldecode($_GET['datenaiss']); ?> name="datenaiss" >
    </div>
    <div class="form-group col-md-4">
      <label>Email</label>
      <input type="email" class="form-control" value=<?php echo urldecode($_GET['email']); ?> name="email">
    </div>
  </div>
  <div class="form-row">
    <div class ="form-group col-md-6">
      <label>Adresse</label>
      <input type="text" class="form-control" value=<?php echo "'".urldecode($adresse['rue'])."'"; ?> name="rue">
    </div>
    <div class="form-group col-md-4">
      <label>Ville</label>
      <input type="text" class="form-control" value=<?php echo "'".urldecode($adresse['ville'])."'"; ?> name="ville">
    </div>
    <div class="form-group col-md-2">
      <label>Code Postal</label>
      <input type="text" class="form-control" value=<?php echo "'".$adresse['cp']."'"; ?> name="cp">
    </div>
      <input type="hidden" name = "id_adresse" value = <?php echo $adresse['id']; ?> >
  </div>
  <div class="form-group ml-0" style = "width: 200px">
    <label>Role</label>
    <select name="role"  class="form-control">
      <?php include("../controller/roles/roles.php"); ?>
      <?php foreach($roles as $valeur)
      {
        if ($_GET['idrole'] == $valeur['id'])
        {
          echo '<option selected value="'.$valeur['id'].'">'.$valeur['type'].'</option>';         
        }
        else
        {
          echo '<option value="'.$valeur['id'].'">'.$valeur['type'].'</option>';
        }         
      }?>
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Modifier</button>
</form>