<?php
session_start();
unset($_SESSION);
unset($_COOKIE);
session_destroy();

echo '<meta http-equiv="refresh" content="0; URL=../accueil/">'; 
?>