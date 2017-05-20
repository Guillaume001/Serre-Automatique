<?php
session_start();
$titre = "Statistiques";
require_once ("../jointures/header.php");
require_once("../configuration/baseDonnees.php");
?>
<div class="contenu">
			<div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">Erreur 404</h3>
                </div>
                <div class="panel-body">
					Opps, la page que vous demandez n'est pas disponible...
					<br>
					<a href="../accueil"><button type="button" class="btn btn-lg btn-primary">Aller à l'accueil</button></a>
                </div>
            </div>
</div>
<?php
require_once ("../jointures/footer.php");
?>
