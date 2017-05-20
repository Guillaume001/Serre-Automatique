<?php
session_start();
$titre = "Timelapse";
require_once ("../jointures/header.php");
require_once("../configuration/baseDonnees.php");
?>
<div class="contenu">
<?php
if(isset($_SESSION["utilisateur"])) {


if (isset($_GET["suppr"])) {
	$fichier = $_GET["suppr"];
	require_once("../configuration/connexionSSH.php");
	ssh2_exec($connection,"rm ".$DirRoot."img/capture/".$fichier);
}


?>


<div class="col-lg-8">
		<div class="panel panel-info">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-camera" aria-hidden="true"></i> Captures</h3>
            </div>
            <div class="panel-body" align="center">
				<img id='rendu' src="../img/favicon.png"/>
            </div>
        </div>
</div>

<div class="col-lg-4">
		<div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-history" aria-hidden="true"></i> Listes des images</h3>
            </div>
            <div class="panel-body" align="center">
			Survoler les noms des images sur la droit pour les faire apparaitres.<br>
				<div class="table-responsive">
				<table class="table table-hover">
				<thead>
				<tr>
					<th>Fichier</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				
				<?php 
				$dir = "../img/capture/";
				
				if (is_dir($dir)) {

				   if ($dh = opendir($dir)) {

					   while (($file = readdir($dh)) !== false) {

						   if( $file != '.' && $file != '..') {
							   ?>
							   <tr onmouseover="survol('<?php echo $dir.$file; ?>');">
								<td><?php echo $file;?></td>
								<td><input type="button" class="btn btn-danger btn-sm" onclick="location.href='timelapse.php?suppr=<?php echo $file;?>';" value="Supprimer" /></td>
							   </tr>
							   <?php
						   }
					   }
					   
					   closedir($dh);
				   }
				}
				?>
				</tbody>
				</table>
				</div>
            </div>
        </div>
</div>

</div>

<script>
var survol = function(param) {
   document.getElementById("rendu").src=param;
}
</script>
<?php
} else { echo '<meta http-equiv="refresh" content="1;URL=../pages/connexion.php">'; }
require_once ("../jointures/footer.php");
?>
