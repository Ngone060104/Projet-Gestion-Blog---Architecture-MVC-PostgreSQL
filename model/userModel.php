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