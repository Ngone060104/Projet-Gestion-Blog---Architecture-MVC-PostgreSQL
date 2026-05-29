<div class="space-y-6 w-full font-sans animate-fade-in">

    <div class="border-b border-gray-100 pb-4 bg-white p-4 rounded-xl border border-gray-100 shadow-sm ">
        <h2 class="text-2xl font-extrabold text-gray-800">Modération des Commentaires</h2>
        <p class="text-xs text-gray-400 mt-1">Gérez les espaces de discussion et bannissez les lecteurs abusifs.</p>
    </div>

    <?php if (!empty($comments)): ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <?php foreach ($comments as $c): ?>
                <!-- CARTE COMMENTAIRE BLANCHE ARRONDIE -->
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex flex-col justify-between space-y-4 transition-all hover:shadow-md">

                    <!-- En-tête de la carte : Titre de l'article & Nom du Lecteur -->
                    <div class="flex items-start justify-between gap-4">
                        <div class="space-y-1">
                            <!-- Titre de l'article -->
                            <h4 class="text-sm font-bold text-gray-900 tracking-tight">
                                <?= htmlspecialchars($c['article_titre'] ?? 'Innovation Technologique') ?>
                            </h4>
                        </div>

                        <!-- Nom du Lecteur + Icône Statut -->
                        <div class="flex items-center space-x-1.5 shrink-0">
                            <span class="text-xs font-bold text-gray-700">
                                <?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?>
                            </span>
                            <!-- Petit icône de statut (Crayon/Statut comme sur votre maquette) -->
                            <i class="fas fa-pen text-[10px] <?= $c['statut_lecteur'] === 'estBanni' ? 'text-red-400' : 'text-gray-300' ?>"></i>
                        </div>
                    </div>

                    <!-- Corps de la carte : Contenu du commentaire textuel -->
                    <div class="text-[11px] text-gray-400 font-medium leading-relaxed min-h-[48px]">
                        <?= htmlspecialchars($c['contenu']) ?>
                    </div>

                    <!-- Pied de la carte : Alignement des boutons d'actions en bas à droite -->
                    <!-- Remplacer les deux boutons du bas de la carte par ces éléments sécurisés -->
                    <div class="flex items-center justify-end gap-2.5 pt-2">

                        <!-- 🔴 Bouton Déclencheur Modale Supprimer -->
                        <button type="button"
                            onclick="openDeleteCommentModal(<?= $c['id_comment'] ?>)"
                            class="px-4 py-1.5 bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold uppercase tracking-wider rounded-lg transition shadow-sm">
                            Supprimer
                        </button>

                        <!-- 🔵 Bouton Déclencheur Modale Bannir -->
                        <button type="button"
                            onclick="openBanCommentModal(<?= $c['id_user'] ?>, '<?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?>', '<?= $c['statut_lecteur'] ?>')"
                            class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold uppercase tracking-wider rounded-lg transition shadow-sm">
                            <?= $c['statut_lecteur'] === 'estBanni' ? 'Débannir' : 'Bannir' ?>
                        </button>

                    </div>


                </div>
            <?php endforeach; ?>

        </div>
    <?php else: ?>
        <!-- Écran de secours si la table PostgreSQL est vide -->
        <div class="bg-white p-12 rounded-3xl border border-gray-100 shadow-sm text-center max-w-md mx-auto mt-8">
            <div class="inline-flex p-4 bg-gray-50 text-gray-300 rounded-full mb-3">
                <i class="fas fa-comments text-2xl"></i>
            </div>
            <h4 class="text-gray-700 font-bold text-sm mb-1">Aucun commentaire</h4>
            <p class="text-xs text-gray-400">Les réactions des lecteurs s'afficheront ici sous forme de cartes.</p>
        </div>
    <?php endif; ?>
</div>

<!-- =========================================================================
     🛑 1. MODALE PERSONNALISÉE : CONFIRMATION DE SUPPRESSION DE COMMENTAIRE
     ========================================================================= -->
<div id="deleteCommentModal" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50 p-4 animate-fade-in">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-6 text-center transform transition-all border border-gray-100 space-y-5">
        <div class="flex justify-center">
            <div class="w-14 h-14 bg-red-600 rounded-full flex items-center justify-center text-white text-2xl font-extrabold shadow-md shadow-red-600/20">
                !
            </div>
        </div>
        <div>
            <h4 class="text-lg font-extrabold text-gray-900 tracking-tight">Supprimer le commentaire ?</h4>
            <p class="text-xs text-gray-500 font-medium mt-2 px-2 leading-relaxed">
                Cette action retirera définitivement le commentaire sélectionné du blog.
            </p>
        </div>
        <div class="flex items-center justify-end gap-3 pt-2">
            <button onclick="closeDeleteCommentModal()" class="px-5 py-2 bg-gray-300 hover:bg-gray-400 text-white font-bold rounded-xl text-[11px] uppercase tracking-wide transition shadow-sm">
                annuler
            </button>
            <a id="confirmDeleteCommentBtn" href="#" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-[11px] uppercase tracking-wide transition shadow-md shadow-red-600/10">
                Supprimer
            </a>
        </div>
    </div>
</div>

<!-- =========================================================================
     ⚠️ 2. MODALE PERSONNALISÉE : CONFIRMATION DE BANNISSEMENT / DÉBANNISSEMENT
     ========================================================================= -->
<div id="banCommentModal" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50 p-4 animate-fade-in">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-6 text-center transform transition-all border border-gray-100 space-y-5">
        <div class="flex justify-center">
            <div id="banIconContainer" class="w-14 h-14 rounded-full flex items-center justify-center text-white text-2xl font-extrabold shadow-md">
                ?
            </div>
        </div>
        <div>
            <h4 class="text-lg font-extrabold text-gray-900 tracking-tight" id="banModalTitle">Modifier le statut ?</h4>
            <p class="text-xs text-gray-500 font-medium mt-2 px-2 leading-relaxed">
                Êtes-vous sûr de vouloir modifier les droits d'accès de l'utilisateur <br>
                <span id="banReaderName" class="font-bold text-gray-800"></span> ?
            </p>
        </div>
        <div class="flex items-center justify-end gap-3 pt-2">
            <button onclick="closeBanCommentModal()" class="px-5 py-2 bg-gray-300 hover:bg-gray-400 text-white font-bold rounded-xl text-[11px] uppercase tracking-wide transition shadow-sm">
                annuler
            </button>
            <a id="confirmBanCommentBtn" href="#" class="px-5 py-2 text-white font-bold rounded-xl text-[11px] uppercase tracking-wide transition shadow-md">
                Confirmer
            </a>
        </div>
    </div>
</div>

<script>
// --- FONCTIONS MODALE SUPPRESSION ---
function openDeleteCommentModal(commentId) {
    const modal = document.getElementById('deleteCommentModal');
    // Construction de la route d'effacement vers votre contrôleur existant
    document.getElementById('confirmDeleteCommentBtn').href = "<?= WEBROOT ?>?controller=comment&action=delete&id=" + commentId;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteCommentModal() {
    const modal = document.getElementById('deleteCommentModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}

// --- FONCTIONS MODALE BANNISSEMENT ---
function openBanCommentModal(userId, fullName, currentStatus) {
    const modal = document.getElementById('banCommentModal');
    const iconContainer = document.getElementById('banIconContainer');
    const title = document.getElementById('banModalTitle');
    const confirmBtn = document.getElementById('confirmBanCommentBtn');
    
    // Injecter le nom complet du lecteur
    document.getElementById('banReaderName').innerText = fullName;
    
    // Personnaliser les styles de la modale en fonction de l'état actuel pour guider l'admin
    if (currentStatus === 'estBanni') {
        title.innerText = "Débannir le lecteur ?";
        iconContainer.className = "w-14 h-14 bg-green-600 rounded-full flex items-center justify-center text-white text-2xl font-extrabold shadow-md shadow-green-600/20";
        confirmBtn.className = "px-5 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl text-[11px] uppercase tracking-wide transition shadow-md";
    } else {
        title.innerText = "Bannir le lecteur ?";
        iconContainer.className = "w-14 h-14 bg-amber-500 rounded-full flex items-center justify-center text-white text-2xl font-extrabold shadow-md shadow-amber-500/20";
        confirmBtn.className = "px-5 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-[11px] uppercase tracking-wide transition shadow-md";
    }
    
    // Liaison avec la méthode existante de votre contrôleur (action=toggleBan)
    confirmBtn.href = "<?= WEBROOT ?>?controller=comment&action=toggleBan&id_user=" + userId + "&status=" + currentStatus;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeBanCommentModal() {
    const modal = document.getElementById('banCommentModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}
</script>
