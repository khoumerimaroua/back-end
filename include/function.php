<?php

function logged_only()
// cette fonction s'assure que seuls les utilisateurs connectés peuvent accéder à certaines pages. 
// Si un utilisateur non connecté tente d'accéder à ces pages, 
// il est redirigé vers la page de connexion. De plus,
//  si un utilisateur connecté tente d'accéder au profil d'un autre utilisateur, il est redirigé
//  vers son propre profil.
{
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])) {
		$_SESSION['flash']['warning'] = "Vous n'avez pas le droit d'accéder à cette page";
		header('Location: connexion.php');
		exit();
	}

	if (isset($_SESSION['user']) && !isset($_SESSION['admin'])) {
		// Si l'utilisateur est connecté en tant que user, vérifier s'il tente d'accéder à un profil différent
		if ($_SESSION['user']->id != $_GET['id']) { // Remplacez 'user_id' par la clé appropriée pour récupérer l'identifiant de l'utilisateur
			$_SESSION['flash']['warning'] = "Vous n'avez pas le droit d'accéder à cette page";
			header('Location: profil.php?id=' . $_SESSION['user']->id);
			exit();
		}
	}
}
