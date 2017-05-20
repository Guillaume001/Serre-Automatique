<?php
session_start();
$titre = "Paramètres";
require_once ("../jointures/header.php");
require_once("../configuration/baseDonnees.php");
?>
<div class="contenu">

<?php
if(isset($_SESSION["utilisateur"])) {

if ($_GET["log"] == "vider" ) {
	file_put_contents('../py/erreur.txt', '');
}

if($_GET["erreur"] == "supp" ) {
	
		$requete = $bdd->prepare("SELECT * FROM bac");
		$requete->execute();
		
		while($resultats = $requete->fetch(PDO::FETCH_OBJ))
			{
				if(
				$resultats->int_temp <= 0.00 OR $resultats->int_temp > 40.50
				OR $resultats->ext_temp <= 0.00 OR $resultats->ext_temp > 40.50
				OR ($resultats->int_hum < 0) OR ($resultats->int_hum > 100)
				OR ($resultats->int_lum < 0) OR ($resultats->int_lum > 100)
				OR ($resultats->ext_lum < 0) OR ($resultats->ext_lum > 100)
				OR ($resultats->ext_hum < 0) OR ($resultats->ext_hum > 100)
				OR ($resultats->param_hum < 0) OR ($resultats->param_hum > 100)
				OR ($resultats->param_lum < 0) OR ($resultats->param_lum > 100)
				OR $resultats->param_temp_min <= 0.00 OR $resultats->param_temp_min > 40.50
				OR $resultats->param_temp_max <= 0.00 OR $resultats->param_temp_max > 40.50
				OR $resultats->param_temp_min > $resultats->param_temp_max
				){
					$delete = $bdd->prepare('DELETE FROM bac WHERE id = :id_del');
					$delete -> bindParam(':id_del', $resultats->id);
					$delete -> execute();
				}
			}

}

if(isset($_GET["compte"])) {
	
	$id = $_GET["compte"];
	
	$delete = $bdd->prepare('DELETE FROM comptes WHERE id = :id_del');
	$delete -> bindParam(':id_del', $id);
	$delete -> execute();
	
	?>
	
	<div class="alert alert-success">
	  <strong>Succès !</strong> Utilisateur supprimé !
	</div>
	
	<?php

}

if(isset($_POST['user']))
{
	if($_POST['mdp'] == $_POST['mdp_c']){
		$mdp = md5($_POST['mdp']);
		
		$req = $bdd->prepare('INSERT INTO comptes(login, password) VALUES(:login, :password)');
		$req -> bindParam(':login', $_POST['user']);
		$req -> bindParam(':password', $mdp);
		$req -> execute();
		
	?>
	<div class="alert alert-success">
	  <strong>Succès !</strong> Utilisateur ajouté !
	</div>
	<?php
	} else {
		?>
		
		<div class="alert alert-danger">
		  <strong>Erreur !</strong> Confirmer le mot de passe !
		</div>
		
		<?php
	}
	
}


if(!empty($_POST['reboot'])) {
require_once("../configuration/connexionSSH.php");
ssh2_exec($connection,"stty -F /dev/ttyACM0 0:0:cbe:0:3:1c:7f:15:4:0:0:0:11:13:1a:0:12:f:17:16:0:0:0:0:0:0:0:0:0:0:0:0:0:0:0:0");
ssh2_exec($connection,"> /dev/ttyACM0");
ssh2_exec($connection,"stty -F /dev/ttyACM0 0:0:8be:0:3:1c:7f:15:4:0:0:0:11:13:1a:0:12:f:17:16:0:0:0:0:0:0:0:0:0:0:0:0:0:0:0:0");

file_put_contents('../py/reboot.txt', '');
file_put_contents('../py/reboot.txt', time());

}


?>
<div class="col-lg-8">
		<div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-gear" aria-hidden="true"></i> Paramètres</h3>
            </div>
            <div class="panel-body" align="center">
				<div class="table-responsive">
					<table class='table'>
					<thead>
					  <tr>
						<th>Nom</th>
						<th>Nombre</th>
						<th>Action</th>
					  </tr>
					</thead>
					<tbody>
						<tr>
							<td>Relevés automatiques</td>
							<td>
							  <?php
							  $nombre_requete = $bdd->query('SELECT COUNT(*) AS nb_data FROM bac');
							  $data = $nombre_requete->fetch();
							  echo $data['nb_data'];
							  ?>
							</td>
							<td>
							<input type="button" class="btn btn-info" onclick="location.href='../pages/donnees.php';" value="Voir les données" />
							</td>
						</tr>
						<tr>
							<td>Relevés faux</td>
							<td>
							
							<?php
							$requete = $bdd->prepare("SELECT * FROM bac");
							$requete->execute();
							$a = 0;
							while($resultats = $requete->fetch(PDO::FETCH_OBJ))
								{
									if(
									$resultats->int_temp <= 0.00 OR $resultats->int_temp > 40.50
									OR $resultats->ext_temp <= 0.00 OR $resultats->ext_temp > 40.50
									OR ($resultats->int_hum < 0) OR ($resultats->int_hum > 100)
									OR ($resultats->int_lum < 0) OR ($resultats->int_lum > 100)
									OR ($resultats->ext_lum < 0) OR ($resultats->ext_lum > 100)
									OR ($resultats->ext_hum < 0) OR ($resultats->ext_hum > 100)
									OR ($resultats->param_hum < 0) OR ($resultats->param_hum > 100)
									OR ($resultats->param_lum < 0) OR ($resultats->param_lum > 100)
									OR $resultats->param_temp_min <= 0.00 OR $resultats->param_temp_min > 40.50
									OR $resultats->param_temp_max <= 0.00 OR $resultats->param_temp_max > 40.50
									OR $resultats->param_temp_min > $resultats->param_temp_max
									){
										$a++;
									}
								}
								echo $a;
							?>
							
							</td>
							<td>
							
							<input type="button" class="btn btn-danger" onclick="location.href='param.php?erreur=supp';" value="Supprimer" />
							
							</td>
							<tr>
							
							<td>Bug Arduino</td>
							<td>
							<?php
							$fich = '../py/erreur.txt';

							$tabFich = file($fich);

							$nbLignes = count($tabFich);
							echo $nbLignes;
							?>
							</td>
							<td>
							
								<input type="button" class="btn btn-danger" onclick="location.href='param.php?log=vider';" value="Vider" />
							
							</td>
							
							</tr>
						</tr>
					</tbody>
				</table>
				</div>
				
				
            </div>
        </div>
</div>
<div class="col-lg-4">
		<div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-gear" aria-hidden="true"></i> Log erreur</h3>
            </div>
            <div class="panel-body" align="center">
				<div class="table-responsive">
				<textarea readonly style="margin: 0px; width: 500px; height: 160px;">
				<?php
                    $file = "../py/erreur.txt";
                    echo file_get_contents($file);
                ?>
				</textarea>
				</div>
				<?php
					$file = "../py/reboot.txt";
					echo "Dernier redémarrage manuel le : ".date('d-m-Y à H:i:s',file_get_contents($file));
                ?>
				<button type="button" class="btn btn-info" data-toggle="modal" data-target="#reboot"><i class="fa fa-refresh" aria-hidden="true"></i> Redémarrage</button>
            </div>
        </div>
</div>
<div class="col-lg-12">
		<div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-users" aria-hidden="true"></i> Gérer comptes</h3>
            </div>
            <div class="panel-body" align="center">
				<?php
				$requete = $bdd->prepare("SELECT * FROM comptes");
				$requete->execute();
				?>
				<table class='table'>
					<thead>
					  <tr>
						<th>ID</th>
						<th>Identifiant</th>
						<th>Dernière connexion</th>
						<th>Action</th>
					  </tr>
					</thead>
					<tbody>
				<?php
					while($resultats = $requete->fetch(PDO::FETCH_OBJ))
					{
						echo "<tr><td>".$resultats->id."</td>";
						echo "<td>".$resultats->login."</td>";
						echo "<td>".date('d-m-Y à H:i:s',$resultats->derniere)."</td>";
						?>
						<td><input type="button" class="btn btn-danger" onclick="location.href='param.php?compte=<?php echo $resultats->id; ?>';" value="Supprimer" /></td></tr>
						<?php
					}
				?>
					</tbody>
				</table>
				<br>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#ajoutCompte">Ajouter un compte</button>
            </div>
        </div>
</div>

<div id="ajoutCompte" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ajouter un nouveau compte</h4>
      </div>
      <div class="modal-body">
	  
	    <form action="#" method="post">
		
			<div class="form-group">
				<label for="login">Identifiant :</label>
				<input type="text" class="form-control" id="user" name="user">
			  </div>
			  <div class="form-group">
				<label for="pwd">Mot de passe :</label>
				<input type="password" class="form-control" id="mdp" name="mdp">
			  </div>
			  <div class="form-group">
				<label for="pwd">Confirmer le mot de passe :</label>
				<input type="password" class="form-control" id="mdp_c" name="mdp_c">
			  </div>
			  
	  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
		<button type="submit" class="btn btn-info">Créer !</button>
		
		</form>
      </div>
    </div>

  </div>
</div>


<div id="reboot" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Redémarrage de la serre</h4>
      </div>
      <div class="modal-body">
	  
		Êtes vous sur de vouloir redémarer la serre ?
	  
      </div>
      <div class="modal-footer">
		  <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
				<button type="submit" class="btn btn-danger" id="reboot" name="reboot" value="reboot"><i class="fa fa-refresh" aria-hidden="true"></i> Oui</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Non</button>
		  </form>
      </div>
    </div>

  </div>
</div>
		
<?php
} else { echo '<meta http-equiv="refresh" content="1;URL=../pages/connexion.php">'; }
require_once ("../jointures/footer.php");
?>
