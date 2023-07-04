<?php
require_once '../include/database.php';

if (isset($_GET['link']) && isset($_GET['userId'])) {
    $wishlistLink = $_GET['link'];
    $userId = $_GET['userId'];

    // Vérifier si l'utilisateur existe dans la base de données
    $query = "SELECT * FROM `utilisateur` WHERE id = :userId";
    $statement = $pdo->prepare($query);
    $statement->bindValue(':userId', $userId);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_OBJ);

    if ($user) {
        // Insérer le lien de partage dans la base de données
        $query = "INSERT INTO `liste de souhaits` (wishlist_link, id) VALUES (:wishlistLink, :userId)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':wishlistLink', $wishlistLink);
        $statement->bindValue(':userId', $userId);
        $statement->execute();

        // Récupérer la liste de souhaits de l'utilisateur
        $query = "SELECT * FROM `liste de souhaits` WHERE id = :userId";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':userId', $userId);
        $statement->execute();

        $wishlistItems = $statement->fetchAll(PDO::FETCH_OBJ);

        if ($wishlistItems) {
            // Afficher la liste de souhaits de l'utilisateur
            echo "Liste de souhaits de " . $user->Nom . " : ";
            echo "<ul>";
            foreach ($wishlistItems as $item) {
                echo "<li>" . $item->Nom . "</li>";
            }
            echo "</ul>";
        } else {
            echo "La liste de souhaits de cet utilisateur est vide.";
        }
    } else {
        // L'utilisateur n'existe pas
        echo "Utilisateur inexistant.";
    }
} else {
    // Lien de partage ou ID utilisateur manquant
    echo "Lien de partage ou ID utilisateur manquant.";
}
?>
