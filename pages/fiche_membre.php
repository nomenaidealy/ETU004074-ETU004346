<?php
require('../inc/fonction.php');
$id = $_GET['id'] ?? null;
if (!$id) die("ID manquant");

$membre = get_membre_by_id($id);
$objets = get_objets_par_membre_regroupes($id);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche du membre</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">

<h2 class="mb-4">👤 Fiche du membre</h2>

<?php if ($membre): ?>
    <ul class="list-group mb-4">
        <li class="list-group-item"><strong>Nom :</strong> <?= htmlspecialchars($membre['nom']) ?></li>
        <li class="list-group-item"><strong>Email :</strong> <?= htmlspecialchars($membre['email']) ?></li>
        <li class="list-group-item"><strong>Ville :</strong> <?= htmlspecialchars($membre['ville']) ?></li>
    </ul>

    <h3 class="mb-3">📦 Objets par catégorie :</h3>
    <?php if (!empty($objets)): ?>
        <?php foreach ($objets as $categorie => $liste): ?>
            <h5 class="mt-3"><?= htmlspecialchars($categorie) ?></h5>
            <ul class="list-group">
                <?php foreach ($liste as $objet): ?>
                    <li class="list-group-item"><?= htmlspecialchars($objet) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">Aucun objet trouvé pour ce membre.</p>
    <?php endif; ?>

<?php else: ?>
    <div class="alert alert-danger">Membre introuvable.</div>
<?php endif; ?>

<a href="liste_membres.php" class="btn btn-secondary mt-4">← Retour à la liste des membres</a>

</body>
</html>