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
function liste_objets_avec_dates_condition($categorie_id = null, $nom = null, $disponible = false)
{
    $conn = dbconnect();

    $sql_cat = "SELECT * FROM v_cat WHERE 1=1";
    if ($categorie_id) {
        $sql_cat .= " AND id_categorie = " . intval($categorie_id);
    }
    if ($nom) {
        $nom = mysqli_real_escape_string($conn, $nom);
        $sql_cat .= " AND nom_objet LIKE '%$nom%'";
    }
    $res_cat = mysqli_query($conn, $sql_cat);

    
    $sql_emp = "SELECT id_objet, date_emprunt, date_retour FROM v_emprunt";
    $res_emp = mysqli_query($conn, $sql_emp);

    $emprunts = [];
    while ($row = mysqli_fetch_assoc($res_emp)) {
        
        $id = $row['id_objet'];
        if (!isset($emprunts[$id]) || $row['date_emprunt'] > $emprunts[$id]['date_emprunt']) {
            $emprunts[$id] = [
                'date_emprunt' => $row['date_emprunt'],
                'date_retour'  => $row['date_retour']
            ];
        }
    }

    $resultat_final = [];
    while ($row = mysqli_fetch_assoc($res_cat)) {
        $id = $row['id_objet'];
        $est_emprunte = isset($emprunts[$id]) && $emprunts[$id]['date_retour'] === null;

        $row['date_emprunt'] = $emprunts[$id]['date_emprunt'] ?? null;
        $row['date_retour'] = $emprunts[$id]['date_retour'] ?? null;

        if ($disponible && $est_emprunte) {
            continue;
        }
        $resultat_final[] = $row;
    }
    return $resultat_final;
}


function get_categories()
{
    return dbconnect() ->query("SELECT * FROM categorie_objet");
}



function ajouter_objet_avec_images($id_membre, $nom_objet, $id_categorie, $images)
{
    $conn = dbconnect();

    $nom_objet = mysqli_real_escape_string($conn, $nom_objet);
    $id_categorie = intval($id_categorie);
    $id_membre = intval($id_membre);

    
    $sql_objet = "INSERT INTO objet (nom_objet, id_categorie, id_membre) VALUES ('$nom_objet', $id_categorie, $id_membre)";
    if (!mysqli_query($conn, $sql_objet)) {
        return false;
    }
    $id_objet = mysqli_insert_id($conn);

    $upload_dir = __DIR__ . '/../image/';


    if (!empty($images) && isset($images['name']) && is_array($images['name'])) {
        for ($i = 0; $i < count($images['name']); $i++) {
            if ($images['error'][$i] === UPLOAD_ERR_OK) {
                $tmp_name = $images['tmp_name'][$i];
                $name = basename($images['name'][$i]);
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $new_name = uniqid('obj_') . '.' . $ext;

                if (move_uploaded_file($tmp_name, $upload_dir . $new_name)) {
                    // Enregistrer dans la table images_objet
                    $sql_img = "INSERT INTO images_objet (id_objet, nom_image) VALUES ($id_objet, '$new_name')";
                    mysqli_query($conn, $sql_img);
                }
            }
        }
    }

    return $id_objet;
}


function supprimer_image_objet($id_image)
{
    $conn = dbconnect();


    $sql = "SELECT nom_image FROM images_objet WHERE id_image = " . intval($id_image);
    $res = mysqli_query($conn, $sql);
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $nom_image = $row['nom_image'];
        $chemin = __DIR__ . '/../image/' . $nom_image;

        
        $sql_del = "DELETE FROM images_objet WHERE id_image = " . intval($id_image);
        mysqli_query($conn, $sql_del);

    
        if (file_exists($chemin)) {
            unlink($chemin);
        }

        return true;
    }
    return false;
}


function get_image_principale($id_objet)
{
    $conn = dbconnect();

    $sql = "SELECT nom_image FROM images_objet WHERE id_objet = " . intval($id_objet) . " ORDER BY id_image ASC LIMIT 1";
    $res = mysqli_query($conn, $sql);
    if ($res && $row = mysqli_fetch_assoc($res)) {
        $image = $row['nom_image'];
        $chemin = __DIR__ . '/../image/' . $image;
        if (file_exists($chemin)) {
            return "../image/" . $image;
        }
    }
    // image par défaut
    return "../image/objet.jpeg";
}

function select_membre_by_email($email)
{
    $conn = dbconnect();
    $email = mysqli_real_escape_string($conn, $email);

    $sql = "SELECT * FROM membre WHERE email = '$email'";
    $resultat = mysqli_query($conn, $sql);

    if ($resultat && mysqli_num_rows($resultat) > 0) {
        $donnee = mysqli_fetch_assoc($resultat);
        $_SESSION['id'] = $donnee["id_membre"];
        return $donnee;
    }
    return false;
}



function get_objet_by_id($id_objet) {
    $conn = dbconnect();
    $sql = "SELECT o.*, c.nom_categorie 
            FROM objet o 
            JOIN categorie_objet c ON o.id_categorie = c.id_categorie 
            WHERE o.id_objet = " . intval($id_objet);
    $res = mysqli_query($conn, $sql);
    if ($res && mysqli_num_rows($res) > 0) {
        return mysqli_fetch_assoc($res);
    }
    return null;
}

function get_images_by_objet($id_objet) {
    $conn = dbconnect();
    $sql = "SELECT nom_image FROM images_objet WHERE id_objet = " . intval($id_objet);
    $res = mysqli_query($conn, $sql);
    $images = [];
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $images[] = $row['nom_image'];
        }
    }
    return $images;
}

function get_emprunts_by_objet($id_objet) {
    $conn = dbconnect();
    $sql = "SELECT date_emprunt, date_retour FROM emprunt WHERE id_objet = " . intval($id_objet) . " ORDER BY date_emprunt DESC";
    $res = mysqli_query($conn, $sql);
    $emprunts = [];
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $emprunts[] = $row;
        }
    }
    return $emprunts;
}


function get_objets_par_membre_regroupes($id_membre) {
    $id = intval($id_membre);
    $conn = dbconnect();
    $sql = "SELECT c.nom_categorie, o.nom_objet
            FROM objet o
            JOIN categorie_objet c ON o.id_categorie = c.id_categorie
            WHERE o.id_membre = $id
            ORDER BY c.nom_categorie, o.nom_objet";
    $res = mysqli_query($conn, $sql);
    
    $groupes = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $cat = $row['nom_categorie'];
        $groupes[$cat][] = $row['nom_objet'];
    }
    return $groupes;
}
function get_membre_by_id($id) {
    $id = intval($id);
    $conn = dbconnect();
    $sql = "SELECT * FROM membre WHERE id_membre = $id";
    $res = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($res);
}



function get_emprunts_en_cours_par_membre($id_membre) {
    $conn = dbconnect();
    $id_membre = intval($id_membre);
    // On récupère les emprunts dont la date_retour_effectif est NULL (non retourné)
    $sql = "select * from emprunt where id_membre = $id_membre";

    $res = mysqli_query($conn, $sql);
    $emprunts = [];
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $emprunts[] = $row;
        }
    }
    return $emprunts;
}


function retourner_emprunt($id_emprunt, $etat) {
    $conn = dbconnect();
    $id_emprunt = intval($id_emprunt);
    $etat = ($etat === 'abime') ? 1 : 0;
    $date_retour_effectif = date('Y-m-d');

    $sql = "UPDATE emprunt SET date_retour= '$date_retour_effectif', etat_objet = $etat WHERE id_emprunt = $id_emprunt";
    return mysqli_query($conn, $sql);
}

function enregistrer_emprunt($id_objet, $id_membre, $nb_jours) {
    $conn = dbconnect();

    $id_objet = intval($id_objet);
    $id_membre = intval($id_membre);
    $nb_jours = intval($nb_jours);

    if ($nb_jours <= 0) return false;

    $date_emprunt = date('Y-m-d');
    $date_retour = date('Y-m-d', strtotime("+$nb_jours days"));

    
    $sql = "INSERT INTO emprunt (id_objet, id_membre, date_emprunt, date_retour)
            VALUES ($id_objet, $id_membre, '$date_emprunt', '$date_retour')";

    return mysqli_query($conn, $sql);
}

