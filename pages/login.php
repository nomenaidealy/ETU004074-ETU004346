<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion </title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">
    <main class="container min-vh-100 d-flex align-items-center justify-content-center">
        <section class="col-md-6 col-lg-4">
            <article class="card shadow border-0">
                <div class="card-header bg-success text-white text-center py-4">
                    <i class="bi bi-person-check fs-1 mb-2"></i>
                    <h1 class="h4 mb-0">Connexion </h1>
                </div>
                <div class="card-body p-4">
                    <form action="Traitement_login.php" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label"><i class="bi bi-envelope me-2"></i>Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="votre@email.com" required>
                        </div>
                        <div class="mb-4">
                            <label for="mdp" class="form-label"><i class="bi bi-lock me-2"></i>Mot de passe</label>
                            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-box-arrow-in-right me-2"></i>Se connecter</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <a href="inscription.php" class="text-decoration-none">Pas encore de compte ? <strong>S'inscrire</strong></a>
                </div>
            </article>
        </section>
    </main>
</body>

</html>