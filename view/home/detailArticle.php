<!-- view/home/detailArticle.php -->
<div class="max-w-4xl mx-auto px-6 py-12 space-y-12 font-sans animate-fade-in">

    <!-- Bouton Retour -->
    <div>
        <a href="<?= WEBROOT ?>" class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-amber-500 transition uppercase tracking-wider">
            <i class="fas fa-arrow-left"></i> Retour à l'accueil
        </a>
    </div>


    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden flex flex-col md:flex-row gap-6 p-6">
        <div class="w-full md:w-1/3 h-52 bg-gray-50 rounded-2xl overflow-hidden shrink-0">
            <?php
            $imagePath = (!empty($article['image']) && file_exists(ROOT . 'public/uploads/' . $article['image']))
                ? WEBROOT . 'uploads/' . $article['image']
                : 'https://unsplash.com';
            ?>
            <img src="<?= $imagePath ?>" alt="Illustration" class="w-full h-full object-cover">
        </div>

        <div class="flex flex-col justify-between py-2 space-y-4">
            <div class="space-y-2">
                <span class="px-2.5 py-1 bg-amber-500/10 text-amber-600 rounded-full text-[10px] font-bold uppercase tracking-wider">
                    <?= htmlspecialchars($article['categorie_nom']) ?>
                </span>
                <h1 class="text-2xl md:text-3xl font-black text-gray-900 tracking-tight font-serif leading-tight mt-2">
                    <?= htmlspecialchars($article['titre']) ?>
                </h1>
            </div>

            <div class="flex flex-wrap items-center gap-6 text-xs text-gray-400 font-medium">
                <div class="flex items-center gap-1.5">
                    <div class="w-5 h-5 bg-amber-500 text-white rounded-full flex items-center justify-center text-[9px] font-bold uppercase">
                        <?= substr($article['prenom'], 0, 1) ?>
                    </div>
                    <span>Par : <strong class="text-gray-700"><?= htmlspecialchars($article['prenom'] . ' ' . $article['nom']) ?></strong></span>
                </div>
                <div class="flex items-center gap-1.5">
                    <i class="far fa-calendar-alt"></i>
                    <span>Publié le : <?= date('d M Y', strtotime($article['date_pub'])) ?></span>

                    <!-- LE BOUTON À REPRENDRE ET SAISIR (Ligne 51 de view/home/detailArticle.php) -->
                    <?php if (isset($user)): ?>
                        <button onclick="openReportModal(<?= $com['id_comment'] ?>, '<?= htmlspecialchars(addslashes($com['prenom'] . ' ' . $com['nom'])) ?>')"
                            class="text-gray-300 hover:text-red-500 transition-colors text-[11px] ml-2"
                            title="Signaler ce commentaire">
                            <i class="fas fa-flag"></i> Signaler
                        </button>
                    <?php endif; ?>


                </div>
            </div>
        </div>
    </div>

    <!-- TEXTE DE L'ARTICLE -->
    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm space-y-6">
        <p class="text-sm font-bold text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-100/50 italic leading-relaxed">
            <?= htmlspecialchars($article['description']) ?>
        </p>
        <div class="text-sm text-gray-600 leading-relaxed font-medium whitespace-pre-line">
            <?= htmlspecialchars($article['contenu']) ?>
        </div>
    </div>

    <!-- ZONE : ESPACE COMMENTAIRES -->
    <div class="space-y-6 border-t border-gray-100 pt-8">
        <h3 class="text-lg font-black text-gray-900 tracking-tight flex items-center gap-2">
            <i class="far fa-comments text-amber-500 text-xl"></i>
            <span>Espace de discussion (<?= count($comments) ?>)</span>
        </h3>

        <!-- Formuliare pour rédiger (Masqué si pas connecté) -->
        <?php if (isset($user)): ?>
            <form action="<?= WEBROOT ?>?controller=article&action=showPublic&slug=<?= $article['slug'] ?>" method="POST" class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm space-y-4" novalidate>
                <input type="hidden" name="action_type" value="add_comment">

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Participer au débat :</label>
                    <textarea name="commentaire_texte" rows="3" placeholder="Écrivez votre commentaire ici de manière respectueuse..."
                        class="w-full px-4 py-3 bg-gray-50 border <?= isset($erreurs['commentaire_texte']) ? 'border-red-400' : 'border-gray-100' ?> rounded-xl text-xs outline-none focus:bg-white focus:border-amber-500 font-medium resize-none transition-all"></textarea>
                    <?php if (isset($erreurs['commentaire_texte'])): ?><p class="text-red-500 text-[10px] font-bold mt-1"><?= $erreurs['commentaire_texte'] ?></p><?php endif; ?>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition shadow-md shadow-amber-500/10">
                        Envoyer le commentaire
                    </button>
                </div>
            </form>
        <?php else: ?>
            <div class="bg-amber-50/50 border border-amber-200/60 p-4 rounded-2xl text-center text-xs text-amber-700 font-medium">
                Vous devez <a href="<?= path('auth', 'login') ?>" class="font-bold underline hover:text-amber-900">vous connecter</a> pour laisser un commentaire sur cet article.
            </div>
        <?php endif; ?>

        <!-- Liste des commentaires réels sous forme de double bulle -->
        <?php if (!empty($comments)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach ($comments as $com): ?>
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm space-y-3">
                        <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                            <span class="text-xs font-bold text-gray-800"><?= htmlspecialchars($com['prenom'] . ' ' . $com['nom']) ?></span>
                            <span class="text-[10px] text-gray-400 font-mono"><?= date('d/m à H:i', strtotime($com['date'])) ?></span>
                        </div>
                        <p class="text-xs text-gray-500 font-medium italic leading-relaxed">
                            " <?= htmlspecialchars($com['contenu']) ?> "
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div>


<!-- =========================================================================
     🚨 MODALE DE SIGNALEMENT POUR LE LECTEUR (STYLE UNIFIÉ EBLOG)
     ========================================================================= -->
<div id="reportModal" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50 p-4 animate-fade-in">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all p-6 space-y-4">

        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
            <h3 class="text-sm font-black text-gray-800 uppercase tracking-wider">Signaler un commentaire</h3>
            <button onclick="closeReportModal()" class="text-gray-400 hover:text-gray-600 text-sm font-bold">✕</button>
        </div>

        <p class="text-xs text-gray-400">
            Vous signalez le commentaire de : <span id="reportedAuthor" class="font-bold text-gray-700"></span>.
        </p>

        <form action="<?= WEBROOT ?>?controller=article&action=showPublic&slug=<?= $article['slug'] ?>" method="POST" class="space-y-4">
            <input type="hidden" name="action_type" value="report_comment">
            <input type="hidden" name="id_commentaire" id="reportedCommentId" value="">

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-2">Motif du signalement :</label>
                <select name="motif" 
                    class="w-full px-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl text-xs focus:bg-white focus:border-amber-500 outline-none text-gray-600 font-semibold">
                    <option value="Propos injurieux ou haineux">Propos injurieux ou haineux</option>
                    <option value="Contenu publicitaire / Spam">Contenu publicitaire / Spam</option>
                    <option value="Harcèlement ou intimidation">Harcèlement ou intimidation</option>
                    <option value="Fausses informations (Fake News)">Fausses informations (Fake News)</option>
                </select>
            </div>

            <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white font-extrabold text-xs rounded-xl shadow-md uppercase tracking-wider transition">
                Envoyer le signalement
            </button>
        </form>
    </div>
</div>

<script>
    function openReportModal(commentId, authorName) {
        const modal = document.getElementById('reportModal');
        document.getElementById('reportedCommentId').value = commentId;
        document.getElementById('reportedAuthor').textContent = authorName;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeReportModal() {
        const modal = document.getElementById('reportModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>