<?php
session_start();
$titre = "Live";
require_once ("../jointures/header.php");
require_once("../configuration/baseDonnees.php");
?>
<div class="contenu">

<?php
if(isset($_SESSION["utilisateur"])) {

if(!empty($_POST['live'])) {
require_once("../configuration/connexionSSH.php");

ssh2_exec($connection,"python ".$DirRoot."py/recup_data.py && fswebcam -r 640x480 ".$DirRoot."img/live.jpg");
}
?><?php
	$requete = $bdd->prepare("SELECT * FROM live");
	$requete->execute();
	
	echo '<div class="alert alert-info">';
	?>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<button type="submit" class="btn btn-info" id="live" name="live" value="live"><i class="fa fa-refresh" aria-hidden="true"></i> Actualiser</button>
		<form>
		<?php
		$filename = "../img/live.jpg";
		
		echo 'Dernière actualisation le '.date("d-m-Y à H:i:s", filemtime($filename)).'</div>';
		
	while($resultats = $requete->fetch(PDO::FETCH_OBJ))
	{
?>

<div class="col-lg-8">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-camera" aria-hidden="true"></i> Webcam</h3>
			</div>
			<div class="panel-body" align="center">
			<?php
			echo "<img src=../img/live.jpg?" . time() . " style='width:100%;max-width: 640px;'>";
			?>
		</div>
		</div>
</div>

<div class="col-lg-4">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-tasks" aria-hidden="true"></i> Capteurs</h3>
			</div>
			<div class="panel-body" align="center">
			<div class="table-responsive">          
			  <table class="table">
				<thead>
				  <tr>
					<th></th>
					<th>Intérieur</th>
					<th>Extérieur</th>
				  </tr>
				</thead>
				<tbody>
				  <tr>
					<td><i class="fa fa-thermometer-half" aria-hidden="true"></i> Température (°C)</td>
					<td><?php echo $resultats->int_temp; ?></td>
					<td><?php echo $resultats->ext_temp; ?></td>
				  </tr>
				  <tr>
					<td><i class="fa fa-tint" aria-hidden="true"></i> Humidite (%)</td>
					<td><?php echo $resultats->int_hum; ?></td>
					<td><?php echo $resultats->ext_hum; ?></td>
					
				  </tr>
				  <tr>
					<td><i class="fa fa-sun-o" aria-hidden="true"></i> Luminosité (%)</td>
					<td>N/A</td>
					<td><?php echo $resultats->int_lum; ?></td>
				  </tr>
				</tbody>
			   </table>
			</div>
			Réserve d'eau : 
			<?php
			if($resultats->eau == 1){
				echo "OK";
			} else {
				echo "KO";
			}			
			?>
		</div>
		</div>
</div>

<div class="col-lg-4">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-sliders" aria-hidden="true"></i> Contraintes</h3>
			</div>
			<div class="panel-body" align="center">
			<div class="table-responsive">          
			  <table class="table">
				<tbody>
				  <tr>
					<td><i class="fa fa-thermometer-empty" aria-hidden="true"></i> Température min (°C)</td>
					<td><?php echo $resultats->param_temp_min; ?></td>
					</tr>
					<tr>
					<td><i class="fa fa-thermometer-full" aria-hidden="true"></i> Température max (°C)</td>
					<td><?php echo $resultats->param_temp_max; ?></td>
					</tr>
					<tr>
					<td><i class="fa fa-tint" aria-hidden="true"></i> Humidite min (%)</td>
					<td><?php echo $resultats->param_hum; ?></td>
					</tr>
					<tr>
					<td><i class="fa fa-sun-o" aria-hidden="true"></i> Luminosité min (%)</td>
					<td><?php echo $resultats->param_lum; ?></td>
				  </tr>
				</tbody>
			   </table>
			</div>
			</div>
		</div>
</div>

<?php 
	}
?>

<!--<div class="col-lg-4">
		<div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-history" aria-hidden="true"></i> Webcam Historique</h3>
            </div>
            <div class="panel-body" align="center">
				<?php
				$dirname = '../img/capture/';
				$dir = opendir($dirname);
				
				while($file = readdir($dir)) {
					if($file != '.' && $file != '..' && !is_dir($dirname.$file))
					{
						$fichier = $file;
						echo "<img class='diapo' src='".$dirname.$file."' style='width:90%'>";
					}
				}
				closedir($dir);
				echo "<a href='../img/capture'>Accès</a>";
				 ?>
            </div>
        </div>
		<script>
			var myIndex = 0;
			carousel();

			function carousel() {
				var i;
				var x = document.getElementsByClassName("diapo");
				for (i = 0; i < x.length; i++) {
				   x[i].style.display = "none";  
				}
				myIndex++;
				if (myIndex > x.length) {myIndex = 1}    
				x[myIndex-1].style.display = "block";  
				setTimeout(carousel, 500);
			}
		</script>-->
</div>
<?php
} else { echo '<meta http-equiv="refresh" content="1;URL=../pages/connexion.php">'; }
require_once ("../jointures/footer.php");
?>
