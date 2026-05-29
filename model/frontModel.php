<?php
///  Récupère toutes les catégories pour alimenter la Navbar

function getNavbarCategories(): array {
    $sql = "SELECT * FROM categorie_article ORDER BY nom ASC";
    return executeSelect($sql);
}

//   Récupère les articles à la une (Actualités du jour - max 8)

function getActualitesDuJour(int $id_categorie = 0): array {
    $sql = "SELECT a.*, c.nom as categorie_nom, u.prenom, u.nom 
            FROM article a
            JOIN categorie_article c ON a.id_categorie = c.id_categorie
            JOIN utilisateur u ON a.id_user = u.id_user
            WHERE a.statut = 'PUBLIEE'";
    $params = [];

    if ($id_categorie > 0) {
        $sql .= " AND a.id_categorie = ?";
        $params[] = $id_categorie;
    }

    $sql .= " ORDER BY a.date_pub DESC LIMIT 8";
    return executeSelect($sql, $params);
}


//   Récupère les derniers articles (Section du bas - max 4)
 
function getDerniersArticles(): array {
    $sql = "SELECT a.*, c.nom as categorie_nom, u.prenom, u.nom 
            FROM article a
            JOIN categorie_article c ON a.id_categorie = c.id_categorie
            JOIN utilisateur u ON a.id_user = u.id_user
            WHERE a.statut = 'PUBLIEE'
            ORDER BY a.date_pub DESC LIMIT 4";
    return executeSelect($sql);
}

/**
 * Insère un nouveau commentaire lié à un article et à un lecteur
 */
function saveCommentairePublic(string $contenu, int $id_article, int $id_user): bool {
    $sql = "INSERT INTO commentaire (contenu, id_article, id_user, date) 
            VALUES (?, ?, ?, CURRENT_TIMESTAMP)";
    return executeUpdate($sql, [trim($contenu), $id_article, $id_user]);
}
