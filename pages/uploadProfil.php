<?php
include_once '../inc/fonction.php';
ini_set('display_errors', 1);
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}

$email = $_SESSION['email'];
?>

<div class="container mt-4">
    <h2>Changer la photo de profil</h2>

    <form action="upload.php" method="post" enctype="multipart/form-data" class="mt-3">
        <div class="mb-3">
            <label for="fichier" class="form-label">Choisissez une image :</label>
            <input type="file" name="fichier" id="fichier" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Uploader</button>
    </form>

</div>