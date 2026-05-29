<?php
// controller/commentController.php
require_once(ROOT . "model/moderationModel.php");

function indexAction() {
    // SÉCURITÉ : Admin uniquement
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header("Location: " . path("dashboard", "index"));
        exit();
    }

    $comments = findAllCommentsWithUsers();

    loadView("comment/listComment", [
        "comments" => $comments,
        "user" => $_SESSION['user']
    ], "side");
}

/**
 * Déclenche le bannissement de l'auteur du commentaire
 */
function toggleBanAction() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        exit("Accès refusé");
    }

    $id_user = (int)($_GET['id_user'] ?? 0);
    $status = trim($_GET['status'] ?? 'actif');

    if ($id_user > 0) {
        toggleUserBanStatus($id_user, $status);
    }

    // Redirection immédiate vers la liste des commentaires
    header("Location: " . path("comment", "index"));
    exit();
}

/**
 * Action pour supprimer un commentaire inapproprié ou abusif
 */
function deleteAction() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        exit("Accès refusé");
    }

    $id_comment = (int)($_GET['id'] ?? 0);
    if ($id_comment > 0) {
        deleteCommentById($id_comment); // Appel du modèle pour retirer le message
    }

    // Redirection immédiate pour rafraîchir le tableau
    header("Location: " . path("comment", "index"));
    exit();
}
