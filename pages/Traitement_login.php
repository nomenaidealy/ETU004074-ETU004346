<?php
include '../inc/fonction.php';
ini_set('display_errors', 1);
session_start();

$email = $_POST['email'];
$motdepasse = $_POST['mdp'];

$log = login($email, $motdepasse);
$_SESSION['email'] = $email;
echo $_SESSION['email'];
if (mysqli_fetch_assoc($log) == null) {
    header('location:inscription.php');
} else {
    header('location:site.php');
}
