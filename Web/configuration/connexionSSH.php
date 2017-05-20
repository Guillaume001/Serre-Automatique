<?php
$connection = ssh2_connect('[IP]', [PORT]); //[IP] = hote ssh [PORT] = port de l'hote
ssh2_auth_password($connection, '[USER]', '[PASS]'); //[USER] = compte ssh [PASS] = mot de passe du compte
$DirRoot = "/var/www/html/"; //Adapter le lien suivant la structure de votre serveur
?>