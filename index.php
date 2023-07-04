<?php
session_start();
require_once 'include/database.php';

// Requête pour récupérer les listes de souhaits avec le nom de l'utilisateur
$query = "SELECT souhaits.*, utilisateur.nom AS nom_utilisateur FROM `liste de souhaits` AS souhaits
          INNER JOIN utilisateur ON souhaits.id = utilisateur.id";

$stmt = $pdo->query($query);
$listesSouhaits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	<title>Accueil</title>
</head>

<body>
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php"><i class="bi bi-house-door-fill"></i> Home</a>
                </li>
                <?php if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="page/connexion.php"><i class="bi bi-box-arrow-in-right"></i> Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="page/inscription.php"><i class="bi bi-pencil-square"></i> Inscription</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="page/profil.php?id=<?= $_SESSION['user']->id ?>"><i class="bi bi-person-lines-fill"></i> Profil</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['admin'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="page/admin.php"><i class="bi bi-database-gear"></i> Admin</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['admin']) || isset($_SESSION['user'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="action/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <h1 class="card-title text-black text-center m-3">Liste de souhaits</h1>

    <div class="row">
        <?php
        // Affichage des listes de souhaits
        foreach ($listesSouhaits as $liste) {
            echo '<div class="col-md-4">';
            echo '<div class="card m-3">';
            echo '<div class="card-body ">';
            echo '<h5 class="card-text  text-primary">Utilisateur: ' . $liste['nom_utilisateur'] . '</h5>';
            echo '<h6 class="card-text   text-warning ">' . $liste['Nom'] . ':</h6>';
            echo '<p class="card-text text-muted">' . $liste['Description'] . '</p>';
            echo '<p class="card-text text-muted">' . $liste['date'] . '</p>';
            
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        
        ?>
    </div>
</div>

</body>

</html>
