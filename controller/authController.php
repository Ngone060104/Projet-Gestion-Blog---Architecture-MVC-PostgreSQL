<?php
// controller/authController.php
require_once(ROOT . "model/userModel.php");

function loginAction() {
    $erreurs = [];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Validation des champs vides via vos helpers
        isEmpty('email', $email, $erreurs, "L'adresse email est obligatoire.");
        isEmpty('password', $password, $erreurs, "Le mot de passe est obligatoire.");

        if (validate($erreurs)) {
            // Recherche en base de données PostgreSQL
            $user = findUserByEmailAndPassword($email, $password);

            // Vérification stricte que l'utilisateur existe bien et n'est pas vide
            if ($user !== false && !empty($user)) {
                
                // SÉCURITÉ : On vérifie si le compte est banni
                if (isset($user['statut_lecteur']) && $user['statut_lecteur'] === 'estBanni') {
                    $erreurs['global'] = "Votre compte a été suspendu pour non-respect des règles de la communauté.";
                } else {
                    // Ouverture de la session globale
                    $_SESSION['user'] = $user;
                    
                    //  REDIRECTION INTELLIGENTE SELON LE RÔLE D'ADN
                    if (isset($user['role']) && $user['role'] === 'lecteur') {
                        // Le lecteur reste sur le site public pour lire et commenter
                        header("Location: " . WEBROOT);
                        exit();
                    } else {
                        // L'admin et l'auteur vont sur le dashboard de gestion
                        header("Location: " . WEBROOT . "?controller=dashboard&action=index");
                        exit();
                    }
                }
            } else {
                $erreurs['global'] = "Identifiants incorrects ou compte inexistant.";
            }
        }
    }

    // Chargement de la vue de connexion avec un layout blanc (sans barre latérale)
    loadView("auth/login", ["erreurs" => $erreurs], "blank");
}

function logoutAction() {
    if (session_status() === PHP_SESSION_NONE) { 
        session_start(); 
    }
    unset($_SESSION['user']);
    session_destroy();
    
    // Après déconnexion, on ramène à l'accueil du site public
    header("Location: " . WEBROOT);
    exit();
}

function authAction() {
    // Redirige automatiquement vers votre formulaire d'authentification
    loginAction(); 
}
