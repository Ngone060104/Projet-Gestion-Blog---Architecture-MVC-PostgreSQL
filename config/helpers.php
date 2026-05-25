<?php
function dd($test){
    echo "<pre>";
    var_dump($test);
    echo "</pre>";
    die("YALLA PITHIE");
};



function loadView(string $view,array $datas=[],string $layout="side") {
    ob_start();
    extract($datas);
    require_once(ROOT."view/".$view.".php");
    $content=ob_get_clean();
    require_once ROOT."/view/layout/$layout.layout.php";
}

function path(string $controller, string $action): string{
    return WEBROOT."?controller=$controller&action=$action";
}

function countTable(string $table){
    $sql="SELECT COUNT(*) as total FROM $table";
   return executeSelect($sql,[],true)["total"];
}


// Démarre la session si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifie si l'utilisateur est connecté
function isConnected(): bool {
    return isset($_SESSION['user']);
}


// Vérifie si l'utilisateur connecté est un Admin
function isAdmin(): bool {
    return isConnected() && $_SESSION['user']['role'] === 'admin';
}


// Vérifie si l'utilisateur connecté est un Client
function isAuteur(): bool {
    return isConnected() && $_SESSION['user']['role'] === 'auteur';
}

