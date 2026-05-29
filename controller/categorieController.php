<?php
// controller/categorieController.php
require_once(ROOT . "model/categorieModel.php");

function indexAction() {
    // SÉCURITÉ ABSOLUE : Seul l'admin accède aux catégories
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        header("Location: " . WEBROOT . "?controller=dashboard&action=index");
        exit();
    }

    $erreurs = [];
    $openModal = false;

    // TRAITEMENT DU FORMULAIRE DE CRÉATION (POST)
    if ($_SERVER["REQUEST_METHOD"] === "POST" && ($_POST['action_type'] ?? '') === 'add_categorie') {
        $openModal = true;
        $nom = trim($_POST['nom'] ?? '');
        $description = trim($_POST['description'] ?? '');

        isEmpty('nom', $nom, $erreurs, "Le nom de la catégorie est obligatoire.");

        if (validate($erreurs)) {
            if (isCategorieExists($nom)) {
                $erreurs['nom'] = "Cette catégorie existe déjà sur le blog.";
            } else {
                if (saveCategorie($nom, $description)) {
                    header("Location: " . WEBROOT . "?controller=categorie&action=index");
                    exit();
                } else {
                    $erreurs['global'] = "Une erreur technique est survenue.";
                }
            }
        }
    }

    // Récupération de la liste pour le tableau
    $categories = findAllCategoriesWithCount();

    loadView("categorie/listCategorie", [
        "categories" => $categories,
        "erreurs" => $erreurs,
        "openModal" => $openModal,
        "user" => $_SESSION['user']
    ], "side");
}
