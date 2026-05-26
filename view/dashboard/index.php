<!-- view/dashboard/index.php -->
<div class="max-w-6xl mx-auto space-y-8 animate-fade-in">
    
    <!-- Message de bienvenue chaleureux (Style EBLOG) -->
    <div class="mb-8 border-b border-gray-200 pb-4">
        <h1 class="text-3xl font-bold text-gray-800">Ravi de vous revoir, <?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?> !</h1>
        <p class="text-sm text-gray-500 mt-1">Voici le résumé de l'activité sur votre espace de gestion (Espace <?= ucfirst($user['role']) ?>)</p>
    </div>

    <!-- Gille des 4 statistiques adaptatives (Fidèle à ta maquette) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 bg-white p-6 rounded-2xl border border-gray-100 ">

        <!-- Carte 1 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center justify-between border-t-4 border-blue-900">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider"><?= $stats['case1_titre'] ?></p>
                <p class="text-3xl font-bold text-gray-800 mt-2"><?= $stats['case1_valeur'] ?></p>
            </div>
            <div class="rounded-xl text-xl flex items-center justify-center w-14 h-14 bg-blue-50 text-blue-500">
                <i class="<?= $stats['case1_icone'] ?>"></i>
            </div>
        </div>

        <!-- Carte 2 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm  flex items-center justify-between border-t-4 border-green-500">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider"><?= $stats['case2_titre'] ?></p>
                <p class="text-3xl font-bold text-gray-800 mt-2"><?= $stats['case2_valeur'] ?></p>
            </div>
            <div class="rounded-xl text-xl flex items-center justify-center w-14 h-14 bg-green-50 text-green-500">
                <i class="<?= $stats['case2_icone'] ?>"></i>
            </div>
        </div>

        <!-- Carte 3 -->
        <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center justify-between border-t-4 border-purple-500">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider"><?= $stats['case3_titre'] ?></p>
                <p class="text-3xl font-bold text-gray-800 mt-2"><?= $stats['case3_valeur'] ?></p>
            </div>
            <div class="rounded-xl text-xl flex items-center justify-center w-14 h-14 bg-purple-50 text-purple-500">
                <i class="<?= $stats['case3_icone'] ?>"></i>
            </div>
        </div>

        <!-- Carte 4 (La nouvelle carte ajoutée pour le total d'articles) -->
        <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center justify-between border-t-4 border-amber-500">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider"><?= $stats['case4_titre'] ?></p>
                <p class="text-3xl font-bold text-gray-800 mt-2"><?= $stats['case4_valeur'] ?></p>
            </div>
            <div class="rounded-xl text-xl flex items-center justify-center w-14 h-14 bg-amber-50 text-amber-500">
                <i class="<?= $stats['case4_icone'] ?>"></i>
            </div>
        </div>

    </div>

    <!-- 📉 SECTION INTEGRATION : LE GRAPHIQUE DE TA MAQUETTE -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Graphique en Bâtons -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <div class="mb-4">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Statistics</span>
                <h4 class="text-lg font-bold text-gray-800 mt-1">STATISTIQUES</h4>
            </div>

            <!-- Rendu des colonnes en Tailwind -->
            <div class="h-48 flex items-end justify-between gap-2 pt-4 px-2 border-b border-gray-100 relative">
                <div class="w-full flex flex-col items-center"><div class="w-full flex justify-center items-end gap-1 h-32"><div class="w-2 bg-purple-500 h-1/5 rounded-t"></div><div class="w-2 bg-green-600 h-3/5 rounded-t"></div><div class="w-2 bg-blue-400 h-4/5 rounded-t"></div></div><span class="text-[10px] font-bold text-gray-400 mt-2">MON</span></div>
                <div class="w-full flex flex-col items-center"><div class="w-full flex justify-center items-end gap-1 h-32"><div class="w-2 bg-purple-500 h-2/5 rounded-t"></div><div class="w-2 bg-green-600 h-1/5 rounded-t"></div><div class="w-2 bg-blue-400 h-3/5 rounded-t"></div></div><span class="text-[10px] font-bold text-gray-400 mt-2">TUE</span></div>
                <div class="w-full flex flex-col items-center bg-gray-50/80 rounded-t-xl pt-2"><div class="w-full flex justify-center items-end gap-1 h-32"><div class="w-2 bg-purple-500 h-3/5 rounded-t"></div><div class="w-2 bg-green-600 h-full rounded-t"></div><div class="w-2 bg-blue-400 h-2/5 rounded-t"></div></div><span class="text-[10px] font-bold text-gray-700 mt-2 mb-1">WED</span></div>
                <div class="w-full flex flex-col items-center"><div class="w-full flex justify-center items-end gap-1 h-32"><div class="w-2 bg-purple-500 h-2/5 rounded-t"></div><div class="w-2 bg-green-600 h-2/5 rounded-t"></div><div class="w-2 bg-blue-400 h-1/5 rounded-t"></div></div><span class="text-[10px] font-bold text-gray-400 mt-2">THU</span></div>
                <div class="w-full flex flex-col items-center"><div class="w-full flex justify-center items-end gap-1 h-32"><div class="w-2 bg-purple-500 h-1/5 rounded-t"></div><div class="w-2 bg-green-600 h-1/5 rounded-t"></div><div class="w-2 bg-blue-400 h-2/5 rounded-t"></div></div><span class="text-[10px] font-bold text-gray-400 mt-2">FRI</span></div>
                <div class="w-full flex flex-col items-center"><div class="w-full flex justify-center items-end gap-1 h-32"><div class="w-2 bg-purple-500 h-4/5 rounded-t"></div><div class="w-2 bg-green-600 h-3/5 rounded-t"></div><div class="w-2 bg-blue-400 h-3/5 rounded-t"></div></div><span class="text-[10px] font-bold text-gray-400 mt-2">SAT</span></div>
                <div class="w-full flex flex-col items-center"><div class="w-full flex justify-center items-end gap-1 h-32"><div class="w-2 bg-purple-500 h-4/5 rounded-t"></div><div class="w-2 bg-green-600 h-3/5 rounded-t"></div><div class="w-2 bg-blue-400 h-1/5 rounded-t"></div></div><span class="text-[10px] font-bold text-gray-400 mt-2">SUN</span></div>
            </div>
        </div>

        <!-- Catégories à droite -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center space-y-4">
            <button class="w-full py-2 border border-emerald-500 text-emerald-600 font-bold rounded-full text-xs bg-emerald-50/10">
                ● Tous les Catégories
            </button>
              <div class="space-y-4">
                <?php foreach ($categories as $cat): ?>
                    <div class="flex items-center justify-between text-sm py-2 border-b border-gray-50 last:border-0">
                        <div class="flex items-center gap-3 font-semibold text-gray-600">
                            <span class="w-3 h-3 rounded-full border-2 <?= $cat['color'] ?> inline-block"></span>
                            <span><?= htmlspecialchars($cat['nom']) ?></span>
                        </div>
                        <span class="font-bold text-gray-400">- <?= $cat['percent'] ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <!-- 🛠️ Section Accès Rapide adaptée pour le Blog -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-2">Accès Rapide</h3>
        <p class="text-sm text-gray-500 mb-4">Utilisez la barre latérale gauche ou les boutons ci-dessous pour gérer votre blog.</p>
        <div class="flex gap-4">
            <?php if ($user['role'] === 'admin'): ?>
                <a href="<?= path('comment', 'index') ?>" class="px-4 py-2 bg-gray-800 text-white font-medium rounded-lg text-sm hover:bg-gray-700 transition">
                    Modérer les commentaires
                </a>
                <a href="<?= path('signalement', 'index') ?>" class="px-4 py-2 border border-gray-300 text-gray-600 font-medium rounded-lg text-sm hover:bg-gray-50 transition">
                    Voir les signalements
                </a>
            <?php else: ?>
                <a href="<?= path('article', 'index') ?>" class="px-4 py-2 bg-gray-800 text-white font-medium rounded-lg text-sm hover:bg-gray-700 transition">
                    Rédiger un article
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
