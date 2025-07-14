<?php
include '../inc/fonction.php';
ini_set('display_errors', 1);
session_start();

$categorie_id = $_GET['categorie'] ?? null;
$nom = $_GET['nom'] ?? null;
$disponible = isset($_GET['disponible']);

$categories = get_categories();
$donnees = liste_objets_avec_dates_condition($categorie_id, $nom, $disponible);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Objets avec images</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <style>
        .card-img-top {
            height: 180px;
            object-fit: cover;
        }
        .object-card {
            min-height: 100%;
        }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <h1 class="text-center mb-5">📦 Liste des objets</h1>
    <p><a href="ajout_objet.php">Ajouter un objet</a></p>

    
    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <form method="get">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="categorie" class="form-label">Catégorie :</label>
                        <select name="categorie" id="categorie" class="form-select">
                            <option value="">-- Toutes les catégories --</option>
                            <?php while ($cat = $categories->fetch_assoc()): ?>
                                <option value="<?= $cat['id_categorie'] ?>" <?= ($categorie_id == $cat['id_categorie']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['nom_categorie']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="nom" class="form-label">Nom de l'objet :</label>
                        <input type="text" id="nom" name="nom" class="form-control" placeholder="Ex: Marteau" value="<?= htmlspecialchars($nom) ?>">
                    </div>

                    <div class="col-md-3 d-flex align-items-center">
                        <div class="form-check mt-3">
                            <input type="checkbox" id="disponible" name="disponible" class="form-check-input" <?= $disponible ? 'checked' : '' ?>>
                            <label for="disponible" class="form-check-label">Disponible uniquement</label>
                        </div>
                    </div>

                    <div class="col-md-1 d-grid">
                        <button type="submit" class="btn btn-primary mt-md-4">Filtrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row g-4">
        <?php if (!empty($donnees)): ?>
            <?php foreach ($donnees as $objet): 
                $image = $objet['nom_image'] ?? 'objet.jpeg';
                $imagePath = file_exists("../image/" . $image) ? "../image/" . $image : "../image/objet.jpeg";

                $dispo = true;
                if (!empty($objet['date_retour'])) {
                    $today = date('Y-m-d');
                    if ($today < $objet['date_retour']) {
                        $dispo = false;
                    }
                }
            ?>
            <div class="col-md-3">
                <div class="card object-card shadow-sm h-100">
                    <img src="<?= htmlspecialchars($imagePath) ?>" alt="Image de l'objet" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($objet['nom_objet']) ?></h5>
                        <p class="text-muted mb-1"><strong>Catégorie:</strong> <?= htmlspecialchars($objet['nom_categorie']) ?></p>
                        <p class="mb-1"><strong>État:</strong> 
                            <?php if ($dispo): ?>
                                <span class="text-success">Disponible</span>
                            <?php else: ?>
                                <span class="text-danger">Disponible le <?= date('d/m', strtotime($objet['date_retour'])) ?></span>
                            <?php endif; ?>
                        </p>

                        <p class="mb-1"><strong>Emprunt:</strong> <?= $objet['date_emprunt'] ?? '-' ?></p>
                        <p><strong>Retour:</strong> <?= $objet['date_retour'] ?? '-' ?></p>
                        <a href="fiche_objet.php?id_objet=<?= $objet['id_objet'] ?>" class="btn btn-sm btn-primary mt-auto">Voir plus</a>
                        <?php if ($dispo): ?>
                            <a href="emprunter.php?id_objet=<?= $objet['id_objet'] ?>" class="btn btn-sm btn-success mt-2">Emprunter</a>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">Aucun objet trouvé.</div>
            </div>
        <?php endif; ?>
    </div>

</div>
</body>
</html>
