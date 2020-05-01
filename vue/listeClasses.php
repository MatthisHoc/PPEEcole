<!-- $_GET[0] Liste des classes; $_GET[1] Liste des utilisateurs -->
<?php 
include_once("../controller/commandesBdd.php");
include_once(__DIR__."/../controller/roles/rolesFunctions.php");
include_once("../controller/classe/classes.php");
include_once("../controller/roles/roles.php");
?>
<script>
function updateList(id)
{
    $("#contenu").load("controller/classe/selectClasse.php?id_classe="+id);
}

function deleteClasse(id)
{
    if (id >= 0)
    {
        
        $.ajax(
        {
            type:"GET",
            url:"controller/classe/deleteClasse.php",
            data:"id="+id,
            success:function(data)
            {
                $("#contenu").load("controller/classe/selectClasse.php");
            },
            error : function()
            {
                alert('Erreur du script PHP');
            }
        });	
        
    }
    else
    {
        alert("Impossible de supprimer: La classe n'est pas vide");
    }	
}

function updateClasse(id, libelle)
{
    lien = "formulaire/formulaireUpdateClasse.php?id="+id+"&libelle="+libelle;
    console.log(lien);
    $("#contenu").load(lien);
}
</script>

<div class = "form-row">
    <div class = "form-group" style = "width: 200px">
        <?php if (!empty($classes)) { ?>
            <select name="classe" id="selectClasse" class = "form-control" onchange="updateList(value)">
                <?php foreach($classes as $elem) { ?>
                    <?php if ($_GET[0] == $elem['id_classe']) { ?>
                        <?php echo "<option selected value=".$elem['id_classe'].">".$elem['libelle']."</option>"; ?>
                    <?php } else { ?>
                        <?php echo "<option value=".$elem['id_classe'].">".$elem['libelle']."</option>"; ?>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
        <?php if (isAdmin()) { ?>
        <div class="edit-delete-div">
            <a href="#" onclick="updateClasse('<?php echo $_GET[0]; ?>', '<?php echo urlencode(CommandesBdd::getClasseName($_GET[0])); ?>')">
                Modifier
            </a>
            <! -- $_GET[1] est un tableau contenant les utilisateurs, si il est set on passe "-1" pour indiquer que la classe n'est pas vide -->
            <?php $deleteId = (isset($_GET[1])) ? -1 : $_GET[0]; ?>
            <a class="delete-button" href="#" onclick="deleteClasse(<?php echo $deleteId; ?>)">
                <img class="delete-icon" src="vue/delete_icon.png">
                Supprimer
            </a>
        </div> 
        <?php } ?>  
    </div>
    <div class="w-75 p-1" id="container">
        <?php if (isset($_GET[1])) { ?>
        <h1>Liste des membres de cette classe</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Information</th>    
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach($_GET[1] as $valeur) { ?>
                        <tr>                        
                            <td><?php echo $valeur['nom'] ; ?></td>
                            <td><?php echo $valeur['prenom'] ; ?></td>
                            <?php if ($valeur['id_role'] == Roles::$Prof && isset($valeur['id_matiere'])) { ?>
                            <td><?php echo "Professeur de ".CommandesBdd::getMatiereName($valeur['id_matiere']); ?></td>
                            <?php } else { ?>
                            <td><?php echo CommandesBdd::getRoleName($valeur['id_role']); ?></td>
                            <?php } ?>
                            <td><?php echo $valeur['email'] ; ?></td>
                        </tr>
                    <?php }?>
            </tbody>
        </table>
        <?php } else { ?>
        <h1>Cette classe est vide</h1>
        <?php } ?>
    <?php } else { ?>
        <h1>Vous n'avez aucune classe</h1>
    <?php } ?>
</div>
