<!-- view/user/listUser.php -->
<div class="space-y-6 w-full font-sans">

    <!-- EN-TÊTE DE LA PAGE -->



    <div class="flex items-center justify-between border-b border-gray-100 p-5 bg-white rounded-lg ">
        <h2 class="text-xl font-extrabold text-gray-800">Liste des Utilisateurs</h2>
        <button class="px-4 py-2 bg-[#C79B54] hover:bg-amber-600 text-white font-bold text-xs rounded-xl shadow-sm tracking-wide transition">
            + ajouter auteur
        </button>
    </div>

    <!-- 🔍 ZONE FILTRER (STYLE DE LA MAQUETTE) -->
    <form action="<?= WEBROOT ?>" method="GET" class="bg-white p-4 rounded-lg border border-gray-100 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <input type="hidden" name="controller" value="user">
        <input type="hidden" name="action" value="index">

        <span class="text-sm font-bold text-gray-700 shrink-0">Filtrer</span>

        <!-- Input Recherche par nom -->
        <div class="relative w-full sm:max-w-md">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-amber-500">
                <i class="fas fa-search text-xs"></i>
            </span>
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="search by name"
                class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-100 rounded-xl text-xs focus:bg-white focus:border-amber-500 outline-none transition">
        </div>

        <!-- Select Filtrer par rôle -->
        <div class="w-full sm:w-48">
            <select name="role" onchange="this.form.submit()"
                class="w-full px-3 py-2 bg-gray-50 border border-gray-100 rounded-xl text-xs focus:bg-white focus:border-amber-500 outline-none text-gray-500 font-medium">
                <option value="">Filtrer par Rôle</option>
                <option value="admin" <?= $current_role === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="auteur" <?= $current_role === 'auteur' ? 'selected' : '' ?>>Auteur</option>
                <option value="lecteur" <?= $current_role === 'lecteur' ? 'selected' : '' ?>>Lecteur</option>
            </select>
        </div>
        <div class="w-full sm:w-48">
            <select name="statut" onchange="this.form.submit()"
                class="w-full px-3 py-2 bg-gray-50 border border-gray-100 rounded-xl text-xs focus:bg-white focus:border-amber-500 outline-none text-gray-500 font-medium">
                <option value="">Tous les Statuts</option>
                <option value="actif" <?= (isset($current_statut) && $current_statut === 'actif') ? 'selected' : '' ?>>Actif</option>
                <option value="estBanni" <?= (isset($current_statut) && $current_statut === 'estBanni') ? 'selected' : '' ?>>Banni</option>
            </select>
        </div>
        </select>
</div>
</form>

<!-- 📊 INFORMATIONS UTILISATEURS (TABLEAU DORÉ) -->
<div class="bg-white rounded-lg  border border-gray-100 shadow-sm overflow-hidden mt-6">
    <div class="px-6 py-4  border-b border-gray-100">
        <h3 class="text-sm font-bold text-gray-800">Informations utilisateurs</h3>
    </div>

    <div class="overflow-x-auto w-full p-6">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <!-- En-tête Doré / Marron de votre maquette -->
            <thead>
                <tr class="bg-[#C79B54] text-white text-xs font-bold uppercase tracking-wider ">
                    <th class="py-3.5 px-6 rounded-l-2xl">ID</th>
                    <th class="py-3.5 px-4">Nom</th>
                    <th class="py-3.5 px-4">Prénom</th>
                    <th class="py-3.5 px-4">Email</th>
                    <th class="py-3.5 px-4">Rôle</th>
                    <th class="py-3.5 px-4">Statut</th>
                    <th class="py-3.5 px-6 text-center rounded-r-2xl">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-xs font-medium text-gray-600">
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $u): ?>
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-3.5 px-6 font-mono text-gray-400">00<?= htmlspecialchars($u['id_user']) ?></td>
                            <td class="py-3.5 px-4 font-bold text-gray-800"><?= htmlspecialchars(strtoupper($u['nom'])) ?></td>
                            <td class="py-3.5 px-4"><?= htmlspecialchars($u['prenom']) ?></td>
                            <td class="py-3.5 px-4 text-gray-500"><?= htmlspecialchars($u['email']) ?></td>
                            <td class="py-3.5 px-4">
                                <!-- Badge Pilote Vert ou Rouge selon le rôle -->
                                <span class="px-2.5 py-1 rounded-full border text-[10px] font-bold uppercase tracking-wider
                                        <?= $u['role'] === 'auteur' ? 'border-green-200 bg-green-50 text-green-600' : 'border-red-200 bg-red-50 text-red-500' ?>">
                                    <?= htmlspecialchars($u['role']) ?>
                                </span>
                            </td>
                            <!-- À insérer dans les colonnes du tableau <tr> -->
                            <td class="py-3.5 px-4">
                                <?php if ($u['statut_lecteur'] === 'estBanni'): ?>
                                    <span class="px-2.5 py-1 rounded-full border border-red-200 bg-red-50 text-red-600 text-[10px] font-bold uppercase tracking-wider inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span> Banni
                                    </span>
                                <?php else: ?>
                                    <span class="px-2.5 py-1 rounded-full border border-green-200 bg-green-50 text-green-600 text-[10px] font-bold uppercase tracking-wider inline-flex items-center gap-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Actif
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td class="py-3.5 px-6 text-center space-x-3">
                                <!-- Bouton Supprimer (Rouge) -->
                                <a href="<?= path('user', 'delete') ?>&id=<?= $u['id_user'] ?>"
                                    onclick="return confirm('Supprimer cet utilisateur ?')"
                                    class="text-red-500 hover:text-red-700 text-sm transition">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <!-- Bouton Voir (Bleu) -->
                                <button class="text-blue-500 hover:text-blue-700 text-sm transition">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400 font-medium">Aucun utilisateur trouvé.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>