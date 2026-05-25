<?php
// Dans controller/authController.php
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

            if ($user) {
                // SÉCURITÉ SUPPLÉMENTAIRE : On vérifie si le lecteur n'est pas banni
                if (isset($user['statut_lecteur']) && $user['statut_lecteur'] === 'estBanni') {
                    $erreurs['global'] = "Votre compte a été suspendu par l'administrateur.";
                } else {
                    // Ouverture de la session
                    $_SESSION['user'] = $user;
                    
                    // Redirection automatique vers votre futur dashboard
                    header("Location: " . WEBROOT . "?controller=dashboard&action=index");
                    exit();
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
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    unset($_SESSION['user']);
    session_destroy();
    
    header("Location: " . WEBROOT . "?controller=auth&action=login");
    exit();
}
