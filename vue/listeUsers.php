<?php if (!session_id()) { session_start(); } ?>

<script>

    $(document).ready(function(){
        $('.selectpicker').selectpicker();
    });

    $(".selectpicker").on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue)
    {
        // Si ces deux valeurs sont nul le select à été changé par la fonction selectpicker
        if (clickedIndex != null && isSelected != null)
        {
            
            $.ajax(
            {
                type:"GET",
                url:"controller/user/updateClassesProf.php",
                data:"user_id=" + this.id + "&id_classe=" + this.options[clickedIndex].value + "&isSelected=" + isSelected,
                success:function(data)
                {

                },
                error:function(data)
                {
                    alert("Erreur du script PHP");
                }
            });            
        }
    });

    function selectItems(id, val)
    {
        $(".classe-multi-select-"+id).selectpicker('val', JSON.parse(val));
    }

    function deleteUser(id)
    {
        $.ajax(
        {
            type:"GET",
            url:"controller/user/deleteUser.php",
            data:"id="+id,
            success:function(data)
            {
                $("#contenu").load("controller/user/selectUser.php");
            },
            error:function(data)
            {
                alert('Erreur du script PHP');
            }
        });
    }
    function updateMatiere(id, matiere)
    {
        $.ajax(
        {
            type:"GET",
            url:"controller/user/updateMatiereUser.php",
            data:"id="+id+"&id_matiere="+matiere,
            success:function(data)
            {
                //$("#contenu").load("controller/user/selectUser.php");
            },
            error:function(data)
            {
                alert("Erreur du script PHP");
            }
        });
    }
    function updateClasse(id, classe)
    {
        $.ajax(
        {
            type:"GET",
            url:"controller/user/updateClasseEleve.php",
            data:"id="+id+"&id_classe="+classe,
            success:function(data)
            {
                //$("#contenu").load("controller/user/selectUser.php");
            },
            error:function(data)
            {
                alert("Erreur du script PHP");
            }
        });
    }
    function updateList(id)
    {
        $("#contenu").load("controller/user/selectUser.php?id="+id);
    }
    function updateUser(id, nom, prenom, datenaiss, email, id_role, id_adresse)
    {
        lien = "formulaire/formulaireUpdateUser.php?id="+id+"&nom="+nom+"&prenom="+prenom+"&datenaiss="+datenaiss+"&email="+email+"&idrole="+id_role+"&idadresse="+id_adresse;
        console.log(lien);
        $("#contenu").load(lien);
    }
</script>
<?php include_once('../controller/commandesBdd.php'); ?>
<div class = "form-group" style = "width: 200px">
    <?php include_once("../controller/roles/roles.php"); ?>
    <select name="role" class = "form-control" onchange=updateList(value)>
        <?php foreach($roles as $elem) { ?>
            <!-- Ne pas afficher la liste des admins -->
            <?php if ($elem['id'] != Roles::$Admin) { ?>
                <!-- Mettre le rôle affiché en selected par défaut -->
                <?php if ($_GET[0]['id_role'] == $elem['id']) { ?>
                    <?php echo "<option selected value=".$elem['id'].">".$elem['type']."</option>"; ?>
                <!-- Afficher les autres rôles -->
                <?php } else { ?>
                    <?php echo "<option value=".$elem['id'].">".$elem['type']."</option>"; ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
    </select>
</div>

<div class="w-75 p-1" id="container">
    <h1>Liste des utilisateurs</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Date de naissance</th>    
                <th>Email</th>
                <?php if ($_GET[0]['id_role'] == Roles::$Prof)
                {
                    echo "<th>Matière</th>";
                } 
                else if ($_GET[0]['id_role'] == Roles::$Etudiant)
                {
                    echo "<th>Classe</th>";
                } ?>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($_GET as $valeur) {?>
                <tr>                        
                    <td><?php echo $valeur['nom'] ; ?></td>
                    <td><?php echo $valeur['prenom'] ; ?></td>
                    <td><?php echo $valeur['datenaiss'] ; ?></td>
                    <td><?php echo $valeur['email'] ; ?></td>
                        <?php
                        if ($_GET[0]['id_role'] == Roles::$Prof)
                        {
                            echo "<td>";
                            include_once("../controller/matiere/matieres.php");
                            ?>
                            <select name='matiere' class='form-control' onchange="updateMatiere('<?php echo $valeur['id'];?>', value)">
                                <option selected hidden>Choisir matière...</option>
                                <?php foreach($matieres as $mat)
                                 {
                                    if (isset($valeur['id_matiere']) && $valeur['id_matiere'] == $mat['id'])
                                    {
                                        echo "<option selected value=".$mat['id'].">".$mat['libelle']."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value=".$mat['id'].">".$mat['libelle']."</option>";
                                    }
                                } ?>
                            </select>
                            <br>
                            <select multiple title="Choisir classes..."
                            name = "classes[]" id = <?php echo $valeur['id']; ?> class="selectpicker show-tick classe-multi-select-<?php echo $valeur['id'];?>">            
                                <?php include_once("../controller/classe/classes.php"); ?>
                                <?php foreach($classes as $classe)
                                {
                                    echo '<option value="'.$classe['id_classe'].'">'.$classe['libelle']."</option>";
                                } ?>
                            </select>
                            <?php

                                $profClasses = CommandesBdd::getProfClasses($valeur['id']);
                                // Selectionner les classes de l'utilisateur automatiquement
                                echo "<script>selectItems('".$valeur['id']."', '".json_encode($profClasses)."');</script>";
                            ?>
                            <?php echo "</td>"; ?>

                  <?php } else if ($_GET[0]['id_role'] == Roles::$Etudiant)
                        {
                            echo "<td>";
                            include_once("../controller/classe/classes.php");
                            ?>
                            <select name='classe' class='form-control' onchange="updateClasse('<?php echo $valeur['id'];?>', value)">
                                <?php 
                                foreach($classes as $classe)
                                {
                                    if ($valeur['id_classe'] == $classe['id_classe'])
                                    {
                                        echo "<option selected value=".$classe['id_classe'].">".$classe['libelle']."</option>";
                                    }
                                    else
                                    {
                                        echo "<option value=".$classe['id_classe'].">".$classe['libelle']."</option>";
                                    }
                                } ?>
                            </select>
                            <?php echo "</td>"; ?>
                    <?php } ?>
                    <td>
                        <div class="edit-delete-div">
                            <a href="#" onclick="updateUser('<?php echo $valeur['id']; ?>', 
                            '<?php echo urlencode($valeur['nom']); ?>', 
                            '<?php echo urlencode($valeur['prenom']); ?>', 
                            '<?php echo urlencode($valeur['datenaiss']); ?>', 
                            '<?php echo urlencode($valeur['email']); ?>', 
                            '<?php echo $valeur['id_role']; ?>', 
                            '<?php echo $valeur['id_adresse']; ?>')">Modifier</a>
                            <br>
                            <a class="delete-button" style="margin-left:-30" href="#" onclick="deleteUser(<?php echo $valeur['id']; ?>)" >
                                <img class="delete-icon" src="vue/delete_icon.png">
                                Supprimer
                            </a> 
                        </div>  
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
</div>
