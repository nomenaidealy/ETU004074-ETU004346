<?php
include '../inc/fonction.php';
ini_set('display_errors', 1);
session_start();

// Remplace ici :
$donnees = liste_objets_avec_dates_condition();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Objets avec catégories et emprunts</title>
    
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container my-5">
    <h1 class="text-center mb-4">Liste des objets avec catégories et emprunts</h1>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nom catégorie</th>
                <th>Nom objet</th>
                <th>Date emprunt</th>
                <th>Date retour</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($donnees as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nom_categorie']) ?></td>
                    <td><?= htmlspecialchars($row['nom_objet']) ?></td>
                    <td><?= $row['date_emprunt'] ?? '-' ?></td>
                    <td><?= $row['date_retour'] ?? '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
