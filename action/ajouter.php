<?php
session_start();

require_once '../include/database.php';
// Vérifie si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupère le titre et la description de la liste de souhaits depuis le formulaire
    $wishlistTitle = $_POST['nom'];
    $wishlistDescription = $_POST['description'];

    // Prépare la requête SQL pour insérer une nouvelle liste de souhaits
    $query = "INSERT INTO `Liste de souhaits` (Nom, Description, date, id) VALUES (:title, :description, CURDATE(), :userId)";

    try {
        // Exécute la requête
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':title', $wishlistTitle, PDO::PARAM_STR);
        $stmt->bindParam(':description', $wishlistDescription, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $_SESSION['user']->id, PDO::PARAM_INT);
        $stmt->execute();

        // Redirige l'utilisateur vers la page de profil avec un message de succès
        $_SESSION['flash']['success'] = "La liste de souhaits a été créée avec succès.";
        header("Location: ../page/profil.php?id=" . $_SESSION['user']->id);
        exit();
    } catch (PDOException $e) {
        // Affiche un message d'erreur si une exception se produit
        echo "Erreur lors de la création de la liste de souhaits : " . $e->getMessage();
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une liste de souhaits</title>
</head>
<body>
<div class="container">
    <h1 class="text-center text-warning m-3">Ajouter une liste de souhaits</h1>
    <form action="" method="POST">
        <div class="form-group m-3">
            <label for="nom">Nom :</label>
            <input type="text" class="form-control" name="nom">
        </div>
        <div class="form-group m-3">
            <label for="description">Description :</label>
            <textarea class="form-control" name="description"></textarea>
        </div>
        <div class="text-center m-3">
            <button type="submit" class="btn btn-primary m-3">Ajouter</button>
        </div>
    </form>
</div>

</body>
</html>
