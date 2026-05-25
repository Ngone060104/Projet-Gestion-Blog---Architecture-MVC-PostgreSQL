Créer la base de données gestion_blog 

CREATE DATABASE gestion_blog;

-- Nettoyage complet pour repartir à neuf
DROP TABLE IF EXISTS signalement CASCADE;
DROP TABLE IF EXISTS commentaire CASCADE;
DROP TABLE IF EXISTS article CASCADE;
DROP TABLE IF EXISTS categorie_article CASCADE;
DROP TABLE IF EXISTS utilisateur CASCADE;
DROP TYPE IF EXISTS statut_article_enum CASCADE;
DROP TYPE IF EXISTS role_enum CASCADE;
DROP TYPE IF EXISTS statut_lecteur_enum CASCADE;

-- ===============================================================
-- REQUÊTE 1 : LES ENUMS (Choix fixes en base de données)
-- ===============================================================
CREATE TYPE statut_article_enum AS ENUM ('PUBLIEE', 'ARCHIVEE', 'BROUILLON');
CREATE TYPE role_enum AS ENUM ('admin', 'auteur', 'lecteur');
CREATE TYPE statut_lecteur_enum AS ENUM ('estBanni', 'actif');

-- ===============================================================
-- REQUÊTE 2 : TABLE utilisateur (Votre table unique centrale)
-- ===============================================================
CREATE TABLE utilisateur (
    id_user SERIAL PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role role_enum DEFAULT 'lecteur',
    statut_lecteur statut_lecteur_enum DEFAULT 'actif'
);
-- EXPLICATION : Elle remplace vos 3 tables de départ. Elle contient 
-- le rôle pour savoir ce que l'utilisateur a le droit de faire en PHP.

-- ===============================================================
-- REQUÊTE 3 : TABLE categorie_article
-- ===============================================================
CREATE TABLE categorie_article (
    id_categorie SERIAL PRIMARY KEY,
    nom VARCHAR(100) UNIQUE NOT NULL,
    description TEXT
);

-- EXPLICATION : Permet de classer vos articles (ex: Tech, Mode, Cuisine).

-- ===============================================================
-- REQUÊTE 4 : TABLE article (Liée à l'utilisateur et à la catégorie)
-- ===============================================================
CREATE TABLE article (
    id_article SERIAL PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    contenu TEXT NOT NULL,
    date_pub TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    description TEXT,
    slug VARCHAR(255) UNIQUE NOT NULL,
    statut statut_article_enum DEFAULT 'BROUILLON',
    id_user INT NOT NULL REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    id_categorie INT NOT NULL REFERENCES categorie_article(id_categorie) ON DELETE CASCADE
);

-- EXPLICATION : 'id_user' représente l'auteur qui a écrit l'article.
-- 'ON DELETE CASCADE' supprime l'article si l'utilisateur ou la catégorie est supprimé.

-- ===============================================================
-- REQUÊTE 5 : TABLE commentaire (Liée à l'article et à l'auteur du texte)
-- ===============================================================
CREATE TABLE commentaire (
    id_comment SERIAL PRIMARY KEY,
    contenu TEXT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_article INT NOT NULL REFERENCES article(id_article) ON DELETE CASCADE,
    id_user INT NOT NULL REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    id_parent_commentaire INT REFERENCES commentaire(id_comment) ON DELETE CASCADE
);

-- EXPLICATION : Relie le commentaire à l'article visé et à l'utilisateur connecté.
-- 'id_parent_commentaire' permet de créer un système de réponses imbriquées.

-- ===============================================================
-- REQUÊTE 6 : TABLE signalement (Pour la modération de l'admin)
-- ===============================================================
CREATE TABLE signalement (
    id_signal SERIAL PRIMARY KEY,
    motif VARCHAR(255) NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(50) DEFAULT 'En attente',
    id_user INT NOT NULL REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    id_comment INT NOT NULL REFERENCES commentaire(id_comment) ON DELETE CASCADE,
    id_article INT NOT NULL REFERENCES article(id_article) ON DELETE CASCADE
);
-- EXPLICATION : Enregistre quel utilisateur signale quel commentaire sous quel article.

-- ===============================================================
-- REQUÊTE 7 : JEU DE DONNÉES POUR VOS TESTS PHP
-- ===============================================================
INSERT INTO utilisateur (nom, prenom, email, password, role, statut_lecteur) VALUES
('Diop', 'Moussa', 'admin@blog.com', 'password', 'admin', 'actif'),
('Ndiaye', 'Awa', 'auteur@blog.com', 'password', 'auteur', 'actif'),
('Sow', 'Saliou', 'lecteur@blog.com', 'password', 'lecteur', 'actif');

INSERT INTO categorie_article (nom, description) VALUES
('Technologie', 'Articles liés au développement web et bases de données.');

INSERT INTO article (titre, contenu, description, slug, statut, id_user, id_categorie) VALUES
('Découverte de PostgreSQL', 'PostgreSQL est un système puissant...', 'Guide d initiation', 'decouverte-postgres', 'PUBLIEE', 2, 1);

INSERT INTO commentaire (contenu, id_article, id_user, id_parent_commentaire) VALUES
('Super article !', 1, 3, NULL);
