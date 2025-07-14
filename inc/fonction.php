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
function liste_categories() {
    $conn = dbconnect();
    $sql = "SELECT * from v_cat";
    $result = mysqli_query($conn, $sql);

    return $result;
}

function liste_objets_filtre($id_categorie = null) {
    $conn = dbconnect();

}


function liste_objets_avec_dates_condition()
{
    
    $sql_cat = "SELECT * FROM v_cat";
    $res_cat = mysqli_query(dbconnect(), $sql_cat);

    $sql_emp = "SELECT id_objet, date_emprunt, date_retour FROM v_emprunt";
    $res_emp = mysqli_query(dbconnect(), $sql_emp);

    $emprunts = [];
    while ($row = mysqli_fetch_assoc($res_emp)) {
        $emprunts[$row['id_objet']] = [
            'date_emprunt' => $row['date_emprunt'],
            'date_retour' => $row['date_retour']
        ];
    }
    $resultat_final = [];
    while ($row = mysqli_fetch_assoc($res_cat)) {
        $id = $row['id_objet'];

        
        if (isset($emprunts[$id])) {
            $row['date_emprunt'] = $emprunts[$id]['date_emprunt'];
            $row['date_retour'] = $emprunts[$id]['date_retour'];
        } else {
            $row['date_emprunt'] = null;
            $row['date_retour'] = null;
        }

        $resultat_final[] = $row;
    }

    return $resultat_final; 
}

