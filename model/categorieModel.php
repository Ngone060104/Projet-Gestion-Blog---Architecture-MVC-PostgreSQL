<?php
// model/categorieModel.php

//  Récupère toutes les catégories avec le nombre d'articles associés
function findAllCategoriesWithCount(): array {
    $sql = "SELECT c.*, COUNT(a.id_article) as total_articles 
            FROM categorie_article c 
            LEFT JOIN article a ON a.id_categorie = c.id_categorie 
            GROUP BY c.id_categorie, c.nom 
            ORDER BY c.nom ASC";
    return executeSelect($sql);
}

function findAllCategories(): array {
    $sql = "SELECT * FROM categorie_article ORDER BY nom ASC";
    return executeSelect($sql);
}

// Vérifie si une catégorie existe déjà (Anti-doublon)

function isCategorieExists(string $nom): bool {
    $sql = "SELECT COUNT(*) as total FROM categorie_article WHERE LOWER(TRIM(nom)) = ?";
    $result = executeSelect($sql, [strtolower(trim($nom))], true);
    return ($result['total'] ?? 0) > 0;
}

//  Insère une nouvelle catégorie en base de données

function saveCategorie(string $nom, string $description): bool {
    $sql = "INSERT INTO categorie_article (nom, description) VALUES (?, ?)";
    return executeUpdate($sql, [trim($nom), trim($description)]);
}
