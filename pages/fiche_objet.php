<?php
session_start();
require '../inc/fonction.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // ou une page de connexion
    exit;
}

$id = $_SESSION['id'];

$membre = get_membre_by_id($id);
$objets = get_objets_par_membre_regroupes($id);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Détails - <?= htmlspecialchars($objet['nom_objet']) ?></title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><?= htmlspecialchars($objet['nom_objet']) ?></h1>
        <a href="liste_objet.php" class="btn btn-outline-secondary">← Retour</a>
    </div>

    <p class="text-muted fst-italic">Catégorie : <?= htmlspecialchars($objet['nom_categorie']) ?></p>

    <?php if (!empty($images)): ?>
    <div id="carouselImages" class="carousel slide mb-5" data-bs-ride="carousel" style="max-width: 600px;">
        <div class="carousel-inner rounded shadow-sm">
            <?php foreach ($images as $index => $img): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <img src="../image/<?= htmlspecialchars($img) ?>" class="d-block w-100" alt="Image <?= $index + 1 ?>">
            </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    </div>
    <?php else: ?>
        <p class="text-muted">Aucune image disponible.</p>
    <?php endif; ?>

    <h4 class="mb-3">Historique des emprunts</h4>
    <?php if (!empty($emprunts)): ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Date emprunt</th>
                    <th>Date retour</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emprunts as $emp): ?>
                <tr>
                    <td><?= htmlspecialchars($emp['date_emprunt']) ?></td>
                    <td><?= $emp['date_retour'] ?? '-' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p class="text-muted">Aucun emprunt enregistré.</p>
    <?php endif; ?>

</div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
