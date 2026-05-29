<?php
// controller/articleController.php
require_once(ROOT . "model/articleModel.php");

// function indexAction() {
//     if (!isset($_SESSION['user'])) {
//         header("Location: " . path("auth", "login"));
//         exit();
//     }

//     $user = $_SESSION['user'];

//     // Si l'utilisateur est auteur, on filtre par son ID, si c'est admin on met 0 (voit tout)
//     $id_auteur = ($user['role'] === 'auteur') ? (int)$user['id_user'] : 0;
//      $id_categorie = (int)($_GET['id_categorie'] ?? 0); // NOUVEAU

//     $articles = findAllArticles($id_auteur);
//     // 3. Récupération de toutes les catégories pour le select HTML
//     $categories = findAllCategories();

//     loadView("article/listArticle", [
//         "articles" => $articles,
//         "id_categorie" => $id_categorie,  // Permet de laisser l'option sélectionnée au rechargement
//         "categories" => $categories,
//         "user" => $user
//     ], "side");
// }
// controller/articleController.php
require_once(ROOT . "model/articleModel.php");

    function indexAction()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: " . path("auth", "login"));
            exit();
        }

        $user = $_SESSION['user'];
        $erreurs = [];
        $openModal = false; // Par défaut, la fenêtre modale est cachée

        // 1. TRAITEMENT DE SOUFFRANCE DU FORMULAIRE (SI REÇU EN POST)
        if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action_type'] ?? '') === 'add_article') {
            $openModal = true; // On force la modale à rester ouverte pour afficher les erreurs

            $titre = trim($_POST['titre'] ?? '');
            $date_pub = trim($_POST['date_pub'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $id_categorie = (int)($_POST['id_categorie'] ?? 0);
            $contenu = trim($_POST['content'] ?? '');
            $id_utilisateur = (int)$user['id_user'];

            // Validation des champs
            isEmpty('titre', $titre, $erreurs, "Le titre est obligatoire.");
            isEmpty('date_pub', $date_pub, $erreurs, "La date est obligatoire.");
            isEmpty('description', $description, $erreurs, "La description est obligatoire.");
            isEmpty('contenu', $contenu, $erreurs, "Le contenu est obligatoire.");
            if ($id_categorie === 0) {
                $erreurs['id_categorie'] = "Veuillez choisir une catégorie.";
            }

            // GESTION DE L'UPLOAD DE LA PHOTO
            $imageNom = 'default.jpg'; // Image par défaut si l'auteur n'en met pas

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['photo']['tmp_name'];
            $fileName = $_FILES['photo']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // extensions autorisées
            $extensions_autorisees = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExtension, $extensions_autorisees)) {
                // Génération d'un nom unique basé sur le temps (ex: img_168541245.png)
                $imageNom = 'img_' . time() . '.' . $fileExtension;
                
                // Dossier de destination physique dans votre architecture
                $uploadFileDir = ROOT . 'public/uploads/';
                
                // Créer le dossier s'il n'existe pas encore
                if (!is_dir($uploadFileDir)) {
                    mkdir($uploadFileDir, 0777, true);
                }

                $dest_path = $uploadFileDir . $imageNom;

                // Déplacement du fichier temporaire vers le vrai dossier
                if (!move_uploaded_file($fileTmpPath, $dest_path)) {
                    $erreurs['photo'] = "Erreur lors du déplacement du fichier sur le serveur.";
                }
            } else {
                $erreurs['photo'] = "Format invalide. Seuls les fichiers JPG, JPEG, PNG et WEBP sont acceptés.";
            }
        }

            if (validate($erreurs)) {
                // Génération automatique du slug d'URL exigé par le jury
                $slug = generateSlug($titre);
                // Par défaut, l'article est enregistré en statut 'PUBLIEE' ou 'BROUILLON'
                $statut = 'PUBLIEE';

                if (saveArticle($titre, $contenu, $description, $slug, $statut, $id_utilisateur, $id_categorie,$imageNom)) {
                    header("Location: " . WEBROOT . "?controller=article&action=index");
                    exit();
                } else {
                    $erreurs['global'] = "Une erreur technique est survenue.";
                }
            }
        }

        // 2. RÉCUPÉRATION DES DONNÉES DU CATALOGUE
        $id_auteur = ($user['role'] === 'auteur') ? (int)$user['id_user'] : 0;
        $id_categorie_filtre = (int)($_GET['id_categorie'] ?? 0);

        $articles = findAllArticles($id_auteur, $id_categorie_filtre);
        $categories = findAllCategories();

        // 3. ENVOI DES DONNÉES À LA VUE
        loadView("article/listArticle", [
            "articles" => $articles,
            "categories" => $categories,
            "current_categorie" => $id_categorie_filtre,
            "erreurs" => $erreurs,
            "openModal" => $openModal,
            "user" => $user
        ], "side");
    }

/**
 * Générateur automatique de slug
 */
function generateSlug(string $text): string
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'n-a' : $text;
}

/**
 * Affiche les détails complets d'un article pour l'auteur ou l'admin
 */
function showAction() {
    if (!isset($_SESSION['user'])) {
        header("Location: " . path("auth", "login"));
        exit();
    }

    // Récupération du slug depuis l'URL (Ex: ?controller=article&action=show&slug=mon-article)
    $slug = trim($_GET['slug'] ?? '');
    
    if (empty($slug)) {
        header("Location: " . WEBROOT . "?controller=article&action=index");
        exit();
    }

    // Récupération de l'article
    $article = findArticleBySlug($slug);

    if (!$article) {
        die("Erreur : Cet article n'existe pas ou a été supprimé.");
    }

    // Récupération des commentaires liés à cet article
    $comments = findCommentsByArticleId((int)$article['id_article']);

    // Chargement de la vue détail avec le layout de la Sidebar
    loadView("article/showArticle", [
        "article" => $article,
        "comments" => $comments,
        "user" => $_SESSION['user']
    ], "side");
}

/**
 * Affiche un article côté public et traite l'envoi des commentaires
 */
function showPublicAction() {
    require_once(ROOT . "model/articleModel.php");
    require_once(ROOT . "model/frontModel.php");

    $slug = trim($_GET['slug'] ?? '');
    if (empty($slug)) {
        header("Location: " . WEBROOT);
        exit();
    }

    // 1. Récupération de l'article par son slug
    $article = findArticleBySlug($slug);
    if (!$article) {
        header("Location: " . WEBROOT);
        exit();
    }

    $erreurs = [];

    // 2. TRAITEMENT DE L'AJOUT DE COMMENTAIRE (POST)
    if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action_type'] ?? '') === 'add_comment') {
        // Sécurité : Il faut être connecté pour commenter
        if (!isset($_SESSION['user'])) {
            header("Location: " . path("auth", "login"));
            exit();
        }

        $contenu = trim($_POST['commentaire_texte'] ?? '');
        isEmpty('commentaire_texte', $contenu, $erreurs, "Le texte du commentaire ne peut pas être vide.");

        if (validate($erreurs)) {
            $id_article = (int)$article['id_article'];
            $id_user = (int)$_SESSION['user']['id_user'];

            if (saveCommentairePublic($contenu, $id_article, $id_user)) {
                // Redirection sur la même page pour vider le formulaire et voir le commentaire
                header("Location: " . WEBROOT . "?controller=article&action=showPublic&slug=" . $slug);
                exit();
            } else {
                $erreurs['global'] = "Impossible d'enregistrer votre commentaire.";
            }
        }
    }

         // --- CAS B : L'ENVOI DE SIGNALEMENT (CE QUI MANQUAIT !) ---
        if (($_POST['action_type'] ?? '') === 'report_comment') {
            if (!isset($_SESSION['user'])) {
                header("Location: " . path("auth", "login"));
                exit();
            }

            $motif = trim($_POST['motif'] ?? '');
            $id_commentaire = (int)($_POST['id_commentaire'] ?? 0);
            $id_user = (int)($_SESSION['user']['id_utilisateur'] ?? $_SESSION['user']['id_user'] ?? $_SESSION['user']['id'] ?? 0);
            $id_article = (int)$article['id_article'];

            if (!empty($motif) && $id_commentaire > 0 && $id_user > 0) {
                require_once(ROOT . "model/signalementModel.php");
                
                if (saveSignalementPublic($motif, $id_commentaire, $id_article, $id_user)) {
                    // Redirection propre avec un paramètre de succès
                    header("Location: " . WEBROOT . "?controller=article&action=showPublic&slug=" . $slug . "&reported=1");
                    exit();
                } else {
                    $erreurs['global'] = "Erreur technique lors du signalement.";
                }
            }
        }

    // 3. Charger les catégories pour la Navbar du layout public
    $nav_categories = getNavbarCategories();
    // 4. Charger les commentaires existants de cet article
    $comments = findCommentsByArticleId((int)$article['id_article']);

    loadView("home/detailArticle", [
        "nav_categories" => $nav_categories,
        "article" => $article,
        "comments" => $comments,
        "erreurs" => $erreurs,
        "user" => $_SESSION['user'] ?? null
    ], "public"); // Utilisation du layout public avec la grande barre blanche
}

