<?php
require_once '../include/database.php';

if (isset($_POST['connexion'])) {
    // Vérifier que les champs ne sont pas vides
    if (!empty($_POST['mail']) && !empty($_POST['mp'])) {
        // Récupérer les données du formulaire
        $mail = htmlspecialchars($_POST['mail']);
        $mp = htmlspecialchars($_POST['mp']);

        // Vérifier l'existence de l'utilisateur dans la base de données et que son compte est activé
        $query = "SELECT * FROM utilisateur WHERE Mail = :mail";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':mail', $mail);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_OBJ);

        if ($user && $user->IsActive == 1 && password_verify($mp, $user->mp)) {
            session_start();
            // Vérifier le rôle de l'utilisateur
            $query_role = "SELECT role FROM utilisateur WHERE Mail = :mail";
            $statement_role = $pdo->prepare($query_role);
            $statement_role->bindValue(':mail', $mail);
            $statement_role->execute();

            $user_role = $statement_role->fetchColumn();

            if ($user_role == 1) {
                // Connexion en tant qu'administrateur
                $_SESSION['admin'] = true;
                $_SESSION['flash']['success'] = "Vous êtes connecté en tant qu'administrateur";
            }

            // Connexion en tant qu'utilisateur
            $_SESSION['user'] = $user;
            $_SESSION['flash']['success'] = "Vous êtes connecté";
            header('Location: ../page/profil.php?id=' . $_SESSION['user']->id);
            exit();
        } else {
            session_start();
            // Identifiants ou mot de passe incorrects
            $_SESSION['flash']['danger'] = "Identifiants ou mot de passe incorrects.";

            // Vérifier si le compte de l'utilisateur est désactivé
            if ($user && $user->IsActive == 0) {
                $_SESSION['flash']['danger'] = "Compte désactivé. Veuillez contacter l'administrateur.";
            }

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
?>
