<?php
// model/moderationModel.php

/**
 * Récupère tous les commentaires du blog avec les informations de l'auteur et de l'article
 */
function findAllCommentsWithUsers(): array {
    $sql = "SELECT c.*, u.prenom, u.nom, u.email, u.statut_lecteur, u.id_user, a.titre as article_titre 
            FROM commentaire c
            JOIN utilisateur u ON c.id_user = u.id_user
            JOIN article a ON c.id_article = a.id_article
            ORDER BY c.date DESC";
    return executeSelect($sql);
}

/**
 * Banni ou débanni un utilisateur en inversant son statut
 */
function toggleUserBanStatus(int $id_user, string $currentStatus): bool {
    // Si l'utilisateur est actif, on le passe en 'estBanni', sinon on le repasse en 'actif'
    $newStatus = ($currentStatus === 'actif') ? 'estBanni' : 'actif';
    
    $sql = "UPDATE utilisateur SET statut_lecteur = ? WHERE id_user = ?";
    return executeUpdate($sql, [$newStatus, $id_user]);
}


//  Supprime un commentaire jugé inapproprié
 
function deleteCommentById(int $id_comment): bool {
    $sql = "DELETE FROM commentaire WHERE id_comment = ?";
    return executeUpdate($sql, [$id_comment]);
}

/**
 * Supprime définitivement un commentaire de la base de données
 */
