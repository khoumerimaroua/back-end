<?php


require_once '../include/database.php';
session_start();
// Vérifier si l'identifiant de la liste à supprimer est spécifié dans l'URL
if (isset($_GET['wishlistId']) && !empty($_GET['wishlistId'])) {
    $wishlistId = $_GET['wishlistId'];

    // Requête SQL pour supprimer la liste de souhaits
    $query = "DELETE FROM `Liste de souhaits` WHERE `idListe de souhaits` = :wishlistId";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':wishlistId', $wishlistId, PDO::PARAM_INT);
        $stmt->execute();

        // Rediriger vers la page du profil de l'utilisateur après la suppression
        $_SESSION['flash']['success'] = "La liste de souhaits a été supprimée avec succès.";

        // Rediriger vers la page du profil de l'utilisateur après la suppression
        header("Location: ../page/profil.php?id=" . $_SESSION['user']->id);
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        exit();
    }
} else {
    // Rediriger vers la page du profil de l'utilisateur si l'identifiant de la liste n'est pas spécifié
    $_SESSION['flash']['danger'] = "Identifiant de la liste de souhaits manquant.";
    header('Location: ../page/profile.php?id=' . $_SESSION['user']->id);
    exit();
}
?>
