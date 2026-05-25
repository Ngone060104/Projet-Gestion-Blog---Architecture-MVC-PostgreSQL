<?php

// Démarre la session si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define("WEBROOT","http://localhost:8002/");
define("ROOT", (substr($_SERVER['DOCUMENT_ROOT'] ,0, -6)));

require_once(ROOT."config/db.php");
require_once(ROOT."config/helpers.php");
require_once(ROOT."config/validator.php");
require_once(ROOT."core/route.php");

// Si l'utilisateur n'est pas connecté et qu'il ne demande pas explicitement à aller sur le contrôleur d'authentification
if (!isset($_SESSION['user']) && ($_REQUEST['controller'] ?? '') !== 'auth') {
    header("Location: " . path("auth", "login"));
    exit();
}

// On récupère le nom du contrôleur (par défaut 'dashboard')
$ctrl=$_REQUEST["controller"]??"dashboard";
// On appelle la fonction de routage définie ailleurs
dispatch($ctrl);
// echo "test index";

// Dans public/index.php



