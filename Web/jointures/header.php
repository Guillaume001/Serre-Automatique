<!DOCTYPE HTML>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Serre Automatique 2.0">
    <meta name="author" content="Guillaume COURS & Paul OLIVA">

    <title><?php echo $titre; ?> | Serre Automatique 2.0</title>

    <link rel="icon" type="image/png" href="../img/favicon.png"/>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/heure.js"></script>

    <style type="text/css">
       ${demo.css}
    </style>

</head>


<body>

	<nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="../accueil"><img class="logo" alt="Logo" src="../img/favicon.png"></a><a class="navbar-brand navbar-brand-text" href="../accueil">Serre Automatique 2.0</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li <?php if ($titre == "Accueil") {echo 'class="active"';} ?>><a href="../accueil"><i class="fa fa-home" aria-hidden="true"></i> Accueil</a></li>
				<?php if(isset($_SESSION["utilisateur"])){?>
                <li <?php if ($titre == "Live") {echo 'class="active"';} ?>><a href="../pages/live.php"><i class="fa fa-eye" aria-hidden="true"></i> Live</a></li>
				<li <?php if ($titre == "Timelapse") {echo 'class="active"';} ?>><a href="../pages/timelapse.php"><i class="fa fa-history" aria-hidden="true"></i> Timelapse</a></li>
				<li <?php if ($titre == "Paramètres") {echo 'class="active"';} ?>><a href="../pages/param.php"><i class="fa fa-cog" aria-hidden="true"></i> Paramètres</a></li>
				<?php } ?>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php if(!isset($_SESSION["utilisateur"])){?>
                <li <?php if ($titre == "Connexion") {echo 'class="active"';} ?>><a href="../pages/connexion.php"><i class="fa fa-sign-in" aria-hidden="true"></i> Connexion</a></li>
                <?php
                } else {
					echo '<li><a href="../pages/deconnexion.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Deconnexion</a></li>';
				}?>
                <li><a><div id="horloge"></div></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

<script src="../js/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>


<?php
date_default_timezone_set('Europe/Paris');
?>
