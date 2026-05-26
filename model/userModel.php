<?php
// Dans model/userModel.php

/**
 * Recherche un utilisateur par son email et son mot de passe
 */
function findUserByEmailAndPassword(string $email, string $password) {
    $sql = "SELECT * FROM utilisateur WHERE TRIM(email) = ? AND TRIM(password) = ?";
    
    // Vos fonctions prennent tout en charge, il suffit de passer l'argument $one = true
    return executeSelect($sql, [trim($email), trim($password)], true);
}

/**
 * Enregistre un nouvel utilisateur (Lecteur par défaut)
 */
function saveUser(string $nom, string $prenom, string $email, string $password): bool {
    $sql = "INSERT INTO utilisateur (nom, prenom, email, password, role, statut_lecteur) 
            VALUES (?, ?, ?, ?, 'lecteur', 'actif')";
            
    // Utilisation de votre fonction générique d'écriture
    return executeUpdate($sql, [trim($nom), trim($prenom), trim($email), trim($password)]);
}

// À ajouter dans model/userModel.php

/**
 * Récupère tous les utilisateurs avec filtres dynamiques (Nom et Rôle)
 */
function findAllUsers(string $search = '', string $role = ''): array {
    $sql = "SELECT * FROM utilisateur WHERE 1=1";
    $params = [];

    if (!empty($search)) {
        $sql .= " AND (LOWER(nom) LIKE ? OR LOWER(prenom) LIKE ? OR LOWER(email) LIKE ?)";
        $searchTerm = "%" . strtolower($search) . "%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }

    if (!empty($role)) {
        $sql .= " AND role = ?";
        $params[] = $role;
    }

    $sql .= " ORDER BY id_user ASC";
    return executeSelect($sql, $params);
}

/**
 * Supprime un utilisateur (Action bouton rouge de la maquette)
 */
function deleteUserById(int $id): bool {
    $sql = "DELETE FROM utilisateur WHERE id_user = ?";
    return executeUpdate($sql, [$id]);
}
