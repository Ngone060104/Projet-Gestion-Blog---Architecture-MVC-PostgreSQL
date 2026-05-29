<!-- view/article/listArticle.php -->
<div class="space-y-8 w-full font-sans animate-fade-in">

    <!-- EN-TÊTE DE LA PAGE -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-5 space-y-1 bg-white p-4 rounded-xl border border-gray-100 shadow-sm ">
        <div class="">
            <h2 class="text-2xl font-extrabold text-gray-900 tracking-tight font-serif">Gestion des Articles</h2>
            <p class="text-sm text-gray-400 mt-1">
                <?= $user['role'] === 'admin' ? 'Visualisez l\'ensemble des publications du blog.' : 'Gérez, rédigez et organisez vos publications personnelles.' ?>
            </p>
        </div>

        <!-- Bouton de rédaction exclusif à l'auteur -->
        <!-- Bouton d'action fidèle à votre maquette -->
        <?php if ($user['role'] === 'auteur'): ?>
            <button onclick="toggleArticleModal(true)" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl shadow-sm tracking-wide transition">
                + rédiger article
            </button>
        <?php endif; ?>

    </div>


    <!-- 🔍 ZONE FILTRER LES ARTICLES (STYLE MODERNE DE VOTRE MAQUETTE) -->
    <form action="<?= WEBROOT ?>" method="GET" enctype="multipart/form-data" class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm flex flex-col sm:flex-row items-center justify-start gap-4">
        <!-- Piliers obligatoires pour votre routeur global -->
        <input type="hidden" name="controller" value="article">
        <input type="hidden" name="action" value="index">

        <span class="text-sm font-bold text-gray-700 shrink-0"><i class="fas fa-filter text-amber-500 mr-1"></i> Filtrer</span>

        <!-- Menu Déroulant dynamique des catégories (Soumission automatique au clic !) -->
        <div class="w-full sm:w-64">
            <select name="id_categorie" onchange="this.form.submit()"
                class="w-full px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-xs focus:bg-white focus:border-amber-500 outline-none text-gray-500 font-semibold transition-all">
                <option value="0">Toutes les Catégories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id_categorie'] ?>" <?= ($current_categorie === (int)$cat['id_categorie']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <!-- GRILLE RESPONSIVE FIDÈLE À VOTRE MAQUETTE -->
    <?php if (!empty($articles)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            <?php foreach ($articles as $art): ?>
                <!-- CARTE ARTICLE -->
                <div class="bg-white rounded-3xl  shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-all group border-b-4 border-amber-500">

                    <!-- 1. ZONE IMAGE DYNAMIQUE -->
                    <div class="h-40 bg-gray-100 overflow-hidden relative shrink-0">
                        <!-- Simulation d'image par défaut basée sur la catégorie si aucune image n'est stockée -->
                        <?php
                        $imagePath = (!empty($art['image']) && file_exists(ROOT . 'public/uploads/' . $art['image']))
                            ? WEBROOT . 'uploads/' . $art['image']
                            : 'https://unsplash.com';
                        ?>
                        <img src="<?= $imagePath ?>"
                            alt="Illustration"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>

                    <!-- 2. CORPS DE LA CARTE -->
                    <div class="p-6 flex-1 flex flex-col justify-between space-y-4">

                        <!-- Catégorie & Date -->
                        <div class="flex items-center justify-between text-xs font-medium">
                            <span class="text-gray-400 font-semibold tracking-wide">
                                <?= htmlspecialchars($art['categorie_nom']) ?>
                            </span>
                            <span class="text-gray-400">
                                <!-- Calcule l'affichage relatif (ex: 2 days ago) ou date brute -->
                                <?= date('d M Y', strtotime($art['date_pub'])) ?>
                            </span>
                        </div>

                        <!-- Titre de l'article -->
                        <h3 class="text-xl font-bold text-gray-900 tracking-tight leading-snug group-hover:text-amber-500 transition-colors">
                            <?= htmlspecialchars($art['titre']) ?>
                        </h3>

                        <!-- Description / Contenu Tronqué -->
                        <p class="text-gray-500 text-xs leading-relaxed line-clamp-3">
                            <?= htmlspecialchars($art['description'] ?? $art['contenu']) ?>
                        </p>

                    </div>

                    <!-- 3. PIED DE LA CARTE (Auteur & Bouton d'action) -->
                    <div class="px-6 pb-6 pt-2 border-t border-gray-50 flex items-center justify-between shrink-0">

                        <!-- Profil Auteur -->
                        <div class="flex items-center space-x-2.5">
                            <div class="w-8 h-8 bg-amber-500/10 text-amber-600 font-extrabold rounded-full flex items-center justify-center text-xs uppercase border border-amber-500/20">
                                <?= substr($art['prenom'], 0, 1) . substr($art['nom'], 0, 1) ?>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-gray-700"><?= htmlspecialchars($art['prenom'] . ' ' . $art['nom']) ?></span>
                                <!-- AFFICHAGE DU SLUG TECHNIQUE -->
                                <span class="text-[9px] font-mono text-gray-400">slug: <?= htmlspecialchars($art['slug']) ?></span>
                            </div>
                        </div>
                        <!-- Lien interactif "Voir plus" -->
                        <a href="<?= WEBROOT ?>?controller=article&action=show&slug=<?= $art['slug'] ?>"
                            class="text-blue-500 hover:text-blue-600 font-bold text-xs inline-flex items-center gap-1.5 transition group/btn">
                            <span>Voir plus</span>
                            <i class="fas fa-arrow-right text-[10px] transform group-hover/btn:translate-x-1 transition-transform"></i>
                        </a>

                    </div>

                </div>
            <?php endforeach; ?>

        </div>
    <?php else: ?>
        <!-- Écran vide si aucun article en BDD -->
        <div class="bg-white p-12 rounded-3xl border border-gray-100 shadow-sm text-center max-w-xl mx-auto">
            <div class="inline-flex p-4 bg-gray-50 text-gray-300 rounded-full mb-4">
                <i class="fas fa-newspaper text-3xl"></i>
            </div>
            <h4 class="text-gray-700 font-bold text-lg mb-1">Aucun article disponible</h4>
            <p class="text-sm text-gray-400">Les publications rédigées s'afficheront sous forme de cartes sur cette page.</p>
        </div>
    <?php endif; ?>

</div>


<!-- =========================================================================
     FENÊTRE MODALE D'AJOUT D'ARTICLE (STRICTEMENT FIDÈLE À VOTRE MAQUETTE)
     ========================================================================= -->
<div id="articleModal" class="<?= ($openModal) ? 'flex' : 'hidden' ?> fixed inset-0 bg-black/50 items-center justify-center z-50 p-4 animate-fade-in">

    <div class="bg-white overflow-auto h-full w-full max-w-xl rounded-2xl shadow-2xl border border-gray-100 transform transition-all ">

        <!-- EN-TÊTE MODALE -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-extrabold text-gray-800">Ajout article</h3>
            <button onclick="toggleArticleModal(false)" class="text-gray-400 hover:text-gray-600 text-xl font-bold transition">✕</button>
        </div>

        <!-- BANDEAU ATTENTION OR/MARRON DE VOTRE IMAGE -->
        <div class="mx-6 mt-4 bg-amber-500/80 text-white p-4 rounded-xl flex items-start gap-3 shadow-sm">
            <div class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center text-xs font-serif italic shrink-0">i</div>
            <div>
                <h5 class="text-xs font-bold uppercase tracking-wider">Attention</h5>
                <p class="text-[11px] opacity-90 mt-0.5 font-medium">Veillez à remplir toutes les champs sans exception.</p>
            </div>
        </div>

        <!-- FORMULAIRE -->
        <form action="<?= WEBROOT ?>?controller=article&action=index" method="POST" class="p-6 space-y-4" novalidate>
            <input type="hidden" name="action_type" value="add_article">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Titre -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Titre</label>
                    <input type="text" name="titre" placeholder="Titre" value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>"
                        class="w-full px-3 py-2.5 bg-gray-50 border <?= isset($erreurs['titre']) ? 'border-red-400' : 'border-gray-200' ?> rounded-xl text-xs outline-none focus:bg-white focus:border-amber-500 font-medium">
                    <?php if (isset($erreurs['titre'])): ?><p class="text-red-500 text-[10px] font-bold mt-1"><?= $erreurs['titre'] ?></p><?php endif; ?>
                </div>
                <!-- Date de publication (Comme sur votre image) -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Date publication</label>
                    <input type="date" name="date_pub" value="<?= htmlspecialchars($_POST['date_pub'] ?? date('Y-m-to')) ?>"
                        class="w-full px-3 py-2.5 bg-gray-50 border <?= isset($erreurs['date_pub']) ? 'border-red-400' : 'border-gray-200' ?> rounded-xl text-xs outline-none focus:bg-white focus:border-amber-500 font-medium text-gray-500">
                    <?php if (isset($erreurs['date_pub'])): ?><p class="text-red-500 text-[10px] font-bold mt-1"><?= $erreurs['date_pub'] ?></p><?php endif; ?>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Description -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Description</label>
                    <input type="text" name="description" placeholder="Description courte..." value="<?= htmlspecialchars($_POST['description'] ?? '') ?>"
                        class="w-full px-3 py-2.5 bg-gray-50 border <?= isset($erreurs['description']) ? 'border-red-400' : 'border-gray-200' ?> rounded-xl text-xs outline-none focus:bg-white focus:border-amber-500 font-medium">
                    <?php if (isset($erreurs['description'])): ?><p class="text-red-500 text-[10px] font-bold mt-1"><?= $erreurs['description'] ?></p><?php endif; ?>
                </div>
                <!-- Catégorie (Select dynamique) -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Categorie</label>
                    <select name="id_categorie"
                        class="w-full px-3 py-2.5 bg-gray-50 border <?= isset($erreurs['id_categorie']) ? 'border-red-400' : 'border-gray-200' ?> rounded-xl text-xs outline-none focus:bg-white focus:border-amber-500 font-medium text-gray-500">
                        <option value="0">Choisir une catégorie</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id_categorie'] ?>" <?= (isset($_POST['id_categorie']) && (int)$_POST['id_categorie'] === (int)$cat['id_categorie']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($erreurs['id_categorie'])): ?><p class="text-red-500 text-[10px] font-bold mt-1"><?= $erreurs['id_categorie'] ?></p><?php endif; ?>
                </div>
            </div>

            <!-- Contenu (Le grand éditeur de texte de la maquette) -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Contenu</label>
                <textarea name="contents" rows="5" placeholder="ecrivez la .............."
                    class="w-full px-4 py-3 bg-gray-50 border <?= isset($erreurs['contenu']) ? 'border-red-400' : 'border-gray-200' ?> rounded-xl text-xs outline-none focus:bg-white focus:border-amber-500 font-medium resize-none"><?= htmlspecialchars($_POST['contents'] ?? '') ?></textarea>
                <?php if (isset($erreurs['contenu'])): ?><p class="text-red-500 text-[10px] font-bold mt-1"><?= $erreurs['contenu'] ?></p><?php endif; ?>
            </div>

            <!-- Champ Image / Photo ajouté juste au-dessus du bouton de soumission -->
            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Illustration de l'article (Photo)</label>
                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-200 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-3 pb-3">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-xl mb-1"></i>
                            <p class="text-[11px] text-gray-500 font-semibold">Cliquez pour choisir une photo</p>
                            <p class="text-[9px] text-gray-400">PNG, JPG ou JPEG</p>
                        </div>
                        <input type="file" name="photo" id="photo" class="hidden" accept="image/*">
                    </label>
                </div>
                <?php if (isset($erreurs['photo'])): ?>
                    <p class="text-red-500 text-[10px] font-bold mt-1"><i class="fas fa-exclamation-circle mr-1"></i><?= $erreurs['photo'] ?></p>
                <?php endif; ?>
            </div>


            <!-- BOUTON ENREGISTRE OR DE VOTRE IMAGE -->
            <div class="pt-2">
                <button type="submit" class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-xs rounded-xl shadow-md uppercase tracking-wider transition">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 📦 PETIT SCRIPT JAVASCRIPT OUVERTURE -->
<script>
    function toggleArticleModal(show) {
        const modal = document.getElementById('articleModal');
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    }
</script>