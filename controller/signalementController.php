<?php
// controller/signalementController.php
require_once(ROOT . "model/signalementModel.php");
require_once(ROOT . "model/moderationModel.php"); // Permet de réutiliser deleteCommentById

function indexAction() {
    // SÉCURITÉ ABSOLUE
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header("Location: " . WEBROOT . "?controller=dashboard&action=index");
        exit();
    }

    $signalements = findAllSignalements();

    loadView("signalement/listSignalement", [
        "signalements" => $signalements,
        "user" => $_SESSION['user']
    ], "side");
}

/**
 * Action : L'admin juge le commentaire conforme et rejette le signalement
 */
function dismissAction() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') { exit("Accès refusé"); }

    $id_sig = (int)($_GET['id'] ?? 0);
    if ($id_sig > 0) {
        updateSignalementStatut($id_sig, 'Rejeté / Conforme');
    }

    header("Location: " . WEBROOT . "?controller=signalement&action=index");
    exit();
}
