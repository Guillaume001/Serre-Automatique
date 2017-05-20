<?php
session_start();
$titre = "Données";
require_once ("../jointures/header.php");
require_once("../configuration/baseDonnees.php");
?>
<div class="contenu">
<?php
if(isset($_SESSION["utilisateur"])) {
	if(isset($_GET['id_del']))
		{
			$id_del = $_GET['id_del'];
			$delete = $bdd->prepare('DELETE FROM bac WHERE id = :id_del');
			$delete -> bindParam(':id_del', $id_del);
			$delete -> execute();
			echo '<div class="alert alert-success">Ligne correctement supprimée</div>';
		}
?>
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Temp int</th>
            <th>Hum int</th>
            <th>Lum int</th>
            <th>Temp ext</th>
            <th>Hum ext</th>
            <th>Temp min</th>
            <th>Temp max</th>
            <th>Lum min</th>
            <th>Hum min</th>
            <th>Eau</th>
            <th>Actions</th>
        </tr>
        </thead>
		
        <?php
        $requete = $bdd->prepare("SELECT * FROM bac");
        $requete->execute();

        while($resultats = $requete->fetch(PDO::FETCH_OBJ))
        {
            echo '<tr>';
            echo '<td>'.$resultats->id.'</td>';
            echo '<td>'.$resultats->jour.'/'.$resultats->mois.'/'.$resultats->annee.'</td>';
            echo '<td>'.$resultats->heure.':'.$resultats->minute.':'.$resultats->seconde.'</td>';
            echo '<td>'.$resultats->int_temp.'</td>';
            echo '<td>'.$resultats->int_hum.'</td>';
            echo '<td>'.$resultats->int_lum.'</td>';
            echo '<td>'.$resultats->ext_temp.'</td>';
            echo '<td>'.$resultats->ext_hum.'</td>';
            echo '<td>'.$resultats->param_temp_min.'</td>';
            echo '<td>'.$resultats->param_temp_max.'</td>';
            echo '<td>'.$resultats->param_lum.'</td>';
            echo '<td>'.$resultats->param_hum.'</td>';
            echo '<td>'.$resultats->eau.'</td>';
            
            echo '<td>';
			echo '<a href="?id_del='.$resultats->id.'"><button type="button" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Suppr</button></a>';
			echo '</td>';
            echo '</tr>';
        }
        ?>

    </table>
</div>
</div>
<?php
} else { echo '<meta http-equiv="refresh" content="1;URL=../pages/connexion.php">'; }
require_once ("../jointures/footer.php");
?>
