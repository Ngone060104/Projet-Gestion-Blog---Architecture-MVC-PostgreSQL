<?php
function dispatch($controllerName) {
    // On construit dynamiquement le chemin du contrôleur
    $controllerFile = ROOT . "controller/" . $controllerName . "Controller.php";

    if (file_exists($controllerFile)) {
        require_once($controllerFile);
        $action = $_REQUEST['action'] ?? $controllerName;
        $functionName = $action . "Action";  
        if (function_exists($functionName)) {
            $functionName();
        } else {
            die("Erreur : La fonction '{$functionName}' n'existe pas dans le contrôleur.");
        }
    } else {
        die("Erreur : Le contrôleur '{$controllerName}' n'existe pas.");
    }
}
