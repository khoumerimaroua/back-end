<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include 'base.php'; ?>
	<title>Inscription</title>
</head>
<body>
<?php include 'menu.php'; ?>
<div class="container-fluid d-flex justify-content-center align-items-center vh-100">
	<div class="col-md-6">
		<?php if (isset($_SESSION['flash'])) : ?>
			<?php foreach ($_SESSION['flash'] as $type => $message) : ?>
				<div class="ms-1 me-3 alert alert-<?= $type; ?>">
					<?= $message; ?>
				</div>
			<?php endforeach; ?>
			<?php unset($_SESSION['flash']); ?>
		<?php endif; ?>
		<h1 class="text-center">Inscription</h1>
		<form action="../action/register.php" method="post"  enctype="multipart/form-data">
			<div class="m-2">
				<label for="nom">Votre nom:</label>
				<input type="text" name="nom" class="form-control">
			</div>
			<div class="m-2">
				<label for="mail">Votre email:</label>
				<input type="email" name="mail" class="form-control">
			</div>
			<div class="m-2">
				<label for="mp">Votre mot de passe:</label>
				<input type="password" name="mp" class="form-control">
			</div>
			<div class="m-2">
		 <input type="file" name="fileToUpload" id="fileToUpload">
         <input type="submit" value="Image téléchargé" name="submit">
          </div>
  <div class="m-3 text-center">
				<input type="submit" value="Envoyer" name="inscription" class="btn btn-warning">
			</div>
</form>
	</div> 
</div>



</body>

</html>