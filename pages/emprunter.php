<?php
session_start();
require_once '../inc/fonction.php';

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

$id_objet = $_GET['id_objet'] ?? null;
if (!$id_objet) {
    die("Objet non spécifié.");
}


$email = $_SESSION['email'];
$membre = select_membre_by_email($email); 
if (!$membre) {
    die("Membre non trouvé.");
}
$id_membre = $membre['id_membre'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nb_jours = intval($_POST['nb_jours'] ?? 0);

    if ($nb_jours <= 0) {
        $erreur = "Veuillez entrer un nombre de jours valide.";
    } else {
        if (enregistrer_emprunt($id_objet, $id_membre, $nb_jours)) {
            header('Location: liste_objet.php?msg=Objet emprunté');
            exit;
        } else {
            $erreur = "Erreur lors de l'enregistrement.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Emprunter un objet</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Emprunter un objet</h2>

    <?php if (!empty($erreur)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="nb_jours" class="form-label">Durée d'emprunt (en jours) :</label>
            <input type="number" class="form-control" name="nb_jours" id="nb_jours" min="1" required>
        </div>
        <button type="submit" class="btn btn-success">Valider l'emprunt</button>
        <a href="liste_objets.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>
