<?php
// controller/dashboardController.php
require_once ROOT . "model/dashboardModel.php";
function indexAction() {
    // Sécurité : Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user'])) {
        header("Location: " . path("auth", "login"));
        exit();
    }

    $user = $_SESSION['user'];
    $stats = [];

    if ($user['role'] === 'admin') {
        // --- STATISTIQUES GLOBALES POUR L'ADMIN (D'après votre maquette) ---
        $stats['case1_titre'] = "Total d'Auteurs";
        $stats['case1_valeur'] = countAllAuteurs();
        $stats['case1_icone'] = "fas fa-user-edit text-blue-500 bg-blue-50";

        $stats['case2_titre'] = "Total de Lecteurs";
        $stats['case2_valeur'] = countAllLecteurs();
        $stats['case2_icone'] = "fas fa-users text-green-500 bg-green-50";

        $stats['case3_titre'] = "Total Comments";
        $stats['case3_valeur'] = countAllComments();
        $stats['case3_icone'] = "fas fa-comments text-purple-500 bg-purple-50";

        $stats['case4_titre'] = "Total Articles";
        $stats['case4_valeur'] = countAllArticles();
        $stats['case4_icone'] = "fas fa-newspaper text-amber-500 bg-amber-50";
    } else {
        // --- STATISTIQUES PERSONNELLES POUR L'AUTEUR (ex: Astou Diop) ---
        $stats['case1_titre'] = "Mon Profil";
        $stats['case1_valeur'] = "Rédacteur";
        $stats['case1_icone'] = "fas fa-user-circle text-blue-500 bg-blue-50";

        // Nombre de lecteurs uniques ayant commenté SES articles
        $stats['case2_titre'] = "Mes Lecteurs";
        $stats['case2_valeur'] = countAuteurLecteurs($user['id']);
        $stats['case2_icone'] = "fas fa-users text-green-500 bg-green-50";

        // Total des commentaires reçus sur SES articles
        $stats['case3_titre'] = "Commentaires Reçus";
        $stats['case3_valeur'] = countAuteurCommentsReceived($user['id']);
        $stats['case3_icone'] = "fas fa-comments text-purple-500 bg-purple-50";

        // Nombre d'articles qu'IL a rédigés
        $stats['case4_titre'] = "Mes Articles";
        $stats['case4_valeur'] = countAuteurArticles($user['id']);
        $stats['case4_icone'] = "fas fa-newspaper text-amber-500 bg-amber-50";
    }

    // Chargement de la vue dashboard avec le layout de la Sidebar
    loadView("dashboard/index", [
        "stats" => $stats,
        "user" => $user
    ], "side");
}

function dashboardAction() {
    // Redirection vers la fonction principale pour votre routeur
    indexAction(); 
}
