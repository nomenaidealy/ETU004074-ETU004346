<?php
include '../inc/fonction.php';
ini_set('display_errors', 1);
session_start();

$id_objet = $_GET['id_objet'] ?? null;
if (!$id_objet) {
    die("ID objet manquant.");
}

$objet = get_objet_by_id($id_objet);
if (!$objet) {
    die("Objet introuvable.");
}

$images = get_images_by_objet($id_objet);
$emprunts = get_emprunts_by_objet($id_objet);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Détails - <?= htmlspecialchars($objet['nom_objet']) ?></title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">

    <h1 class="mb-4"><?= htmlspecialchars($objet['nom_objet']) ?></h1>
    <p><strong>Catégorie :</strong> <?= htmlspecialchars($objet['nom_categorie']) ?></p>

    <?php if (!empty($images)): ?>
    <div id="carouselImages" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
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
        <p>Aucune image disponible.</p>
    <?php endif; ?>

    <h3>Historique des emprunts</h3>
    <?php if (!empty($emprunts)): ?>
    <table class="table table-bordered">
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
    <?php else: ?>
        <p>Aucun emprunt enregistré.</p>
    <?php endif; ?>

    <a href="liste_objet.php" class="btn btn-secondary mt-4">← Retour à la liste</a>
</div>


</body>
</html>