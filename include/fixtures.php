<?php
require_once '../vendor/autoload.php';
require_once 'database.php';

use Faker\Factory;

$faker = Factory::create();

// Remplissage de la table "Utilisateur"
for ($i = 0; $i < 10; $i++) {
    $nom = $faker->name;
    $mail = $faker->email;
    $mp = $faker->password;
    $isActive = 1;
    $role = 0;
    $avatar = $faker->imageUrl(200, 200, "people");

    $sql = "INSERT INTO `Utilisateur` (`Nom`, `Mail`, `Mp`, `IsActive`, `Role`, `Avatar`)
            VALUES (?, ?, ?, ?, ?, ?)";

    $statement = $pdo->prepare($sql);
    $statement->bindParam(1, $nom);
    $statement->bindParam(2, $mail);
    $statement->bindParam(3, $mp);
    $statement->bindParam(4, $isActive);
    $statement->bindParam(5, $role);
    $statement->bindParam(6, $avatar);
    $statement->execute();

    $userid=$pdo->lastInsertId();
    for ($j = 0; $j < 5; $j++) {
        $nom = $faker->word;
        $description = $faker->sentence;
        $date = $faker->date();

        $sql = "INSERT INTO `Liste de souhaits` (`Nom`, `Description`, `date`, `IdUtilisateur`)
                VALUES (?, ?, ?, ?)";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $nom);
        $statement->bindParam(2, $description);
        $statement->bindParam(3, $date);
        $statement->bindParam(4, $userid);
        $statement->execute();
      
    }
    // Remplissage de la table "Article"
for ($i = 0; $i < 10; $i++) {
    $nom = $faker->word;
    $description = $faker->sentence;

    $sql = "INSERT INTO `Article` (`Nom`, `Description`)
            VALUES (?, ?)";

    $statement = $pdo->prepare($sql);
    $statement->bindParam(1, $nom);
    $statement->bindParam(2, $description);
    $statement->execute();
}

// Remplissage de la table "Commentaire"
for ($i = 0; $i < 10; $i++) {
    $description = $faker->sentence;
    $date = $faker->date();
    $idUtilisateur = $faker->numberBetween(1, 10);
    $idListeDeSouhaits = $faker->numberBetween(1, 50);

    $sql = "INSERT INTO `Commentaire` (`description`, `Date`, `IdUtilisateur`, `IdListe de souhaits`)
            VALUES (?, ?, ?, ?)";

    $statement = $pdo->prepare($sql);
    $statement->bindParam(1, $description);
    $statement->bindParam(2, $date);
    $statement->bindParam(3, $idUtilisateur);
    $statement->bindParam(4, $idListeDeSouhaits);
    $statement->execute();
}

// Remplissage de la table "Liste de souhaits_has_Article"
for ($i = 0; $i < 10; $i++) {
    $idListeDeSouhaits = $faker->numberBetween(1, 50);
    $idArticle = $faker->numberBetween(1, 10);

    $sql = "INSERT INTO `Liste de souhaits_has_Article` (`IdListe de souhaits`, `IdArticle`)
            VALUES (?, ?)";

    $statement = $pdo->prepare($sql);
    $statement->bindParam(1, $idListeDeSouhaits);
    $statement->bindParam(2, $idArticle);
    $statement->execute();
}

echo "Données insérées avec succès dans les tables.";

}

?>
