<?php
include_once("../controller/roles/rolesFunctions.php");
?>

<script>
    function deleteEpreuve(id)
    {
        $.ajax({
        type:"GET",
        url:"controller/epreuve/deleteEpreuve.php",
        data:"id="+id,
        success:function(data)
        {
            // Version 2
            $("#contenu").load("controller/epreuve/selectEpreuve.php");       
        },
        error : function()
        {
            alert('Erreur du script PHP');
        }
        });		
    }
    function updateEpreuve(id, date, id_adresse, libelle)
    {
        lien = "formulaire/formulaireUpdateEpreuve.php?id="+id+"&date="+date+"&idadresse="+id_adresse+"&libelle="+libelle;
        console.log(lien);
        $("#contenu").load(lien);
    }
</script>

<div  class="w-75 p-1" id="container">
    <h1>Liste des Epreuves</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Adresse</th>
                <th>Matière</th>
                <?php if(isAdmin()) { ?>
                <th>Action</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_GET as $valeur) { ?>
                <tr>
                    <td> <?php echo $valeur['date']; ?> </td>
                    <td> <?php echo $valeur['rue']. " ".$valeur['ville']." ".$valeur['cp']; ?> </td>
                    <td> <?php echo $valeur['libelle']; ?> </td>
                    <?php if(isAdmin()) { ?>
                    <td>
                        <a style = "margin-left:35"href="#" onclick="updateEpreuve(<?php echo '\''.urlencode($valeur['id']).'\',\''.urlencode($valeur['date']).'\','.$valeur['id_adresse'].',\''.urlencode($valeur['libelle']).'\''; ?>)">
                            Modifier
                        </a>
                        <br>
                        <a class = "delete-button" href="#" onclick= "deleteEpreuve(<?php echo $valeur['id']; ?>)" >
                            <img class="delete-icon" src="vue/delete_icon.png">
                            Supprimer 
                        </a>   
                    </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>