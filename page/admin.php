<?php
require_once '../include/database.php';
require_once '../include/function.php';

// on vérifie que l'utilisateur est connecté
logged_only();

// on récupère tous les utilisateurs
$query = "SELECT * FROM utilisateur";
$statement = $pdo->prepare($query);
$statement->execute();
$users = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'base.php'; ?>
    <title>Admin</title>
</head>

<body>
    <?php include 'menu.php'; ?>
    <div class="container-fluid">
    <h1 class="mt-5 text-center text-success">Gestion des utilisateurs</h1>
      <h2 class="mt-3 text-center text-success">Bonjour administrateur: <?= $_SESSION['admin'] ?></h2>
  <!-- on affiche les messages flash -->
        <?php if (isset($_SESSION['flash'])) : ?>
            <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
                <div class="m-3 p-3 alert alert-<?= $type; ?>">
                    <?= $message; ?>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>
       <table class="table">
    <thead>
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Mail</th>
            <th scope="col">mp</th>
            <th scope="col">Role</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Afficher tous les utilisateurs -->
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= $user->Nom ?></td>
                <td><?= $user->Mail ?></td>
                <td><?= $user->mp ?></td>
                <td><?= $user->Role ?></td>
                
                <td>
                     <a href="../action/deleteUser.php?id=<?= $user->id ?>" onclick="return window.confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')" class="btn btn-danger" data-toggle="modal"> Supprimer</a>
                     <a href="../action/activeUser.php?id=<?= $user->id ?>" class="btn btn-success" data-toggle="modal"> Activer</a>
                     <a href="../action/desactiveUser.php?id=<?= $user->id ?>" class="btn btn-warning" data-toggle="modal"> Désactiver</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    </div>
</body>

</html>
