<?php
// controller/homeController.php
require_once(ROOT . "model/frontModel.php");

function indexAction() {
    // 1. Charger les catégories obligatoires pour la Navbar
    $nav_categories = getNavbarCategories();

    // 2. Vérifier s'il y a un filtrage par catégorie depuis la Navbar
    $id_cat_filtre = (int)($_GET['cat'] ?? 0);

    // 3. Charger les blocs de la maquette
    $actualites = getActualitesDuJour($id_cat_filtre);
    $derniers_articles = getDerniersArticles();

    // 4. Charger la vue publique avec le layout "public" (sans sidebar noire)
    loadView("home/index", [
        "nav_categories" => $nav_categories,
        "actualites" => $actualites,
        "derniers_articles" => $derniers_articles,
        "current_cat" => $id_cat_filtre,
        "user" => $_SESSION['user'] ?? null
    ], "public");
}


function homeAction()
{
    // Redirection vers la fonction principale pour votre routeur
    indexAction();
}
