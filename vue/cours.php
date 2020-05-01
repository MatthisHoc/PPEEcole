<?php 
if (!session_id())
{
    session_start();
}

$couleurs = 
[
    "#e684ac",
    "#3cadb5",
    "#3e8769",
    "#deb933",
    "#c97f10",
    "#ad4826",
    "#7250a6",
    "#b35bad",
    "#5c5c91",
    "#838a91"
];

include_once(__DIR__.'\..\controller\commandesBdd.php');
include_once(__DIR__.'\..\controller\roles\rolesFunctions.php');
include_once(__DIR__.'\..\controller\classe\classes.php');
?>

<script>
    
    $("#date").change(function()
    {
        val = $("#date").val();
        val2 = $("#selectClasse").val();
        updateEdt(val,val2);
    });

    $("#selectClasse").change(function()
    {
        val = $("#date").val();
        val2 = $("#selectClasse").val();
        updateEdt(val,val2);
    });

    $("#addButton").click(function()
    {
        val = $("#date").val();
        val2 = $("#selectClasse").val();
        $("#contenu").load("formulaire/formulaireCours.php?date=" + val + "&id_classe=" + val2);
    });
    
    function updateEdt(newDate, idClasse)
    {
        if (idClasse == '0')
        {
            $("#contenu").load("controller/cours/selectCours.php?date="+newDate);
        }
        else
        {
            $("#contenu").load("controller/cours/selectCours.php?date=" + newDate + "&classe=" + idClasse);
        }
    }

    function deleteCours(id)
    {
        $.ajax({
            type:"GET",
            url:"controller/cours/deleteCours.php",
            data:"id=" + id,
            success:function(data)
            {
                $("#contenu").load("controller/cours/selectCours.php");
            },
            error:function(data)
            {
                alert("Erreur script PHP");
            }
        });
    }

    function updateCours(id, date, matiere)
    {
        $("#contenu").load("formulaire/formulaireUpdateCours.php?id=" + id + "&date=" + date + "&id_classe=" + $("#selectClasse").val() + "&id_matiere=" + matiere);
    }

</script>

<div class="row" style="margin-left:10">
    <input value=<?php echo $_GET['date']; ?> type='date' class="col-md-2 form-control" id="date"/> 

<?php 
if (isAdmin() || isProf()) 
{
    echo '<select name="classe" id="selectClasse" class="col-md-2 form-control" style="margin-left:10">';
    if (isProf()) 
    {
        if (!isset($_GET['classe']))
        {
            echo "<option selected value= '0' > Toutes les classes </option>"; 
        }
        else
        {
            echo "<option value= '0' > Toutes les classes </option>"; 
        }
    } 
    foreach($classes as $elem) 
    {
        if ($_GET['classe'] == $elem['id_classe']) 
        {
            echo "<option selected value=".$elem['id_classe'].">".$elem['libelle']."</option>";
        } 
        else 
        {
            echo "<option value=".$elem['id_classe'].">".$elem['libelle']."</option>";
        }
    }
    echo "</select>";
} ?>

<?php if (isAdmin()) { ?>
    <button id="addButton" style="margin-left:5" type="button" class="btn btn-info">Ajouter</button>
<?php } ?>
</div>
<br>
<table class="timetable">
    <th class="day-title">Lundi</th>
    <th class="day-title">Mardi</th>
    <th class="day-title">Mercredi</th>
    <th class="day-title">Jeudi</th>
    <th class="day-title">Vendredi</th>
    
    <?php
        // Retirer la date du $_GET et la classe
        $date = $_GET['dateLundi'];
        if (isset($_GET['dateLundi'])){ array_pop($_GET); }
        if (isset($_GET['classe'])){ array_pop($_GET); }
        if (isset($_GET['date'])){ array_pop($_GET); }
        for($i = 0; $i < count($_GET); ++$i)
        {
            $insertTr = $i % 5 == 0;
            if ($insertTr && $i != 0)
            {
                // Fermer la balise précedente
                echo "</tr>";
            }
            if ($insertTr)
            {
                // Ouvrir une nouvelle ligne
                echo "<tr>";
            }
            if ($_GET[$i] == '0')
            {
                echo "<td class='cours' style='background-color:transparent'>";
                echo "<label style='color:black'> Pas de cours </label>";
                echo "</td>";
            }
            else
            {
                if (session_status() == PHP_SESSION_NONE)
                {
                    session_start();
                }
                $cours = CommandesBdd::selectCoursId($_GET[$i]);
                $heureDebut = date('G', strtotime($cours[0]['debut']));
                $minuteDebut = date('i', strtotime($cours[0]['debut']));
                $heureFin = date('G', strtotime($cours[0]['fin']));
                $minuteFin = date('i', strtotime($cours[0]['fin']));

                echo "<td class='cours' style='background-color:".$couleurs[$cours[0]['id_matiere'] % count($couleurs)]."'>";
                if (isAdmin() || isStudent())
                {
                    echo "<label>".$cours[0]['libelle']."</label>";
                    echo "<br>";
                    echo "<label>".$cours[0]['nom']."</label>";
                    echo "<br>";
                }
                if (isProf())
                {
                    echo "<label>".$cours[0]['classe']."</label>";
                    echo "<br>";
                }
                echo "<label class='cours-time'>".$heureDebut.'H'.$minuteDebut." - ".$heureFin.'H'.$minuteFin."</label>";
                if (isAdmin())
                {
                    echo "<br>";
                    $id = $cours[0]['id'];
                    $coursDate = date('Y-m-d', strtotime($date." + ".($i % 5)." days"));
                    $idMatiere = $cours[0]['id_matiere'];
                    ?>
                    <a style="color:white" onclick="updateCours('<?php echo $id; ?>', '<?php echo $coursDate; ?>', '<?php echo $idMatiere; ?>')" href="#">Modifier</a>
                    <a style="color:white; margin-left:10;" onclick="deleteCours(<?php echo $id; ?>)" href="#">Supprimer</a>
                    <?php
                }
                echo "</td>";
            }
        }
    ?>
<table>