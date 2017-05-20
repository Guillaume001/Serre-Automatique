<?php
ini_set('display_errors','off');
try
{
	$bdd = new PDO('mysql:host=[HOTE];dbname=[DB];charset=utf8', '[USER]', '[PASS]'); //[HOTE] = ip de l'hote + port (défault 3306) [DB] = nom base de donnée [USER] = utilisateur [PASS] = mot de passe de l'utilisateur
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}
?>