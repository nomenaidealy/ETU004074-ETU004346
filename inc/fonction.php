<?php
require("connection.php");

function inscription($nom, $date_naissance, $genre, $email, $ville, $mdp, $image_profil)
{
    $sql = "INSERT INTO membre(nom, date_naissance,genre, email, ville, mdp, image)
            VALUES('$nom', '$date_naissance','$genre', '$email', '$ville', '$mdp', '$image_profil')";
    mysqli_query(dbconnect(), $sql);
    return $email;
}

function login($email, $mot_de_passe)
{
    $sql = "SELECT * FROM membre WHERE email='$email' AND mdp='$mot_de_passe'";
    $res = mysqli_query(dbconnect(), $sql);
    return $res;
}
