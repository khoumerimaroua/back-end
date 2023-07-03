<?php
require_once '../include/function.php';
require_once '../include/database.php';
logged_only();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'base.php'; ?>
    <title>Utilisateur | Profile</title>
    <style>
        .avatar-container {
  display: flex;
  justify-content: center;
  align-items: center;
  /* Ajoutez d'autres styles selon vos besoins */
}

.avatar-image {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  /* Autres styles personnalisés pour l'image */
}

    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container-fluid">
        <?php if (isset($_SESSION['flash'])) : ?>
            <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                <div class="m-3 p-3 alert alert-<?= $type; ?>">
                    <?= $message; ?>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
        <h1 class="text-center text-primary m-3">Bienvenue <?= $_SESSION['user']->Nom ?></h1>
        <?php // Récupérer le nom du fichier d'avatar de l'utilisateur connecté
$query = "SELECT Avatar FROM utilisateur WHERE Mail = :mail";
$statement = $pdo->prepare($query);
$statement->bindValue(':mail', $_SESSION['user']->Mail);
 // Utilisez la variable de session qui stocke l'e-mail de l'utilisateur connecté
$statement->execute();
$result = $statement->fetch();

// Vérifier si l'avatar existe pour l'utilisateur
if ($result && $result['Avatar']) {
    $avatarFileName = $result['Avatar'];
    $avatarPath = "../avatars/" . $avatarFileName;
// Afficher l'avatar
echo '<div class="avatar-container">';
echo '<img src="../avatars/'.$avatarPath.'" alt="Avatar" class="avatar-image">';
echo '</div>';

} 
?>
        <div class="card m-3">
            <div class="card-body d-flex justify-content-center">
                <a href="../action/ajouter.php" class="btn btn-success" data-toggle="modal">Créer une nouvelle liste de souhaits</a>
            </div>
        </div>

        <div class="row">
            <?php
            $userId = $_SESSION['user']->id;

            // Requête SQL pour récupérer les listes de souhaits de l'utilisateur
            $query = "SELECT * FROM `liste de souhaits` WHERE `id` = :userId";

            try {
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->execute();
                $wishlists = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Affichage des listes de souhaits
                foreach ($wishlists as $wishlist) {
            ?>
                    <div class="col-md-4">
                        <div class="card m-3">
                            <div class="card-body">
                                <h2 class="card-title text-warning">Liste de souhaits</h2>
                                <p class="card-text"><strong>Nom :</strong> <?= $wishlist['Nom'] ?></p>
                                <p class="card-text"><strong>Description :</strong> <?= $wishlist['Description'] ?></p>
                                <p class="card-text"><strong>Date :</strong> <?= $wishlist['date'] ?></p>
                                <div class="d-flex justify-content-end">
                                    <a href="../action/modifier.php?wishlistId=<?= $wishlist['idListe de souhaits'] ?>" class="btn btn-primary mx-3">Modifier</a>
                                    <a href="../action/supprimer.php?wishlistId=<?= $wishlist['idListe de souhaits'] ?>" onclick="return window.confirm('Êtes-vous sûr de vouloir supprimer cette liste ?!')" class="btn btn-danger" data-toggle="modal">Supprimer</a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } catch (PDOException $e) {
                echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
                exit();
            }
            ?>
        </div>
    </div>
   
</body>

</html>
