<?php
require_once '../include/database.php';
session_start();

if (isset($_POST['inscription'])) {
    // On vérifie que les champs ne sont pas vides
    if (!empty($_POST['nom']) && !empty($_POST['mail']) && !empty($_POST['mp'])) {
        // On récupère les données du formulaire
        $nom = htmlspecialchars($_POST['nom']);
        $mail = htmlspecialchars($_POST['mail']);
        $mp = htmlspecialchars($_POST['mp']);

        // On vérifie si l'adresse email est valide
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash']['danger'] = "Veuillez entrer une adresse e-mail valide";
            header('Location: ../page/inscription.php');
            exit();
        }

        // On vérifie que l'utilisateur n'existe pas dans la base de données
        $query = "SELECT * FROM utilisateur WHERE Mail = :mail";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':mail', $mail);
        $statement->execute();
        $user = $statement->fetch();

        // Si une erreur s'est produite lors de l'exécution de la requête SELECT
        if ($statement->rowCount() > 0) {
            $_SESSION['flash']['danger'] = "Cette adresse e-mail est déjà utilisée";
            header('Location: ../page/inscription.php');
            exit();
        }

        // On vérifie si l'utilisateur qui s'inscrit est un administrateur
        $role = 0; // Rôle "0" pour l'utilisateur
        if ($mail === 'ibrahimimaroua89@gmail.com') {
            $role = 1; // Rôle "1" pour l'administrateur
            $_SESSION['admin'] = true; // Définir la session de l'administrateur
        }

        // Hachage du mot de passe
        $hashedPassword = password_hash($mp, PASSWORD_DEFAULT);

        // Gestion de l'avatar
        $avatarName = null; // Par défaut, l'avatar est null

        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
            $avatarTmpPath = $_FILES['fileToUpload']['tmp_name'];
            $avatarName = $_FILES['fileToUpload']['name'];

            // Déplacer l'avatar vers le dossier de destination
            $destinationFolder = "../avatars/";
            $uniqueAvatarName = uniqid() . '_' . $avatarName;
            $avatarPath = $destinationFolder . $uniqueAvatarName;

            if (move_uploaded_file($avatarTmpPath, $avatarPath)) {
                // Avatar téléchargé avec succès
            } else {
                $_SESSION['flash']['danger'] = "Erreur lors du téléchargement de l'avatar";
                header('Location: ../page/inscription.php');
                exit();
            }
        }

        // On ajoute l'utilisateur dans la base de données
        $query = "INSERT INTO utilisateur (Nom, Mail, mp, Role, IsActive, Avatar) VALUES (:nom, :mail, :mp, :role, :isActive, :avatar)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':nom', $nom);
        $statement->bindValue(':mail', $mail);
        $statement->bindValue(':mp', $hashedPassword); // Utilisation du mot de passe haché
        $statement->bindValue(':role', $role);
        $statement->bindValue(':isActive', 1);
        $statement->bindValue(':avatar', $uniqueAvatarName);
        $statement->execute();

        // Vérification finale après l'ajout de l'utilisateur
        $query = "SELECT * FROM utilisateur WHERE Mail = :mail";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':mail', $mail);
        $statement->execute();
        $user = $statement->fetch();

        // Si l'utilisateur a été ajouté avec succès, on affiche un message de succès
        if ($user) {
            if ($role == 0) {
                $_SESSION['flash']['success'] = "Votre compte a bien été créé !";
                header('Location: ../page/connexion.php');
                exit();
            } else {
                $_SESSION['flash']['success'] = "L'utilisateur a bien été ajouté !";
                header('Location: ../page/admin.php');
                exit();
            }
        } else {
            // Une erreur s'est produite lors de l'ajout de l'utilisateur
            $_SESSION['flash']['danger'] = "Une erreur s'est produite lors de la création du compte";
            header('Location: ../page/inscription.php');
            exit();
        }
    } else {
        $_SESSION['flash']['danger'] = "Veuillez remplir tous les champs du formulaire";
        header('Location: ../page/inscription.php');
        exit();
    }
}
?>
