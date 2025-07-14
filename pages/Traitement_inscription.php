<?php
include '../inc/fonction.php';
ini_set('display_errors', 1);
session_start();

$nom = $_POST['nom'];
echo $nom;
$email = $_POST['email'];
$mdp = $_POST['mdp'];
$genre =  $_POST['genre'];
$ville = $_POST['ville'];
$image  = $_POST['fichier'];
$date_naissance = $_POST['date'];

$result = inscription($nom, $date_naissance, $genre, $email, $ville, $mdp, $image);
$_SESSION['email'] = $result;
echo $_SESSION['email'];
header('location:login.php');
