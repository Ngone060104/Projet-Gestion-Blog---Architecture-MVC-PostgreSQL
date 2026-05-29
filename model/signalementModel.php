<?php
// recupere tous les signalements
function findAllSignalements(): array {
    // CORRECTION : Retrait de s.date_signalement
    $sql = "SELECT s.id_signal, s.motif, s.statut, s.id_user,
                   u.prenom as lecteur_prenom, u.nom as lecteur_nom, u.email as lecteur_email,
                   c.contenu as commentaire_texte, c.id_comment,
                   a.titre as article_titre
            FROM signalement s
            JOIN utilisateur u ON s.id_user = u.id_user
            JOIN commentaire c ON s.id_comment = c.id_comment
            JOIN article a ON s.id_article = a.id_article
            ORDER BY s.id_signal DESC"; // Tri par ID à la place de la date
            
    return executeSelect($sql);
}

/**
 * Met à jour le statut d'un signalement (ex: 'Traité')
 */
function updateSignalementStatut(int $id_signalement, string $statut): bool {
    $sql = "SELECT count(*) FROM signalement WHERE id_signal = ?"; // Sécurité de test
    $sql_real = "UPDATE signalement SET statut = ? WHERE id_signal = ?";
    return executeUpdate($sql_real, [trim($statut), $id_signalement]);
}

/**
 * Insère un nouveau signalement envoyé par un lecteur connecté
 */
function saveSignalementPublic(string $motif, int $id_commentaire, int $id_article, int $id_user): bool {
    // Par défaut, le statut du signalement est fixé à 'En attente'
    $sql = "INSERT INTO signalement (motif, statut, id_user, id_comment, id_article) 
            VALUES (?, 'En attente', ?, ?, ?)";
            
    return executeUpdate($sql, [trim($motif), $id_user, $id_commentaire, $id_article]);
}
