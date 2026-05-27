<?php
// controller/userController.php
require_once(ROOT . "model/userModel.php");

// function indexAction() {
//     // SÉCURITÉ ABSOLUE : Si pas admin, redirection vers le dashboard
//     if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
//         header("Location: " . WEBROOT . "?controller=dashboard&action=index");
//         exit();
//     }

//     // Récupération des filtres issus des inputs de votre maquette
//     $search = trim($_GET['search'] ?? '');
//     $role = trim($_GET['role'] ?? '');
//     $statuts = trim($_GET['statut'] ?? '');

//     // Récupération des utilisateurs filtrés
//     $users = findAllUsers($search, $role, $statuts);

//     // Chargement de la vue utilisateur avec le layout de la Sidebar
//     loadView("user/listUser", [
//         "users" => $users,
//         "search" => $search,
//         "current_role" => $role,
//         "current_statut" => $statuts
//     ], "side");
// }
// Dans controller/userController.php

function indexAction() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header("Location: " . WEBROOT . "?controller=dashboard&action=index");
        exit();
    }

    $erreurs = [];
    $openModal = false; // Permet de laisser la modale ouverte si le formulaire contient des erreurs

    // TRAITEMENT DU FORMULAIRE D'AJOUT D'AUTEUR
    if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action_type'] ?? '') === 'add_auteur') {
        $openModal = true;
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');// Mot de passe par défaut généré automatiquement

        isEmpty('nom', $nom, $erreurs, "Le nom est obligatoire.");
        isEmpty('prenom', $prenom, $erreurs, "Le prénom est obligatoire.");
        isEmpty('email', $email, $erreurs, "L'email est obligatoire.");
        if (!isset($erreurs['email']) && !isMailRegex($email)) {
            $erreurs['email'] = "Le format de l'email est invalide.";
        }
        isEmpty('password', $password, $erreurs, "Le mot de passe est obligatoire.");

        if (validate($erreurs)) {
            if (isEmailExists($email)) {
                $erreurs['email'] = "Cet email est déjà utilisé.";
            } else {
                if (saveAuteur($nom, $prenom, $email, $password)) {
                    header("Location: " . WEBROOT . "?controller=user&action=index");
                    exit();
                } else {
                    $erreurs['global'] = "Erreur lors de l'enregistrement.";
                }
            }
        }
    }

    // GESTION DES FILTRES DU TABLEAU
    $search = trim($_GET['search'] ?? '');
    $role = trim($_GET['role'] ?? '');
    $statut = trim($_GET['statut'] ?? '');

    $users = findAllUsers($search, $role, $statut);

    loadView("user/listUser", [
        "users" => $users,
        "search" => $search,
        "current_role" => $role,
        "current_statut" => $statut,
        "erreurs" => $erreurs,
        "openModal" => $openModal
    ], "side");
}

function deleteAction() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        exit("Accès refusé");
    }

    $id = (int)($_GET['id'] ?? 0);
    if ($id > 0) {
        deleteUserById($id);
    }
    
    header("Location: " . WEBROOT . "?controller=user&action=index");
    exit();
}

// function addAction() {
//     // SÉCURITÉ : Seul l'admin ajoute un auteur
//     if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
//         header("Location: " . path('dashboard', 'index'));
//         exit();
//     }

//     $erreurs = [];

//     if ($_SERVER["REQUEST_METHOD"] === "POST") {
//         $nom = trim($_POST['nom'] ?? '');
//         $prenom = trim($_POST['prenom'] ?? '');
//         $email = trim($_POST['email'] ?? '');
//         $password = trim($_POST['password'] ?? '');

//         // Validation des champs via vos helpers
//         isEmpty('nom', $nom, $erreurs, "Le nom est obligatoire.");
//         isEmpty('prenom', $prenom, $erreurs, "Le prénom est obligatoire.");
//         isEmpty('email', $email, $erreurs, "L'adresse email est obligatoire.");
//         isEmpty('password', $password, $erreurs, "Le mot de passe initial est obligatoire.");

//         if (!isset($erreurs['email']) && !isMailRegex($email)) {
//             $erreurs['email'] = "Le format de l'adresse email est incorrect.";
//         }

//         if (validate($erreurs)) {
//             // Vérification si l'email existe déjà
//             if (isEmailExists($email)) { // Utilise la fonction créée dans votre userModel
//                 $erreurs['email'] = "Cette adresse email est déjà attribuée.";
//             } else {
//                 // Enregistrement de l'auteur
//                 if (saveAuteur($nom, $prenom, $email, $password)) {
//                     header("Location: " . path('user', 'index'));
//                     exit();
//                 } else {
//                     $erreurs['global'] = "Une erreur technique est survenue.";
//                 }
//             }
//         }
//     }

//     // Chargement de la vue du formulaire avec la Sidebar noire
//     loadView("user/addAuteur", ["erreurs" => $erreurs], "side");
// }

