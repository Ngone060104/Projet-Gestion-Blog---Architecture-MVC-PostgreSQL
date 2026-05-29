<!-- view/article/showArticle.php -->
<div class="max-w-4xl mx-auto space-y-8 font-sans animate-fade-in">
    
    <!-- Bouton Retour au catalogue -->
    <div>
        <a href="<?= path('article', 'index') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-amber-500 transition uppercase tracking-wider">
            <i class="fas fa-arrow-left"></i> Retour aux articles
        </a>
    </div>

    <!-- 🖼️ ZONE GRAPHIQUE : IMAGE D'ILLUSTRATION ET TITRE -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden flex flex-col md:flex-row gap-6 p-6">
        
        <!-- Image téléversée -->
        <div class="w-full md:w-1/3 h-48 bg-gray-50 rounded-2xl overflow-hidden shrink-0">
            <?php 
            $imagePath = (!empty($article['image']) && file_exists(ROOT . 'public/uploads/' . $article['image'])) 
                         ? WEBROOT . 'uploads/' . $article['image'] 
                         : 'https://unsplash.com'; 
            ?>
            <img src="<?= $imagePath ?>" alt="Illustration" class="w-full h-full object-cover">
        </div>

        <!-- Méta-données de l'article -->
        <div class="flex flex-col justify-between py-2 space-y-3">
            <div class="space-y-1">
                <span class="px-2.5 py-1 bg-amber-500/10 text-amber-600 rounded-full text-[10px] font-bold uppercase tracking-wider">
                    <?= htmlspecialchars($article['categorie_nom']) ?>
                </span>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight leading-tight mt-2 font-serif">
                    <?= htmlspecialchars($article['titre']) ?>
                </h1>
            </div>

            <div class="flex items-center space-x-6 text-xs text-gray-400 font-medium">
                <div class="flex items-center gap-1.5">
                    <i class="fas fa-user-circle text-amber-500"></i>
                    <span>Rédigé par : <strong class="text-gray-700"><?= htmlspecialchars($article['prenom'] . ' ' . $article['nom']) ?></strong></span>
                </div>
                <div class="flex items-center gap-1.5">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Le : <?= date('d M Y à H:i', strtotime($article['date_pub'])) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- 📝 GRANDE SECTION BLANCHE : LE CONTENU DE L'ARTICLE -->
    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-4">
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Description courte</h3>
        <p class="text-sm font-bold text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-100/50 italic leading-relaxed">
            " <?= htmlspecialchars($article['description']) ?> "
        </p>
        
        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider pt-4">Corps de l'article</h3>
        <div class="text-sm text-gray-600 leading-relaxed font-medium whitespace-pre-line">
            <?= htmlspecialchars($article['contenu']) ?>
        </div>
    </div>

    <!-- 💬 SECTION : COMMENTAIRES DES LECTEURS (DOUBLE COLONNE APPLATIE) -->
    <div class="space-y-4">
        <h3 class="text-lg font-extrabold text-gray-900 tracking-tight flex items-center gap-2">
            <i class="fas fa-comments text-amber-500"></i>
            <span>Commentaires de l'article (<?= count($comments) ?>)</span>
        </h3>

        <?php if (!empty($comments)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($comments as $com): ?>
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between space-y-3">
                        <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                            <span class="text-xs font-bold text-gray-800"><?= htmlspecialchars($com['prenom'] . ' ' . $com['nom']) ?></span>
                            <span class="text-[10px] text-gray-400"><?= date('d/m à H:i', strtotime($com['date'])) ?></span>
                        </div>
                        <p class="text-xs text-gray-500 font-medium italic leading-relaxed">
                            " <?= htmlspecialchars($com['contenu']) ?> "
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center text-xs text-gray-400 font-medium">
                Aucun commentaire n'a encore été déposé sous cet article.
            </div>
        <?php endif; ?>
    </div>

</div>
