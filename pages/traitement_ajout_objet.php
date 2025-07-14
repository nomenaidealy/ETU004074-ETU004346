<?php
session_start();
require_once '../inc/fonction.php';

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit;
}
echo $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_objet = $_POST['nom_objet'] ?? '';
    $categorie = $_POST['categorie'] ?? '';
    $email = $_SESSION['email'];

    if (empty($nom_objet) || empty($categorie)) {
        die('Nom de l\'objet et catégorie sont requis.');
    }


    $membre = select_membre_by_email($email);
    if (!$membre) {
        die('Membre introuvable.');
    }
    
    $id_membre = $membre['id_membre']; 
 echo $id_membre;

    if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
        die('Veuillez sélectionner au moins une image.');
    }


    $id_objet = ajouter_objet_avec_images($id_membre, $nom_objet, $categorie, $_FILES['images']);

    if ($id_objet) {
        header('Location: liste_objet.php?msg=Objet ajouté avec succès');
        exit;
    } else {
        die('Erreur lors de l\'ajout de l\'objet.');
    }
}
?>
