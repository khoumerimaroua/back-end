<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include 'base.php'; ?>
	<title>Connexion</title>
</head>

<body>
<?php include 'menu.php'; ?>
<div class="container-fluid pt-3 d-flex justify-content-center">
	<div class="col-md-6">
		<!-- on affiche les messages d'erreur -->
		<?php if (isset($_SESSION['flash'])) : ?>
			<?php foreach ($_SESSION['flash'] as $type => $message) : ?>
				<div class="m-3 p-3 alert alert-<?= $type; ?>">
					<?= $message; ?>
				</div>
			<?php endforeach; ?>
			<?php unset($_SESSION['flash']); ?>
		<?php endif; ?>
		<h1 class="text-center">Connexion</h1>
		<form action="../action/login.php" method="post" class="needs-validation" >

			<div class="form-group">
				<label for="mail">Votre email:</label>
				<input type="email" class="form-control" name="mail">
				<div class="invalid-feedback">Veuillez entrer votre email.</div>
			</div>

			<div class="form-group">
				<label for="mp">Votre mot de passe:</label>
				<input type="password" class="form-control" name="mp" >
				<div class="invalid-feedback">Veuillez entrer votre mot de passe.</div>
			</div>

			<div class="text-center m-3">
				<input type="submit" class="btn btn-warning " value="Envoyer" name="connexion">
			</div>

		</form>
	</div>
</div>



</body>

</html>