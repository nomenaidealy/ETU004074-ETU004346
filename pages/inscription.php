<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | Plateforme Étudiante</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
</head>

<body class="bg-light">
    <main class="container min-vh-100 d-flex align-items-center justify-content-center">
        <section class="col-md-6 col-lg-4">
            <article class="card shadow border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <i class="bi bi-mortarboard fs-1 mb-2"></i>
                    <h1 class="h4 mb-0">Inscription Étudiante</h1>
                </div>
                <div class="card-body p-4">
                    <form action="Traitement_inscription.php" method="post">

                        <div class="mb-3">
                            <label for="nom" class="form-label"><i class="bi bi-person me-2"></i>Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" required>

                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label"><i class="bi bi-envelope me-2"></i>date de naissance </label>
                            <input type="date" class="form-control" id="date" name="date" placeholder="date_naissance" required>
                        </div>
                        <div class="mb-3">
                            <label for="genre" class="form-label"><i class="bi bi-envelope me-2"></i>genre</label>
                            <input type="genre" class="form-control" id="genre" name="genre" placeholder="genre" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><i class="bi bi-envelope me-2"></i>Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="votre@email.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="ville" class="form-label"><i class="bi bi-envelope me-2"></i>ville</label>
                            <input type="ville" class="form-control" id="ville" name="ville" placeholder="ville" required>
                        </div>
                        <div class="mb-4">
                            <label for="mdp" class="form-label"><i class="bi bi-lock me-2"></i>Mot de passe</label>
                            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" required>
                        </div>
                        <div class="mb-3">
                            <label for="fichier" class="form-label">Choisissez une image :</label>
                            <input type="file" name="fichier" id="fichier" class="form-control" accept="image/*" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-check-circle me-2"></i>S'inscrire</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <a href="login.php" class="text-decoration-none">Déjà un compte ? <strong>Se connecter</strong></a>
                </div>
            </article>
        </section>
    </main>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>