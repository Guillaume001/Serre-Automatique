<?php
session_start();
$titre = "Connexion";
require_once("../jointures/header.php");
require_once("../configuration/baseDonnees.php");
?>

<div class="contenu">
<?php
    if (isset($_POST['login']) && isset($_POST['password'])) {

        $login = htmlspecialchars($_POST['login']);
        $password = htmlspecialchars($_POST['password']);

        $requete = $bdd->prepare('SELECT COUNT(*) FROM comptes WHERE login = :login');
        $requete->bindParam(':login', $login, PDO::PARAM_STR);
        $requete->execute();
        $nombreDeLignes = $requete->fetch();

        if ($nombreDeLignes[0] == 0) {
            $login_p = false;
        } else {

            $login_p = true;

            $requete = $bdd->prepare('SELECT * FROM comptes WHERE login = :login');
            $requete->bindParam(':login', $login, PDO::PARAM_STR);
            $requete->execute();
            $reponse = $requete->fetch();

            if (md5($password) == $reponse['password']) {
                $password_p = true;
				
				$req = $bdd->prepare('UPDATE comptes SET derniere = :derniere WHERE login = :pseudo');
				$req -> bindParam(':derniere', time());
				$req -> bindParam(':pseudo', $login);
				$req -> execute();
				
                $_SESSION['utilisateur'] = $reponse;
            } else {
                $password_p = false;
            }

            $requete->closeCursor();
        }

        if ($login_p == true && $password_p == true) {
            echo '<div class="alert alert-success"><a href="../accueil"><i class="fa fa-2x fa-spinner fa-pulse"></i> Continuer</a>
        <meta http-equiv="refresh" content="1;URL=../accueil"></div>';
        }
        if ($login_p == false OR $password_p == false) {
            echo '<div class="alert alert-danger"><i class="fa fa-minus-circle red"></i> Connexion refusée</div>';
        }
    }
    ?>
    <div class="login">
        <?php if(!isset($_SESSION["utilisateur"])) { ?>
            <h1>Connectez vous !</h1>
            <form id="signup" method="post" action="#">
                <div class="form-login">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <input id="login-username" type="text" class="form-control" name="login"
                               placeholder="Identifiant">
                    </div>
                </div>
                <div class="form-login">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock" aria-hidden="true"></i></span>
                        <input id="login-password" type="password" class="form-control" name="password"
                               placeholder="Mot de passe">
                    </div>
                </div>
                <div style="margin-top:10px" class="form-group">
                    <button type="submit" class="btn btn-success">Se connecter</button>
                </div>
            </form>
            <?php
        } else {
            echo "<h1>Vous êtes déjà connectez.</h1>";
        }
        ?>
    </div>
</div>

<?php
require_once("../jointures/footer.php");
?>
