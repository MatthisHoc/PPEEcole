<?php 
include(__DIR__."\..\controller\classe\classes.php");
include(__DIR__."\..\controller\matiere\matieres.php");
?>

<script>
    $(document).ready(function()
    {
        $("#selectProfDiv").hide();
        $("#selectHoraireDiv").hide();
    });

    function updateProf()
    {
        $.ajax(
        {
            type:"GET",
            url:"controller/cours/recupererProfs.php",
            data:"id_classe="+ $("#selectClasse").val() +"&id_matiere=" + $("#selectMatiere").val(),
            success:function(data)
            {
                $("#selectProf").find('option').remove();
                var array = JSON.parse(data);
                for(i = 0; i < array.length; ++i)
                {
                    var obj = array[i];
                    $("#selectProf").append(new Option(obj.nom + " " + obj.prenom, obj.id));
                }

                $("#selectProfDiv").show();
                $("#selectProf").trigger("change");
            },
            error:function(data)
            {
                alert("Erreur du script PHP");
            }
        }); 
    }

    $("#selectMatiere").change(function()
    {  
       updateProf();
    });
    $("#selectClasse").change(function()
    {
        updateProf();
    });
    $("#selectProf").change(function()
    {
        
        $.ajax(
        {
            type:"GET",
            url:"controller/cours/recupererHoraires.php",
            data:"id_prof="+ $("#selectProf").val() +"&date=" + $("#date").val() + "&id_classe=" + $("#selectClasse").val(),
            success:function(data)
            {
                $("#selectHoraire").find('option').remove();
                array = JSON.parse(data);
                console.log(array);
                for (i = 0; i < array.length; ++i)
                {
                    $("#selectHoraire").append(new Option(array[i][1] + " - " + array[i][2], array[i][0]));
                }
            },
            error:function(data)
            {
                alert("Erreur du script PHP");
            }

        }); 
        
        $("#selectHoraireDiv").show();
    });
</script>

<form id ="formu" action ="controller/cours/insertCours.php" method="POST" >
<div class="form-group">
    <label>Date</label>
    <input value=<?php echo $_GET['date']; ?> type='date' class="col-md-2 form-control" name="date" id="date"/> 
</div>
<div class="form-group">
    <label>Classe</label>
    <select id="selectClasse" name="classe" class="form-control col-md-2">
        <option value = 0 disabled selected hidden>Choisir ...</option>
        <?php foreach($classes as $valeur)
        {
            if ($_GET['id_classe'] == $valeur['id_classe'])
            {
                echo '<option selected value="'.$valeur['id_classe'].'">'.$valeur['libelle']."</option>";
            }
            else
            {
                echo '<option value="'.$valeur['id_classe'].'">'.$valeur['libelle']."</option>";
            }
        } ?>
    </select>
</div>
<div class="form-row">
    <div class="form-group">
        <label>Matiere</label>
        <select id="selectMatiere" name="matiere" class="form-control">
            <option value = 0 disabled selected hidden>Choisir...</option>
            <?php foreach($matieres as $valeur)
            {
                echo '<option value="'.$valeur['id'].'">'.$valeur['libelle']."</option>";
            } ?>
        </select>
    </div>
    <div style="margin-left:10" class="form-group" id="selectProfDiv">
        <label>Professeur</label>
        <select id="selectProf" name="prof" class="form-control">
            <option value = 0 selected>Choisir...</option>
        </select>
    </div>
    <div style="margin-left:10" class="form-group" id="selectHoraireDiv">
        <label>Heure</label>
        <select id="selectHoraire" name="heure" class="form-control">
            <option value = 0 selected>Choisir...</option>
        </select>
    </div>
</div>
<div class ="form-group col-md-4">
    <button type="submit" class="btn btn-primary">Ajouter</button>
</div>
  <br>
</form>