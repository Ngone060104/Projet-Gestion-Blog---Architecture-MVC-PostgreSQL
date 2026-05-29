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
        $contenu = trim($_POST['contenu'] ?? '');
        $id_utilisateur = (int)$user['id_user'];

        // Validation des champs
        isEmpty('titre', $titre, $erreurs, "Le titre est obligatoire.");
        isEmpty('date_pub', $date_pub, $erreurs, "La date est obligatoire.");
        isEmpty('description', $description, $erreurs, "La description est obligatoire.");
        isEmpty('contenu', $contenu, $erreurs, "Le contenu est obligatoire.");
        if ($id_categorie === 0) {
            $erreurs['id_categorie'] = "Veuillez choisir une catégorie.";
        }

        // 🔥 GESTION DE L'UPLOAD DE LA PHOTO
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
 * Helper de génération de slug URL
 */
