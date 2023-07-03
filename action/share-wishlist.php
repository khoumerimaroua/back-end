<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if (isset($_GET['link'])) {
        $wishlistLink = $_GET['link'];
      // Recherchez l'utilisateur ayant le lien de partage correspondant
        $query = "SELECT * FROM utilisateur WHERE wishlist_link = :wishlistLink";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':wishlistLink', $wishlistLink);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_OBJ);

        if ($user) {
            // L'utilisateur ayant le lien de partage existe
            $userId = $user->id;

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
                    echo "<li>" . $item->nom . "</li>";
                }
                echo "</ul>";
            } else {
                echo "La liste de souhaits de cet utilisateur est vide.";
            }
        } else {
            // Lien de partage invalide
            echo "Lien de partage invalide.";
        }
    } else {
        // Lien de partage manquant
        echo "Lien de partage manquant.";
    }
    ?>
</body>
</html>
