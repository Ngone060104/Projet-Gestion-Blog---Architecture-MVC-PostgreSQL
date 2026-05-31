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

// On récupère le nom du contrôleur (par défaut 'dashboard')
$ctrl=$_REQUEST["controller"]??"home";

// 2. SÉCURITÉ INTELLIGENTE :
// Si l'utilisateur n'est pas connecté, il peut voir 'home' (le site) et 'auth' (connexion/inscription)
// Mais s'il essaie d'aller sur 'dashboard', 'user', 'comment', ou 'categorie', on le renvoie au login
$controleurs_prives = ['dashboard', 'user', 'comment', 'signalement', 'categorie'];

if (!isset($_SESSION['user']) && in_array($ctrl, $controleurs_prives)) {
    header("Location: " . path("auth", "login"));
    exit();
}

// On appelle la fonction de routage définie ailleurs
dispatch($ctrl);





