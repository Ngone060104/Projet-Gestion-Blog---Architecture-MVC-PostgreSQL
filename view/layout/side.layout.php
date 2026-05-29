<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EBLOG - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lien FontAwesome complet pour charger vos icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body class="bg-gray-50 font-sans flex min-h-screen">

    <!-- 1. SIDEBAR NOIRE (STYLE MAQUETTE) -->
    <div class="w-64 bg-gray-900 text-white flex flex-col justify-between p-6 shrink-0">
        <div>
            <!-- LOGO -->
            <div class="mb-10 px-4">
                <h1 class="text-2xl font-extrabold tracking-wider font-serif">EBLOG</h1>
            </div>

            <!-- MENU DE NAVIGATION -->
            <nav class="space-y-2 mt-6">
                <?php $ctrl_actif = $_REQUEST['controller'] ?? 'dashboard'; ?>

                <a href="<?= path('dashboard', 'index') ?>"
                    class="flex items-center space-x-4 px-5 py-3.5 rounded-xl transition-all duration-200 font-medium text-sm
              <?= $ctrl_actif === 'dashboard' ? 'bg-amber-500/20 text-amber-500 font-bold' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?>">
                    <i class="fas fa-th-large w-5 text-lg"></i>
                    <span>Dashboard</span>
                </a>

                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <a href="<?= path('user', 'index') ?>"
                        class="flex items-center space-x-4 px-5 py-3.5 rounded-xl transition-all duration-200 font-medium text-sm
                  <?= $ctrl_actif === 'user' ? 'bg-amber-500/20 text-amber-500 font-bold' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?>">
                        <i class="fas fa-users w-5 text-lg"></i>
                        <span>Utilisateurs</span>
                    </a>

                    <a href="<?= path('comment', 'index') ?>"
                        class="flex items-center space-x-4 px-5 py-3.5 rounded-xl transition-all duration-200 font-medium text-sm
                  <?= $ctrl_actif === 'comment' ? 'bg-amber-500/20 text-amber-500 font-bold' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?>">
                        <i class="fas fa-comments w-5 text-lg"></i>
                        <span>Commentaire</span>
                    </a>

                    <a href="<?= path('signalement', 'index') ?>"
                        class="flex items-center space-x-4 px-5 py-3.5 rounded-xl transition-all duration-200 font-medium text-sm
                  <?= $ctrl_actif === 'signalement' ? 'bg-amber-500/20 text-amber-500 font-bold' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?>">
                        <i class="fas fa-bell w-5 text-lg"></i>
                        <span>Signalement</span>
                    </a>
                    
                     <a href="<?= path('categorie', 'index') ?>"
                        class="flex items-center space-x-4 px-5 py-3.5 rounded-xl transition-all duration-200 font-medium text-sm
                  <?= $ctrl_actif === 'categorie' ? 'bg-amber-500/20 text-amber-500 font-bold' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?>">
                        <i class="fas fa-tags w-5 text-lg"></i>
                        <span>Categories</span>
                    </a>
                <?php endif; ?>
                  <a href="<?= path('article', 'index') ?>"
                        class="flex items-center space-x-4 px-5 py-3.5 rounded-xl transition-all duration-200 font-medium text-sm
                  <?= $ctrl_actif === 'article' ? 'bg-amber-500/20 text-amber-500 font-bold' : 'text-gray-400 hover:bg-gray-800 hover:text-white' ?>">
                        <i class="fas fa-book w-5 text-lg"></i>
                        <span>Articles</span>
                    </a>
                 
            </nav>

        </div>

        <!-- DECONNEXION -->
        <div class="border-t border-gray-800 pt-4">
            <a href="<?= path('auth', 'logout') ?>" class="flex items-center space-x-3 px-4 py-3 text-red-400 hover:bg-red-950/20 rounded-xl transition-all font-medium">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span>Déconnexion</span>
            </a>
        </div>
    </div>

    <!-- 2. ZONE DE CONTENU PRINCIPAL -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- BARRE SUPÉRIEURE (HEADER DYNAMIQUE) -->
        <header class="bg-white border-b border-gray-100 h-20 flex items-center justify-between px-8 shrink-0">
            <!-- 🔍 1. LA BARRE DE RECHERCHE DYNAMIQUE -->
            <div class="w-72 relative hidden sm:block">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                    <i class="fas fa-search text-sm"></i>
                </div>
                <input type="text"
                    placeholder="Rechercher..."
                    class="w-full pl-10 pr-4 py-2.5 bg-black border border-gray-100 rounded-xl text-sm focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition font-medium text-gray-600">
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <!-- Affichage dynamique du prénom et du nom de l'utilisateur connecté -->
                    <p class="text-sm font-bold text-gray-800">
                        <?= htmlspecialchars($_SESSION['user']['prenom'] . ' ' . $_SESSION['user']['nom']) ?>
                    </p>
                    <p class="text-xs font-semibold text-amber-500 uppercase tracking-wider">
                        Espace <?= ucfirst($_SESSION['user']['role']) ?>
                    </p>
                </div>
                <!-- Avatar par défaut (ou géré par l'upload plus tard) -->
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold border border-gray-100 shadow-sm uppercase">
                    <?= substr($_SESSION['user']['prenom'], 0, 1) . substr($_SESSION['user']['nom'], 0, 1) ?>
                </div>
            </div>
        </header>

        <!-- CONTENU DU DASHBOARD OU DES PAGES COMPOSANTS -->
        <main class="flex-1 p-8 overflow-y-auto">
            <?= $content ?>
        </main>
    </div>

</body>

</html>