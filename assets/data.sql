CREATE TABLE membre (
    id_membre INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    date_naissance DATE,
    genre CHAR(1),
    email VARCHAR(100) UNIQUE,
    ville VARCHAR(100),
    mdp VARCHAR(100),
    image VARCHAR(255)
);

CREATE TABLE categorie_objet (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie VARCHAR(100)
);

CREATE TABLE objet (
    id_objet INT AUTO_INCREMENT PRIMARY KEY,
    nom_objet VARCHAR(100),
    id_categorie INT,
    id_membre INT,
    FOREIGN KEY (id_categorie) REFERENCES categorie_objet(id_categorie),
    FOREIGN KEY (id_membre) REFERENCES membre(id_membre)
);

CREATE TABLE images_objet (
    id_image INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT,
    nom_image VARCHAR(255),
    FOREIGN KEY (id_objet) REFERENCES objet(id_objet)
);

CREATE TABLE emprunt (
    id_emprunt INT AUTO_INCREMENT PRIMARY KEY,
    id_objet INT,
    id_membre INT,
    date_emprunt DATE,
    date_retour DATE,
    FOREIGN KEY (id_objet) REFERENCES objet(id_objet),
    FOREIGN KEY (id_membre) REFERENCES membre(id_membre)
);





INSERT INTO membre (nom, date_naissance, genre, email, ville, mdp, image) VALUES
('Alice', '1999-05-01', 'F', 'alice@gmail.com', 'Tana', 'alice123', 'alice.jpg'),
('Bob', '1997-08-12', 'M', 'bob@gmail.com', 'Majunga', 'bob123', 'bob.jpg'),
('Claire', '2000-02-20', 'F', 'claire@gmail.com', 'Fianarantsoa', 'claire123', 'claire.jpg'),
('David', '1998-11-03', 'M', 'david@gmail.com', 'Toamasina', 'david123', 'david.jpg');


INSERT INTO categorie_objet (nom_categorie) VALUES
('Esthétique'),
('Bricolage'),
('Mécanique'),
('Cuisine');


INSERT INTO objet (nom_objet, id_categorie, id_membre) VALUES

('Sèche-cheveux', 1, 1),
('Miroir LED', 1, 1),
('Perceuse', 2, 1),
('Tournevis', 2, 1),
('Moteur jouet', 3, 1),
('Pompe à eau', 3, 1),
('Blender', 4, 1),
('Casserole', 4, 1),
('Vernis', 1, 1),
('Grille-pain', 4, 1),


('Tronçonneuse', 2, 2),
('Visseuse', 2, 2),
('Pneu', 3, 2),
('Amortisseur', 3, 2),
('Four', 4, 2),
('Mixer', 4, 2),
('Rasoir électrique', 1, 2),
('Brosse à dents électrique', 1, 2),
('Poêle', 4, 2),
('Tournevis électrique', 2, 2),


('Lisseur cheveux', 1, 3),
('Kit manucure', 1, 3),
('Scie sauteuse', 2, 3),
('Clé à molette', 2, 3),
('Carburateur', 3, 3),
('Filtre à huile', 3, 3),
('Friteuse', 4, 3),
('Micro-ondes', 4, 3),
('Mascara', 1, 3),
('Râpe légumes', 4, 3),


('Gel coiffant', 1, 4),
('Crème hydratante', 1, 4),
('Pince multiprise', 2, 4),
('Marteau', 2, 4),
('Alternateur', 3, 4),
('Batterie auto', 3, 4),
('Cuiseur vapeur', 4, 4),
('Mijoteuse', 4, 4),
('Rouge à lèvres', 1, 4),
('Moule à gâteau', 4, 4);


INSERT INTO images_objet (id_objet, nom_image) VALUES
(1, 'seche_cheveux.jpg'),
(2, 'miroir_led.jpg'),
(3, 'perceuse.jpg'),
(4, 'tournevis.jpg'),
(11, 'tronconneuse.jpg'),
(21, 'lisseur.jpg'),
(31, 'gel_coiffant.jpg'),
(12, 'visseuse.jpg'),
(22, 'kit_manucure.jpg'),
(40, 'moule_gateau.jpg');


INSERT INTO emprunt (id_objet, id_membre, date_emprunt, date_retour) VALUES
(1, 2, '2025-07-01', '2025-07-10'),
(5, 3, '2025-07-02', '2025-07-12'),
(12, 1, '2025-07-03', '2025-07-08'),
(20, 4, '2025-07-04', '2025-07-14'),
(25, 2, '2025-07-05', '2025-07-11'),
(30, 3, '2025-07-06', '2025-07-16'),
(35, 1, '2025-07-07', '2025-07-15'),
(40, 4, '2025-07-08', '2025-07-18'),
(3, 2, '2025-07-09', '2025-07-19'),
(15, 1, '2025-07-10', '2025-07-20');

CREATE OR REPLACE VIEW v_cat AS 
SELECT c.nom_categorie, o.nom_objet, o.id_objet,o.id_categorie,     
(SELECT nom_image          
FROM images_objet i          
WHERE i.id_objet = o.id_objet          
ORDER BY i.id_image          
LIMIT 1 ) AS nom_image 
FROM objet o JOIN categorie_objet c 
ON c.id_categorie = o.id_categorie;


create or replace view v_emprunt as  
select o.nom_objet, o.id_objet,e.date_emprunt, e.date_retour  
from objet o 
join emprunt e 
on o.id_objet = e.id_objet ;