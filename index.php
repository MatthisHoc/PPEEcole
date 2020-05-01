<!DOCTYPE>
<html>
  <?php 
    session_start();
    include("controller/roles/rolesFunctions.php");
  ?>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-select.css" rel="stylesheet">
    <link href="css/bootstrap-select.min.css" rel="stylesheet">

    <script src="js/jquery-3.1.1.js"></script>
    <!-- Popper JS -->
    <script src="js/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script src="js/bootstrap-select.js"></script>

    <script>
    
    $(document).ready(function()
    {
        //#inscrire correspond à l'id de la balise <a
        $("#inscrire").click(function()
        {
            //#contenue correspond à l'id de la balise <div>
            $("#contenu").load("formulaire/formulaireUser.php");
        });
        $("#acc").click(function()
        {
            // actualiser la page index.php
            location.reload(true);
        });
        $("#classes").click(function()
        {
            $("#contenu").load("controller/classe/selectClasse.php");
        });
        $("#cours").click(function()
        {
            $("#contenu").load("controller/cours/selectCours.php");
        })
        $("#liste").click(function()
        {
            $("#contenu").load("controller/user/selectUser.php");
        });
        $("#conn").click(function()
        {
            $("#contenu").load("formulaire/formConnexion.php");
        });
        $("#ajoutM").click(function()
        {
            $("#contenu").load("formulaire/formulaireMatiere.php");
        });
        $("#afficheM").click(function()
        {
            $("#contenu").load("controller/matiere/selectMatiere.php");
        });
        $("#ajoutE").click(function()
        {
            $("#contenu").load("formulaire/formulaireEpreuve.php");
        });
        $("#afficheE").click(function()
        {
            $("#contenu").load("controller/epreuve/selectEpreuve.php");
        });
        $("#ajoutC").click(function()
        {
            $("#contenu").load("formulaire/formulaireClasse.php");
        });
        $("#afficheC").click(function()
        {
            $("#contenu").load("controller/classe/selectClasse.php");
        });
        $("#modifProfil").click(function()
        {
          <?php if (isAdmin()) { ?>
            $("#contenu").load("formulaire/formulaireModifProfil.php");
          <?php } else { ?>
            $("#contenu").load("formulaire/formChangerMdp.php");
          <?php } ?>
        });
        $("#deconn").click(function()
        {
            $.ajax(
            {
              type:"POST",
              url:"controller/deconnecter.php",
              success:function(data)
              {
                location.reload(true);              
              },
              error : function()
              {
                alert('Erreur du script PHP');
              }
            });
        });
    });

    </script>
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <p>Cours PHP & Mysql</p>
    <div class="collapse navbar-collapse" id="navbar">
      <ul class="navbar-nav mr-auto mt-3 mt-lg-1">
        <li class="nav-item active">
          <a class="nav-link" id="acc" href="#"> Accueil <span class="sr-only">(current)</span></a>
        </li>
        <?php if(isProf()) { ?>
          <li class="nav-item active">
            <a class="nav-link" id="classes" href="#"> Classes </a>
          </li>
        <?php } ?>
        <?php if(isStudent()) { ?>
          <li class="nav-item active">
            <a class="nav-link" id="afficheE" href="#"> Epreuves </a>
          </li>
        <?php } ?>
        <?php if(!empty($_SESSION['user'])) { ?>
        <li class="nav-item active">
            <a class="nav-link" id="cours" href="#"> Cours </a>
          </li>
        <?php } ?>
        <?php if(isAdmin()) {?>
          <li class="nav-item">
            <a id="inscrire" class="nav-link" href="#">  Inscrire  </a>
          </li>
          <li class="nav-item">
            <a id="liste" class="nav-link" href="#"> Liste des utilisateurs </a>
          </li>
          <li class="nav-item">
            <div class="dropdown">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMatieres" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              Matières
              <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMatieresList">
                <li><a id ="ajoutM" href="#" title="Ajouter">Ajouter</a></li>
                <div class="dropdown-divider"></div>
                <li><a  id="afficheM" href="#" title="Afficher">Afficher</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <div class="dropdown">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownEpreuves" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              Epreuves
              <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownEpreuvesList">
                <li><a id ="ajoutE" href="#" title="Ajouter">Ajouter</a></li>
                <div class="dropdown-divider"></div>
                <li><a id="afficheE" href="#" title="Afficher">Afficher</a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <div class="dropdown">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownClasses" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Classes
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownClassesList">
                <li><a id ="ajoutC" href="#" title="Ajouter">Ajouter</a></li>
                <div class="dropdown-divider"></div>
                <li><a id="afficheC" href="#" title="Afficher">Afficher</a></li>
              </ul>
            </div>
          </li>
        </ul>
      <?php }?>
      <?php if(empty($_SESSION['user'])) {?>
        <li class="nav-item">
          <a id="conn" class="nav-link" href="#"> Se connecter </a>
        </li>
      <?php } else {?>
        <li class="nav-item">
          <div class="dropdown dropdown-menu-right">
                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  <?php echo "Bienvenue ".$_SESSION['user']['prenom']; ?>
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownEpreuvesList">
                  <li><a id ="modifProfil" href="#" title="Ajouter">Modifier</a></li>
                  <div class="dropdown-divider"></div>
                  <li><a id="deconn" href="#"> Se déconnecter</a></li>
                </ul>
              </div>
        </li>
      <?php }?>
    </div>
    </nav>
    <br>
    <div id = "contenu" class="container-fluid">

      <?php
        if(isset($_SESSION['redirect']))
        {
          $path = $_SESSION['redirect'];
          unset($_SESSION['redirect']);
          echo "<script>$('#contenu').load('".$path."')</script>";
        }
      ?>

      <h3>Liens Utiles pour réviser</h3>
      <div class="list-group">
        <a href="https://developer.mozilla.org/fr/docs/Web/HTTP" class="list-group-item list-group-item-action"> Protocole HTTP</a>
        <a href="https://developer.mozilla.org/fr/docs/Web/JavaScript" class="list-group-item list-group-item-action">JavaScript</a>
        <a href="https://www.sites.google.com/site/langagephp/cours_debutant-1" class="list-group-item list-group-item-action">Langage php</a>
        <a href="http://php.net/manual/fr/book.pdo.php" class="list-group-item list-group-item-action">Langage php : PDO</a>
        <a href="https://getbootstrap.com/" class="list-group-item list-group-item-action disabled">Boostrap</a>
      </div>
    </div>
  </body>
</html>
