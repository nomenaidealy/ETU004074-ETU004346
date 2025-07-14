<?php
session_start();
require('../inc/fonction.php');

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$id_membre = $_SESSION['id'];
$emprunts = get_emprunts_par_membre($id_membre);

?>
<!-- Ensuite ton HTML comme avant -->


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes emprunts</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

<h2>Mes emprunts en cours</h2>

<?php if (!empty($emprunts)): ?>
    <ul class="list-group mb-4">
        <?php foreach ($emprunts as $emprunt): ?>
            <li class="list-group-item">
                <br>
                <small>Emprunté le : <?= htmlspecialchars($emprunt['date_emprunt']) ?>, à rendre avant : <?= htmlspecialchars($emprunt['date_retour']) ?></small>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Tu n'as aucun emprunt en cours.</p>
<?php endif; ?>

<a href="accueil.php" class="btn btn-secondary mt-3">← Retour</a>

</body>
</html>
