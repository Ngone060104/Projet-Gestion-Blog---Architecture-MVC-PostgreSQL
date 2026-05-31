<?php
// model/dashboardModel.php

// =========================================================================
// SECTION 1 : LES REQUÊTES GLOBALES (POUR L'ADMINISTRATEUR)
// =========================================================================

//  Compte le nombre total d'auteurs inscrits sur le blog
 
function countAllAuteurs(): int {
    $sql = "SELECT COUNT(*) as total FROM utilisateur WHERE role = 'auteur'";
    $result = executeSelect($sql, [], true);
    return (int)($result['total'] ?? 0);
}

//  Compte le nombre total de lecteurs inscrits sur le blog
function countAllLecteurs(): int {
    $sql = "SELECT COUNT(*) as total FROM utilisateur WHERE role = 'lecteur'";
    $result = executeSelect($sql, [], true);
    return (int)($result['total'] ?? 0);
}

// Compte le nombre total de commentaires rédigés sur l'ensemble du blog
function countAllComments(): int {
    $sql = "SELECT COUNT(*) as total FROM commentaire";
    $result = executeSelect($sql, [], true);
    return (int)($result['total'] ?? 0);
}

// Compte le nombre total d'articles publiés ou en brouillon sur le blog

function countAllArticles(): int {
    $sql = "SELECT COUNT(*) as total FROM article";
    $result = executeSelect($sql, [], true);
    return (int)($result['total'] ?? 0);
}



// =========================================================================
// SECTION 2 : LES REQUÊTES DE FILTRAGE PERSONNEL (POUR L'AUTEUR)
// =========================================================================

/**
 * Compte le nombre d'articles rédigés par un auteur spécifique
 */
function countAuteurArticles(int $id_auteur): int {
    $sql = "SELECT COUNT(*) as total FROM article WHERE id_user = ?";
    $result = executeSelect($sql, [$id_auteur], true);
    return (int)($result['total'] ?? 0);
}

/**
 * Compte le nombre total de commentaires reçus uniquement sur les articles d'un auteur donné
 */
function countAuteurCommentsReceived(int $id_auteur): int {
    $sql = "SELECT COUNT(c.id_comment) as total 
            FROM commentaire c 
            JOIN article a ON c.id_article = a.id_article
            WHERE a.id_user = ?";
    $result = executeSelect($sql, [$id_auteur], true);
    return (int)($result['total'] ?? 0);
}

/**
 * Compte le nombre de lecteurs distincts (uniques) ayant laissé un commentaire sur les articles de cet auteur
 */
function countAuteurLecteurs(int $id_auteur): int {
    $sql = "SELECT COUNT(DISTINCT c.id_user) as total 
            FROM commentaire c 
            JOIN article a ON c.id_article = a.id_article
            WHERE a.id_user = ?";
    $result = executeSelect($sql, [$id_auteur], true);
    return (int)($result['total'] ?? 0);
}

/**
 * Compte le nombre d'articles publiés pour un jour spécifique de la semaine en cours
 * (Exemple pour PostgreSQL : 'Mon' pour lundi, 'Tue' pour mardi...)
 */
function countArticlesByDay(string $dayName): int {
    // Requête PostgreSQL pour filtrer par le jour de la semaine textuel raccourci
    $sql = "SELECT COUNT(*) as total 
            FROM article 
            WHERE TO_CHAR(date_pub, 'Dy') = ? 
            AND date_pub >= DATE_TRUNC('week', CURRENT_DATE)";
    $result = executeSelect($sql, [$dayName], true);
    return (int)($result['total'] ?? 0);
}
