<?php
require("../inc/fonction.php");
session_start();
ini_set("display_errors", 1);
$email = $_SESSION['email'];

$uploadDir = __DIR__ . '/uploads/';

if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0777, true)) {
        die('Impossible de créer le dossier uploads. Vérifiez les permissions.');
    }
}

$maxSize = 500 * 1024 * 1024;
$allowedMimeTypes = ['video/mp4', 'image/jpeg', 'application/pdf'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fichier'])) {
    $file = $_FILES['fichier'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        die('Erreur lors de l\'upload : ' . $file['error']);
    }

    if ($file['size'] > $maxSize) {
        die('Le fichier est trop volumineux.');
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, $allowedMimeTypes)) {
        die('Type de fichier non autorisé : ' . $mime);
    }

    $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = $originalName . '_' . uniqid() . '.' . $extension;
    echo $newName;
    if (move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
        echo "Fichier uploadé avec succès : " . $newName;
        ajouter_profil($newName, $email);
        header('Location: accueil.php');
        exit();
    } else {
        echo "Échec du déplacement du fichier.";
    }
}
