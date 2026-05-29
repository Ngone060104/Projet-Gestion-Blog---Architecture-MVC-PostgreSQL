<!-- view/categorie/listCategorie.php -->
<div class="space-y-6 w-full font-sans animate-fade-in">
    
    <!-- EN-TÊTE -->
    <div class="flex items-center justify-between border-b border-gray-100 pb-4 bg-white p-4 rounded-xl border border-gray-100 shadow-sm ">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-800">Gestion des Catégories</h2>
            <p class="text-xs text-gray-400 mt-1">Configurez les thèmes et rubriques disponibles pour les rédacteurs.</p>
        </div>
        <button onclick="toggleCatModal(true)" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl shadow-sm tracking-wide transition">
            + Nouvelle Catégorie
        </button>
    </div>

    <!-- TABLEAU DES CATÉGORIES -->
     <div class="bg-white rounded-lg  border border-gray-100 shadow-sm overflow-hidden mt-6">
     <div class="px-6 py-4  border-b border-gray-100">
        <h3 class="text-sm font-bold text-gray-800">Informations categories</h3>
    </div>
    <div class="bg-white rounded-t-xl border border-gray-100 shadow-sm overflow-hidden m-6">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left border-collapse min-w-[600px]">
                <thead>
                    <tr class="bg-[#C19E55] text-white text-xs font-bold uppercase tracking-wider">
                        <th class="py-3.5 px-6">ID</th>
                        <th class="py-3.5 px-4">Nom de la catégorie</th>
                        <th class="py-3.5 px-4">Description</th>
                        <th class="py-3.5 px-6 text-center">Articles associés</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-xs font-medium text-gray-600">
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-3.5 px-6 font-mono text-gray-400">CAT-0<?= htmlspecialchars($cat['id_categorie']) ?></td>
                                <td class="py-3.5 px-4 font-bold text-gray-800"><?= htmlspecialchars($cat['nom']) ?></td>
                                <td class="py-3.5 px-4 text-gray-400 max-w-xs truncate"><?= htmlspecialchars($cat['description'] ?? 'Aucune description') ?></td>
                                <td class="py-3.5 px-6 text-center">
                                    <span class="px-2.5 py-1 bg-gray-100 text-gray-700 font-bold rounded-full text-[10px]">
                                        <?= $cat['total_articles'] ?> article(s)
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="py-8 text-center text-gray-400 font-medium">Aucune catégorie configurée.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =========================================================================
     🚨 MODALE D'AJOUT DE CATÉGORIE (STYLE UNIFIÉ EBLOG)
     ========================================================================= -->
<div id="catModal" class="<?= ($openModal) ? 'flex' : 'hidden' ?> fixed inset-0 bg-black/50 items-center justify-center z-50 p-4 animate-fade-in">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all">
        
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-extrabold text-gray-800">Ajout Catégorie</h3>
            <button onclick="toggleCatModal(false)" class="text-gray-400 hover:text-gray-600 text-xl font-bold transition">✕</button>
        </div>

        <form action="<?= WEBROOT ?>?controller=categorie&action=index" method="POST" class="p-6 space-y-4" novalidate>
            <input type="hidden" name="action_type" value="add_categorie">

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Nom du thème</label>
                <input type="text" name="nom" placeholder="Ex: Intelligence Artificielle" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
                       class="w-full px-3 py-2.5 bg-gray-50 border <?= isset($erreurs['nom']) ? 'border-red-400' : 'border-gray-200' ?> rounded-xl text-xs outline-none focus:bg-white focus:border-amber-500 font-medium transition-all">
                <?php if (isset($erreurs['nom'])): ?><p class="text-red-500 text-[10px] font-bold mt-1"><i class="fas fa-exclamation-circle mr-1"></i><?= $erreurs['nom'] ?></p><?php endif; ?>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-700 mb-1">Description (Optionnelle)</label>
                <textarea name="description" rows="3" placeholder="Brève description de la thématique..."
                          class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs outline-none focus:bg-white focus:border-amber-500 font-medium resize-none transition-all"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-xs rounded-xl shadow-md uppercase tracking-wider transition">
                Créer la catégorie
            </button>
        </form>
    </div>
</div>

<script>
function toggleCatModal(show) {
    const modal = document.getElementById('catModal');
    if (show) { modal.classList.remove('hidden'); modal.classList.add('flex'); }
    else { modal.classList.remove('flex'); modal.classList.add('hidden'); }
}
</script>
