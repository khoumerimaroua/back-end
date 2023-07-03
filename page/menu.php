<nav class="navbar navbar-expand-lg bg-light">
	<div class="container-fluid">
		<a class="navbar-brand" href="#">Navbar</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="../index.php"> Home</a>
				</li>
				<?php if (isset($_SESSION['user'])) : ?>
					<li class="nav-item">
						<a class="nav-link" href="profil.php?id=<?= $_SESSION['user']->id ?>"> Profil</a>
					</li>
				<?php endif; ?>
				<?php if (isset($_SESSION['admin'])) : ?>
					<li class="nav-item">
						<a class="nav-link" href="admin.php"> Admin </a>
					</li>
				<?php endif; ?>
				<?php if (!isset($_SESSION['admin']) && !isset($_SESSION['user'])) : ?>
					<li class="nav-item">
						<a class="nav-link" href="connexion.php"> Connexion </a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="inscription.php"> Inscription </a>
					</li>
				<?php endif; ?>
				<?php if (isset($_SESSION['admin']) || isset($_SESSION['user'])) : ?>
					<li class="nav-item">
						<a class="nav-link" href="../action/logout.php"> Logout </a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</nav>