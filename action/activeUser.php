<?php
require_once '../include/database.php';
require_once '../include/function.php';

// on vérifie que l'utilisateur est connecté
logged_only();

// on récupère l'ID de l'utilisateur à activer depuis l'URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Mettez à jour le champ "IsActive" de l'utilisateur à 1 (actif)
    $query = "UPDATE utilisateur SET IsActive = 1 WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':id', $userId);
    $statement->execute();

    // Redirigez vers la page admin.php avec un message flash de succès
    $_SESSION['flash']['success'] = "L'utilisateur a été activé avec succès.";
    header('Location: ../page/admin.php');
    exit();
} else {
    // Redirigez vers la page admin.php avec un message flash d'erreur
    $_SESSION['flash']['danger'] = "Une erreur s'est produite lors de l'activation de l'utilisateur.";
    header('Location: ../page/admin.php');
    exit();
}
?>
