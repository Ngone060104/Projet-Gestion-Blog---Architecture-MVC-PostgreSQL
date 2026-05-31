<?php
// model/articleModel.php

// Récupère tous les articles du blog
//   Si un id_auteur est fourni, récupère uniquement SES articles (pour Astou Diop)
 
function findAllArticles(int $id_auteur = 0,int $id_categorie = 0): array {
    $sql = "SELECT a.*, c.nom as categorie_nom, u.prenom, u.nom 
            FROM article a
            JOIN categorie_article c ON a.id_categorie = c.id_categorie
            JOIN utilisateur u ON a.id_user = u.id_user WHERE 1=1";
    $params = [];

    if ($id_auteur > 0) {
        $sql .= " AND a.id_user = ?";
        $params[] = $id_auteur;
    }
     // Filtre 2 : NOUVEAU - Si une catégorie spécifique est sélectionnée
    if ($id_categorie > 0) {
        $sql .= " AND a.id_categorie = ?";
        $params[] = $id_categorie;
    }

    $sql .= " ORDER BY a.date_pub DESC";
    return executeSelect($sql, $params);
}

//  Insère un nouvel article en base de données

function saveArticle(string $titre, string $contenu, string $description, string $slug, string $statut, int $id_user, int $id_categorie, string $image): bool {
    $sql = "INSERT INTO article (titre, contenu, description, slug, statut, id_user, id_categorie, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            
    return executeUpdate($sql, [
        trim($titre),
        trim($contenu),
        trim($description),
        trim($slug),
        trim($statut),
        $id_user,
        $id_categorie,
        $image // Enregistre le nom du fichier (ex: article_171665421.jpg)
    ]);
}

/**
 * Récupère toutes les catégories disponibles pour alimenter le formulaire de création
 */
function findAllCategories(): array {
    $sql = "SELECT * FROM categorie_article ORDER BY nom ASC";
    return executeSelect($sql);
}


//   Récupère un article unique grâce à son slug URL

function findArticleBySlug(string $slug): ?array {
    $sql = "SELECT a.*, c.nom as categorie_nom, u.prenom, u.nom 
            FROM article a
            JOIN categorie_article c ON a.id_categorie = c.id_categorie
            JOIN utilisateur u ON a.id_user = u.id_user 
            WHERE a.slug = ?";
    $result = executeSelect($sql, [trim($slug)], true);
    return $result ? $result : null;
}

// Récupère tous les commentaires liés à un article spécifique

function findCommentsByArticleId(int $id_article): array {
    $sql = "SELECT c.*, u.prenom, u.nom, u.email 
            FROM commentaire c
            JOIN utilisateur u ON c.id_user = u.id_user
            WHERE c.id_article = ?
            ORDER BY c.date DESC";
    return executeSelect($sql, [$id_article]);
}
