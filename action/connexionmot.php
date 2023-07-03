<?php
require_once '../include/database.php';

if (isset($_POST['connexion'])) {
    // On vérifie que les champs ne sont pas vides
    if (!empty($_POST['mail']) && !empty($_POST['mp'])) {
        // On récupère les données du formulaire
        $mail = htmlspecialchars($_POST['mail']);
        $mp = htmlspecialchars($_POST['mp']);

        // On vérifie que l'utilisateur existe dans la base de données
        $query = "SELECT * FROM utilisateur WHERE mail = :mail";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':mail', $mail);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_OBJ);

        // Si l'utilisateur existe, on vérifie le mot de passe
        if ($user) {
            // Vérification du mot de passe
            if (password_verify($mp, $user->mp)) {
                session_start();
                // Si l'utilisateur est un admin, on le connecte en tant qu'admin
                if ($user->role == 1) {
                    $_SESSION['admin'] = $user;
                    $_SESSION['flash']['success'] = "Vous êtes connecté en tant qu'administrateur";
                    header('Location: ../page/admin.php');
                    exit();
                } else {
                    // Sinon, on le connecte en tant qu'utilisateur
                    $_SESSION['user'] = $user;
                    $_SESSION['flash']['success'] = "Vous êtes connecté";
                    header('Location: ../page/profil.php?id=' . $_SESSION['user']->id);
                    exit();
                }
            } else {
                // Mot de passe incorrect
                session_start();
                $_SESSION['flash']['danger'] = "Identifiants ou mot de passe incorrects";
                header('Location: ../page/connexion.php');
                exit();
            }
        } else {
            // Utilisateur non trouvé
            session_start();
            $_SESSION['flash']['danger'] = "Identifiants ou mot de passe incorrects";
            header('Location: ../page/connexion.php');
            exit();
        }
    } else {
        // Champs du formulaire vides
        session_start();
        $_SESSION['flash']['danger'] = "Veuillez remplir tous les champs du formulaire";
        header('Location: ../page/connexion.php');
        exit();
    }
}