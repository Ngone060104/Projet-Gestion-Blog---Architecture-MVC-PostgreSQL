<!-- view/home/index.php -->
<div class="w-full space-y-12 pb-12 font-sans animate-fade-in">

  
<div class="w-full relative overflow-hidden bg-gray-900 min-h-[500px] flex items-center justify-center text-center px-6 sm:px-12 md:px-24">
    
  
    <div class="absolute inset-0 z-0">
        <img src="<?= WEBROOT ?>uploads/blog.png" 
             alt="Eblog Background" 
             class="w-full h-full object-cover object-center select-none">
        <!-- Léger voile sombre pour que le grand titre blanc reste lisible -->
        <div class="absolute inset-0 bg-black/10"></div>
    </div>
    
   
    <div class="relative z-10 max-w-4xl pt-16">
        <h1 class="text-white text-3xl sm:text-5xl md:text-6xl font-black tracking-wider uppercase drop-shadow-md font-sans">
            BIENVENUE SUR EBLOG
        </h1>
         <p class="text-sm md:text-base text-gray-300 font-medium max-w-xl mx-auto">
                Découvrez les dernières tendances, analyses exclusives et actualités décryptées par nos rédacteurs officiels.
            </p>
        </div>
    </div>

</div>


    <!-- ZONE CENTRÉE CONTENUE -->
    <div class="max-w-7xl mx-auto px-6 space-y-16">

      
        <div class="space-y-6">
            <div class="flex items-center space-x-3 border-l-4 border-amber-500 pl-3">
                <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight">Actualités du Jour</h2>
            </div>

            <?php if (!empty($actualites)): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php foreach ($actualites as $art): ?>
                        <!-- CARTE INDÉPENDANTE -->
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition group">
                            <!-- Image de la carte -->
                            <div class="h-44 bg-gray-50 overflow-hidden relative">
                                <?php 
                                $imgPath = (!empty($art['image']) && file_exists(ROOT . 'public/uploads/' . $art['image'])) 
                                             ? WEBROOT . 'uploads/' . $art['image'] 
                                             : 'https://unsplash.com'; 
                                ?>
                                <img src="<?= $imgPath ?>" alt="Illustration" class="w-full h-full object-cover group-hover:scale-103 transition duration-300">
                                <!-- Badge de réactions/like de votre maquette en haut à droite -->
                                <span class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-gray-700 font-bold text-[9px] px-2 py-0.5 rounded-full shadow-sm flex items-center gap-1">
                                    <i class="far fa-heart text-amber-500"></i> 44
                                </span>
                            </div>

                            <!-- Descriptif -->
                            <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                                <div class="flex items-center justify-between text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                    <span><?= htmlspecialchars($art['categorie_nom']) ?></span>
                                    <span>1 day ago</span>
                                </div>
                                <h3 class="text-sm font-extrabold text-gray-800 leading-snug line-clamp-2 group-hover:text-amber-500 transition-colors">
                                    <?= htmlspecialchars($art['titre']) ?>
                                </h3>
                                <p class="text-gray-400 text-[11px] leading-relaxed line-clamp-2">
                                    <?= htmlspecialchars($art['description'] ?? $art['contenu']) ?>
                                </p>
                            </div>

                            <!-- Pied de carte -->
                            <div class="px-4 pb-4 pt-2 border-t border-gray-50 flex items-center justify-between text-[11px]">
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 bg-amber-500/10 text-amber-600 font-bold rounded-full flex items-center justify-center text-[9px] uppercase">
                                        <?= substr($art['prenom'], 0, 1) . substr($art['nom'], 0, 1) ?>
                                    </div>
                                    <span class="font-bold text-gray-600"><?= htmlspecialchars($art['prenom']) ?></span>
                                </div>
                                <a href="<?= WEBROOT ?>?controller=article&action=showPublic&slug=<?= $art['slug'] ?>" class="text-amber-500 font-bold hover:underline inline-flex items-center gap-1">
                                    Voir plus <i class="fas fa-chevron-right text-[8px]"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-sm text-gray-400 italic">Aucune actualité disponible aujourd'hui.</p>
            <?php endif; ?>
        </div>

        <!-- 3. SECTION BASSE : DERNIERS ARTICLES & SÉRIES (ASYNCHRONIQUE) -->
        <div class="space-y-6">
            <div class="flex items-center space-x-3 border-l-4 border-amber-500 pl-3">
                <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight">Dernières Articles</h2>
            </div>

            <!-- Grille divisée : 2/3 pour les grands articles, 1/3 pour la liste de droite -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- BLOC DE GAUCHE (2 COLONNES) -->
                <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <?php 
                    // On isole les deux premiers éléments pour la section de gauche
                    $bloc_gauche = array_slice($derniers_articles, 0, 2); 
                    foreach ($bloc_gauche as $art):
                    ?>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col group">
                            <div class="h-48 relative bg-gray-100">
                                <?php 
                                $imgPath = (!empty($art['image']) && file_exists(ROOT . 'public/uploads/' . $art['image'])) 
                                             ? WEBROOT . 'uploads/' . $art['image'] 
                                             : 'https://unsplash.com'; 
                                ?>
                                <img src="<?= $imgPath ?>" alt="Photo" class="w-full h-full object-cover">
                                <span class="absolute top-3 right-3 bg-purple-600 text-white rounded-full p-1.5 text-xs shadow-sm w-7 h-7 flex items-center justify-center"><i class="far fa-star"></i></span>
                            </div>
                            <div class="p-5 space-y-3 flex-1 flex flex-col justify-between">
                                <h4 class="text-xs font-bold text-gray-400 uppercase"><?= htmlspecialchars($art['categorie_nom']) ?></h4>
                                <h3 class="text-base font-black text-gray-800 leading-snug line-clamp-2"><?= htmlspecialchars($art['titre']) ?></h3>
                                <div class="flex items-center justify-between text-[11px] pt-2 border-t border-gray-50">
                                    <span class="text-gray-400"><?= date('d M Y', strtotime($art['date_pub'])) ?></span>
                                    <a href="<?= WEBROOT ?>?controller=article&action=showPublic&slug=<?= $art['slug'] ?>" class="text-blue-500 font-bold hover:underline">Voir +</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- BLOC DE DROITE (1 COLONNE : SÉRIES/ÉPISODES DE VOTRE MAQUETTE) -->
                               <!-- BLOC DE DROITE (1 COLONNE : SÉRIES/ÉPISODES DE VOTRE MAQUETTE) -->
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                        <h4 class="text-xs font-black text-gray-800 uppercase tracking-wider">Séries Sénégalaises</h4>
                        <span class="text-[10px] font-bold text-purple-600 cursor-pointer hover:underline">See all</span>
                    </div>

                    <!-- Liste d'épisodes calée sur le design noir de votre maquette -->
                    <div class="space-y-3">
                        <?php 
                        // On prend les articles restants pour alimenter la liste
                        $bloc_droit = array_slice($derniers_articles, 2, 3);
                        $idx = 1;
                        foreach ($bloc_droit as $art):
                        ?>
                            <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 transition cursor-pointer">
                                <div class="w-12 h-12 bg-gray-900 rounded-lg overflow-hidden shrink-0 flex items-center justify-center text-white text-xs font-mono font-bold">
                                    M0<?= $idx++ ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-xs font-extrabold text-gray-800 truncate"><?= htmlspecialchars($art['titre']) ?></h5>
                                    <p class="text-[10px] text-gray-400 font-medium mt-0.5">● <?= htmlspecialchars($art['categorie_nom']) ?> · 20 mins</p>
                                </div>
                            </div>
                        <?php 
                        endforeach; // <--- LA FERMETURE OBLIGATOIRE QUI MANQUAIT !
                        ?>
                        
                        <!-- Ligne supplémentaire de simulation si vide -->
                        <?php if(count($bloc_droit) == 0): ?>
                            <div class="text-center py-6 text-xs text-gray-400 font-medium">Aucun autre article en rubrique secondaire.</div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
