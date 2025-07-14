<?php
session_start();
require_once '../inc/fonction.php';
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

$categories = get_categories();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Ajouter un objet</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h2>Ajouter un nouvel objet</h2>
    <form action="traitement_ajout_objet.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nom_objet" class="form-label">Nom de l'objet :</label>
            <input type="text" id="nom_objet" name="nom_objet" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="categorie" class="form-label">Catégorie :</label>
            <select id="categorie" name="categorie" class="form-select" required>
                <option value="">-- Sélectionner une catégorie --</option>
                <?php while ($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= $cat['id_categorie'] ?>"><?= htmlspecialchars($cat['nom_categorie']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Images (plusieurs possibles, la première sera l'image principale) :</label>
            <input type="file" id="images" name="images[]" class="form-control" accept="image/*" multiple required>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter l'objet</button>
    </form>
</div>
</body>
</html>
