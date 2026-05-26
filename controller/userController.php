<?php
// controller/userController.php
require_once(ROOT . "model/userModel.php");

function indexAction() {
    // SÉCURITÉ ABSOLUE : Si pas admin, redirection vers le dashboard
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header("Location: " . WEBROOT . "?controller=dashboard&action=index");
        exit();
    }

    // Récupération des filtres issus des inputs de votre maquette
    $search = trim($_GET['search'] ?? '');
    $role = trim($_GET['role'] ?? '');

    // Récupération des utilisateurs filtrés
    $users = findAllUsers($search, $role);

    // Chargement de la vue utilisateur avec le layout de la Sidebar
    loadView("user/listUser", [
        "users" => $users,
        "search" => $search,
        "current_role" => $role
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
