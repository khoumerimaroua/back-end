<?php

session_start();

// on detruit la session
if (isset($_SESSION['user'])) {
	unset($_SESSION['user']);
}
if (isset($_SESSION['admin'])) {
	unset($_SESSION['admin']);
}
// on affiche un message de succes
$_SESSION['flash']['success'] = 'Vous êtes maintenant déconnecté';
// on redirige l'utilisateur vers la page d'accueil
header('Location: ../index.php');
exit();