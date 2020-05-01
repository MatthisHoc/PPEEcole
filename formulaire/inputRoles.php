<script>

$(document).ready(function(){
    $('.selectpicker').selectpicker();
});

function showSelect(value)
  {
    $("#roles").load("formulaire/inputRoles.php?role="+value);
  }
</script>
<div class="form-group col-md-0" style = "width: 200px">
    <label>Role</label>
    <select name="role"  class="form-control" onchange="showSelect(value)">
    <?php if(!isset($_GET['role'])) { ?>
        <option value = 0 disabled hidden selected>Choisir...</option>
    <?php } ?>
    <?php include("../controller/roles/roles.php"); ?>
    <?php foreach($roles as $valeur)
    {
        if (isset($_GET['role']) && $_GET['role'] == $valeur['id'])
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
<?php if(isset($_GET['role']) && $_GET['role'] == Roles::$Prof) { ?>
<!-- Afficher select matières si professeur est séléctionné-->
    <div class = "form-row">
        <div id = "matiere" class="form-group col-md-4">
            <label>Matiere</label>
            <select name="matiere" class="form-control">
                <option value = 0 disabled selected hidden>Choisir ...</option>
                <?php include("../controller/matiere/matieres.php"); ?>
                <?php foreach($matieres as $valeur)
                {
                echo '<option value="'.$valeur['id'].'">'.$valeur['libelle'].'</option>';
                } ?>
            </select>
        </div>
        <div id = "classes" class="form-group col-md-4">
            <?php include_once("../controller/classe/classes.php"); ?>
            <label>Classes</label>
            <select multiple title = "Choisir classes" 
            name = "classes[]" class="selectpicker show-tick">            
                <?php foreach($classes as $valeur)
                {
                echo '<option value="'.$valeur['id_classe'].'">'.$valeur['libelle']."</option>";
                } ?>
            </select>
        </div>
    </div>
<?php } else if (isset($_GET['role']) && $_GET['role'] == Roles::$Etudiant) { ?>
<!-- Afficher select classes si etudiant est séléctionné-->
<div id = "classe" class="form-group col-md-4">
    <label>Classe</label>
    <select name="classe" class="form-control">
        <option value = 0 disabled selected hidden>Choisir ...</option>
        <?php include_once("../controller/classe/classes.php"); ?>
        <?php foreach($classes as $valeur)
        {
        echo '<option value="'.$valeur['id_classe'].'">'.$valeur['libelle']."</option>";
        } ?>
    </select>
</div>
<?php } ?>