<?php
include '../inc/fonction.php';
ini_set('display_errors', 1);
session_start();
$result = liste_categories();
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
    <h1 class="text-center mb-4">Liste des objets avec catégories</h1>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nom catégorie</th>
                <th>Nom objet</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['nom_categorie']) . '</td>';
                echo '<td>' . htmlspecialchars($row['nom_objet']) . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
