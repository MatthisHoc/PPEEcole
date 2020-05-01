<script>
    function deleteMatiere(id)
    {
        $.ajax({
        type:"GET",
        url:"controller/matiere/deleteMatiere.php",
        data:"id="+id,
        success:function(data)
        {
            // Version 2
            $("#contenu").load("controller/matiere/selectMatiere.php");            
        },
        error : function()
        {
            alert('Erreur du script PHP');
        }
        });		
    }
    
    function UpdateMatiere(libelle,codemat,coef)
    {
        lien = "formulaire/formulaireUpdateMatiere.php?libelle="+libelle+"&codemat="+codemat+"&coef="+coef ;
        console.log(lien);
        $("#contenu").load(lien);                 	
    }
</script>

<div  class="w-75 p-1" id="container">
    <h1>Liste des Matières</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Libelle</th>
                <th>Coefficient</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_GET as $valeur) { ?>
                <tr>            
                    <td> <?php echo $valeur['libelle']; ?> </td>
                    <td> <?php echo $valeur['coef']; ?> </td>
                    <td>
                        <a href="#" style="margin-left:30" onclick="UpdateMatiere(<?php echo '\''.urlencode($valeur['libelle']).'\','.$valeur['id'].','.$valeur['coef']; ?> )" >
                            Modifier
                        </a>
                        <br>
                        <a href="#" class = "delete-button" onclick="deleteMatiere(<?php echo $valeur['id'] ?>)" >
                            <img class="delete-icon" src="vue/delete_icon.png">
                            Supprimer
                        </a>   
                    </td>
                </tr>
               <?php } ?>
        </tbody>
    </table>
</div>