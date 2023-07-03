<?php


require_once '../include/database.php';
session_start();
// Vérifier si l'identifiant de la liste à modifier est spécifié dans le formulaire
if (isset($_POST['wishlistId']) && !empty($_POST['wishlistId'])) {
    $wishlistId = $_POST['wishlistId'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $date = $_POST['date']; // Récupérer la valeur de la date du formulaire

    // Requête SQL pour mettre à jour la liste de souhaits
    $query = "UPDATE `Liste de souhaits` SET `Nom` = :nom, `Description` = :description, `Date` = :date WHERE `idListe de souhaits` = :wishlistId";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR); // Binder la valeur de la date
        $stmt->bindParam(':wishlistId', $wishlistId, PDO::PARAM_INT);
        $stmt->execute();

        // Rediriger vers la page du profil de l'utilisateur après la modification
        $_SESSION['flash']['success'] = "La liste de souhaits a été modifiée avec succès.";
        header("Location: ../page/profil.php?id=" . $_SESSION['user']->id);
        exit();
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        exit();
    }
} elseif (isset($_GET['wishlistId']) && !empty($_GET['wishlistId'])) {
    $wishlistId = $_GET['wishlistId'];

    try {
        $query = "SELECT * FROM `Liste de souhaits` WHERE `idListe de souhaits` = :wishlistId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':wishlistId', $wishlistId, PDO::PARAM_INT);
        $stmt->execute();
        $wishlist = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si la liste de souhaits existe
        if (!$wishlist) {
            $_SESSION['flash']['danger'] = "La liste de souhaits n'existe pas.";
            header('Location: ../page/profil.php?id=' . $_SESSION['user']->id);
            exit();
        }

        // Assigner les valeurs de la liste de souhaits aux variables
        $nom = $wishlist['Nom'];
        $description = $wishlist['Description'];
        $date = $wishlist['date']; // Récupérer la valeur de la date
    } catch (PDOException $e) {
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        exit();
    }
} else {
    // Rediriger vers la page du profil de l'utilisateur si l'identifiant de la liste de souhaits n'est pas spécifié
    $_SESSION['flash']['danger'] = "Identifiant de la liste de souhaits manquant.";
    header('Location: ../page/profil.php?id=' . $_SESSION['user']->id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier la liste de souhaits</title>
</head>
<body>
<div class="container">
    <h1 class="text-center text-warning m-3">Modifier la liste de souhaits</h1>
    <form action="" method="POST">
        <input type="hidden" name="wishlistId" value="<?= $wishlistId; ?>">
        <div class="form-group m-3">
            <label for="nom">Nom :</label>
            <input type="text" class="form-control" name="nom" value="<?= $nom; ?>">
        </div>
        <div class="form-group m-3">
            <label for="description">Description :</label>
            <textarea class="form-control" name="description"><?= $description; ?></textarea>
        </div>
        <div class="form-group m-3">
            <label for="date">Date :</label>
            <input type="date" class="form-control" name="date" value="<?= $date; ?>">
        </div>
        <div class="text-center m-3">
            <button type="submit" class="btn btn-primary m-3">Modifier</button>
        </div>
    </form>
</div>

</body>
</html>
