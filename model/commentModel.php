<?php
// model/commentModel.php

/**
 * Récupère l'intégralité des commentaires du blog pour l'écran de modération
 */
function findAllCommentsWithDetails(): array {
    $sql = "SELECT c.*, u.prenom, u.nom, u.email, u.statut_lecteur, u.id_utilisateur, a.titre as article_titre 
            FROM commentaire c
            JOIN utilisateur u ON c.id_utilisateur = u.id_utilisateur
            JOIN article a ON c.id_article = a.id_article
            ORDER BY c.date DESC";
    return executeSelect($sql); 
}

/**
 * Permet à l'administrateur de bannir ou débannir le rédacteur du commentaire
 */
function updateUserStatus(int $id_utilisateur, string $nouveauStatut): bool {
    $sql = "UPDATE utilisateur SET statut_lecteur = ? WHERE id_user = ?";
    return executeUpdate($sql, [trim($nouveauStatut), $id_utilisateur]);
}

/**
 * Supprime définitivement un commentaire du blog
 */
function deleteCommentById(int $id_commentaire): bool {
    $sql = "DELETE FROM commentaire WHERE id_commentaire = ?";
    return executeUpdate($sql, [$id_commentaire]);
}
