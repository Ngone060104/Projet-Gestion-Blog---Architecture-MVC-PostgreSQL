<?php
// controller/dashboardController.php
require_once ROOT . "model/dashboardModel.php";
function indexAction()
{
    // Sécurité : Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user'])) {
        header("Location: " . path("auth", "login"));
        exit();
    }

  

    $user = $_SESSION['user'];
    $stats = [];

    if ($user['role'] === 'admin') {
        // --- STATISTIQUES GLOBALES POUR L'ADMIN (D'après votre maquette) ---
        $stats['case1_titre'] = "Total d'Aute..";
        $stats['case1_valeur'] = countAllAuteurs();
        $stats['case1_icone'] = "fas fa-user-edit text-blue-500 bg-blue-50";

        $stats['case2_titre'] = "Total de Lect..";
        $stats['case2_valeur'] = countAllLecteurs();
        $stats['case2_icone'] = "fas fa-users text-green-500 bg-green-50";

        $stats['case3_titre'] = "Total Comm..";
        $stats['case3_valeur'] = countAllComments();
        $stats['case3_icone'] = "fas fa-comments text-purple-500 bg-purple-50";

        $stats['case4_titre'] = "Total Arti..";
        $stats['case4_valeur'] = countAllArticles();
        $stats['case4_icone'] = "fas fa-newspaper text-amber-500 bg-amber-50";
    } else {
        // --- STATISTIQUES PERSONNELLES POUR L'AUTEUR (ex: Astou Diop) ---
        $stats['case1_titre'] = "Mon Profil";
        $stats['case1_valeur'] = "";
        $stats['case1_icone'] = "fas fa-user-circle text-blue-500 bg-blue-50";

        // Nombre de lecteurs uniques ayant commenté SES articles
        $stats['case2_titre'] = "Mes Lecteurs";
        $stats['case2_valeur'] = countAuteurLecteurs($user['id_user']);
        $stats['case2_icone'] = "fas fa-users text-green-500 bg-green-50";

        // Total des commentaires reçus sur SES articles
        $stats['case3_titre'] = "Comment Re..";
        $stats['case3_valeur'] = countAuteurCommentsReceived($user['id_user']);
        $stats['case3_icone'] = "fas fa-comments text-purple-500 bg-purple-50";

        // Nombre d'articles qu'IL a rédigés
        $stats['case4_titre'] = "Mes Articles";
        $stats['case4_valeur'] = countAuteurArticles($user['id_user']);
        $stats['case4_icone'] = "fas fa-newspaper text-amber-500 bg-amber-50";
    }
    // 2. Calcul dynamique des catégories pour la maquette
    $sql_cat = "SELECT c.nom, COUNT(a.id_article) as total_articles 
                FROM categorie_article c 
                LEFT JOIN article a ON a.id_categorie = c.id_categorie 
                GROUP BY c.id_categorie, c.nom";
    $categories_brutes = executeSelect($sql_cat);

    $categories_data = [];
    $total_articles = $stats['case4_valeur'] > 0 ? $stats['case4_valeur'] : 1;
    $couleurs = ['border-purple-500', 'border-green-600', 'border-blue-400'];
    $i = 0;

    foreach ($categories_brutes as $cat) {
        $pourcentage = round(($cat['total_articles'] / $total_articles) * 100);
        $categories_data[] = [
            'nom' => $cat['nom'],
            'percent' => $pourcentage . '%',
            'color' => $couleurs[$i % 3]
        ];
        $i++;
    }
    // À ajouter dans la fonction indexAction() de votre contrôleur :
    $jours = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $graph_data = [];

    foreach ($jours as $j) {
        $total_jour = countArticlesByDay($j);
        // On calcule une hauteur max pour le CSS (ex: si 0 article -> h-0, si beaucoup -> h-full)
        $hauteur_css = $total_jour > 0 ? min(($total_jour * 20), 100) . '%' : '4px';

        $graph_data[$j] = $hauteur_css;
    }
    // Chargement de la vue dashboard avec le layout de la Sidebar
    loadView("dashboard/index", [
        "stats" => $stats,
        "user" => $user,
        "categories" => $categories_data,
        "graph_data" => $graph_data
    ], "side");
}


function dashboardAction()
{
    // Redirection vers la fonction principale pour votre routeur
    indexAction();
}

