<!-- view/layout/public.layout.php -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">

    <!--  NAVBAR DYNAMIQUE (STYLE DE VOTRE MAQUETTE) -->

    <nav class="bg-transparent py-6 px-4 absolute top-0 left-0 w-full z-50">
        <div class="max-w-7xl mx-auto bg-white rounded-full border-b-2 border-amber-500 h-16 flex items-center justify-between px-8 shadow-lg">

            <!-- LOGO GAUCHE -->
            <a href="<?= WEBROOT ?>" class="text-xl font-extrabold tracking-tight font-serif flex items-center">
                <span class="text-amber-500">ECOLE</span>
                <span class="text-amber-500 ml-0.5">221GO</span>
            </a>

            <!-- MENU DES CATEGORIES -->
            <div class="hidden md:flex items-center space-x-6 text-[10px] font-black uppercase tracking-widest text-gray-900">
                <a href="<?= WEBROOT ?>" class="<?= !isset($_GET['cat']) ? 'text-amber-500' : 'hover:text-amber-500' ?> transition-colors">
                    ACCEUIL
                </a>
                <?php if (!empty($nav_categories)): ?>
                    <?php foreach ($nav_categories as $cat): ?>
                        <a href="<?= WEBROOT ?>?controller=home&action=index&cat=<?= $cat['id_categorie'] ?>"
                            class="<?= (isset($_GET['cat']) && (int)$_GET['cat'] === (int)$cat['id_categorie']) ? 'text-amber-500' : 'hover:text-amber-500' ?> transition-colors">
                            <?= htmlspecialchars(strtoupper($cat['nom'])) ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

       
            <div class="flex items-center shrink-0">
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- Si le lecteur est connecté, on affiche son prénom et un bouton Déconnexion -->
                    <div class="flex items-center space-x-3 text-[10px] font-bold uppercase tracking-widest text-gray-700">
                        <span> <?= htmlspecialchars($_SESSION['user']['prenom']) ?></span>
                        <a href="<?= WEBROOT ?>?controller=auth&action=logout"
                            class="border border-red-400 rounded-full px-4 py-1.5 text-red-500 hover:bg-red-50 transition-colors">
                            Quitter
                        </a>
                    </div>
                <?php else: ?>
                    <!-- S'il n'est pas connecté, on affiche le bouton classique -->
                    <a href="<?= path('auth', 'login') ?>"
                        class="border border-amber-400/60 rounded-full px-5 py-1.5 text-[10px] font-black uppercase text-gray-600 tracking-widest flex items-center gap-3 hover:bg-amber-50 transition-colors">
                        <span>Se connecter</span>
                        <i class="fas fa-search text-amber-500 text-xs"></i>
                    </a>
                <?php endif; ?>
            </div>


        </div>
    </nav>



    <!--  INJECTION DE LA VUE DYNAMIQUE -->
    <main class="flex-grow w-full">
        <?php include(ROOT . "view/" . $view . ".php"); ?>
    </main>

    <!--FOOTER FIDÈLE À VOTRE MAQUETTE -->
    <footer class="bg-white border-t border-gray-100 py-12 mt-12 text-sm text-gray-500">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="space-y-3">
                <h4 class="font-black text-amber-500 tracking-wider">ECOLE221GO</h4>
                <p class="text-xs text-gray-400">Suivez-nous sur :</p>
                <div class="flex gap-3 text-gray-400"><i class="fab fa-tiktok"></i><i class="fab fa-facebook"></i><i class="fab fa-twitter"></i><i class="fab fa-instagram"></i></div>
            </div>
            <div>
                <h5 class="font-bold text-gray-800 mb-3">Accueil</h5>
                <p class="text-xs text-gray-400">À propos</p>
            </div>
            <div>
                <h5 class="font-bold text-gray-800 mb-3">À propos</h5>
                <p class="text-xs text-gray-400">À propos</p>
            </div>
            <div>
                <h5 class="font-bold text-gray-800 mb-3">Services</h5>
                <p class="text-xs text-gray-400">À propos</p>
            </div>
        </div>
    </footer>

</body>

</html>