<?php
// recupere tous les signalements
function findAllSignalements(): array {
    $sql = "SELECT s.*, 
                   u.prenom as lecteur_prenom, u.nom as lecteur_nom, u.email as lecteur_email,
                   c.contenu as commentaire_texte, c.id_comment,
                   a.titre as article_titre
            FROM signalement s
            JOIN utilisateur u ON s.id_user = u.id_user
            JOIN commentaire c ON s.id_comment = c.id_comment
            JOIN article a ON s.id_article = a.id_article
            ORDER BY s.date DESC";
    return executeSelect($sql);
}

/**
 * Met à jour le statut d'un signalement (ex: 'Traité')
 */
function updateSignalementStatut(int $id_signalement, string $statut): bool {
    $sql = "SELECT count(*) FROM signalement WHERE id_signalement = ?"; // Sécurité de test
    $sql_real = "UPDATE signalement SET statut = ? WHERE id_signalement = ?";
    return executeUpdate($sql_real, [trim($statut), $id_signalement]);
}
