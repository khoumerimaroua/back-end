<?php
require_once '../include/database.php';

session_start();

// On récupère l'id de l'utilisateur dans l'URL
$id = $_GET['id'];

// Supprimer les enregistrements de la table 'liste de souhaits' liés à l'utilisateur
$queryWishlist = "DELETE FROM `liste de souhaits` WHERE id = :id";
$statementWishlist = $pdo->prepare($queryWishlist);
$statementWishlist->execute([':id' => $id]);

// Supprimer les commentaires de l'utilisateur
$queryComments = "DELETE FROM commentaire WHERE id = :id";
$statementComments = $pdo->prepare($queryComments);
$statementComments->execute([':id' => $id]);

// Supprimer l'utilisateur de la base de données
$query = "DELETE FROM utilisateur WHERE id = :id";
$statement = $pdo->prepare($query);
$statement->execute([':id' => $id]);

// Vérifier si l'utilisateur est un admin
if (isset($_SESSION['admin'])) {
    $_SESSION['flash']['danger'] = "L'utilisateur a bien été supprimé";
    header("Location: ../page/admin.php");
    exit();
} else {
    // Rediriger vers la page d'accueil
    session_destroy();
    $_SESSION['flash']['danger'] = "Votre compte a bien été supprimé";
    header("Location: ../index.php");
    exit();
}

