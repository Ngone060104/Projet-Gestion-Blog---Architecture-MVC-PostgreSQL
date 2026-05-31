<!-- view/user/listUser.php -->
<div class="space-y-6 w-full font-sans">
    <!-- EN-TÊTE + BOUTON AJOUTER (STYLE DE LA MAQUETTE) -->
    <div class="flex items-center justify-between border-b border-gray-100 p-5 bg-white rounded-lg ">
        <h2 class="text-xl font-extrabold text-gray-800">Liste des Utilisateurs</h2>
        <!-- Dans view/user/listUser.php (Ligne 7) -->
        <button onclick="toggleModal(true)" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs rounded-xl shadow-sm tracking-wide transition">
            + ajouter auteur
        </button>

    </div>

    <!-- ZONE FILTRER (STYLE DE LA MAQUETTE) -->
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

<!--  INFORMATIONS UTILISATEURS (TABLEAU DORÉ) -->
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
                                <!-- Dans le tbody de ta table, remplace l'ancien lien de suppression par ce bouton cliquable -->
                                <button type="button"
                                    onclick="openDeleteModal(<?= $u['id_user'] ?>, '<?= htmlspecialchars($u['prenom'] . ' ' . $u['nom']) ?>', '<?= $u['role'] ?>')"
                                    class="text-red-500 hover:text-red-700 text-sm transition transform hover:scale-110">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

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

<!-- =========================================================================
     FENÊTRE MODALE D'AJOUT D'AUTEUR 
     ========================================================================= -->
<div id="auteurModal" class="<?= ($openModal) ? 'flex' : 'hidden' ?> fixed inset-0 bg-black/50 items-center justify-center z-50 p-4 animate-fade-in">

    <div class="bg-white w-full max-w-xl rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all">

        <!-- EN-TÊTE MODALE -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-extrabold text-gray-800">Ajout auteur</h3>
            <button onclick="toggleModal(false)" class="text-gray-400 hover:text-gray-600 text-xl font-bold transition">✕</button>
        </div>

        <!-- BANDEAU ATTENTION OR/MARRON DE VOTRE MAQUETTE -->
        <div class="mx-6 mt-4 bg-amber-500 text-white p-4 rounded-xl flex items-start gap-3 shadow-sm">
            <div class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center text-xs font-serif italic shrink-0">i</div>
            <div>
                <h5 class="text-xs font-bold uppercase tracking-wider">Attention</h5>
                <p class="text-[11px] opacity-90 mt-0.5 font-medium">Veillez à remplir toutes les champs sans exception.</p>
            </div>
        </div>

        <!-- FORMULAIRE -->
        <form action="<?= WEBROOT ?>?controller=user&action=index" method="POST" class="p-6 space-y-4" novalidate>
            <input type="hidden" name="action_type" value="add_auteur">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nom -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Nom</label>
                    <input type="text" name="nom" placeholder="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>"
                        class="w-full px-3 py-2.5 bg-gray-50 border <?= isset($erreurs['nom']) ? 'border-red-400' : 'border-gray-200' ?> rounded-xl text-xs outline-none focus:bg-white focus:border-amber-500 font-medium">
                    <?php if (isset($erreurs['nom'])): ?>
                        <p class="text-red-500 text-[10px] font-bold mt-1 pl-1"><i class="fas fa-exclamation-circle mr-1"></i><?= $erreurs['nom'] ?></p>
                    <?php endif; ?>
                </div>
                <!-- Prénom -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Prenom</label>
                    <input type="text" name="prenom" placeholder="prenom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>"
                        class="w-full px-3 py-2.5 bg-gray-50 border <?= isset($erreurs['prenom']) ? 'border-red-400' : 'border-gray-200' ?> rounded-xl text-xs outline-none focus:bg-white focus:border-amber-500 font-medium">
                    <?php if (isset($erreurs['prenom'])): ?>
                        <p class="text-red-500 text-[10px] font-bold mt-1 pl-1"><i class="fas fa-exclamation-circle mr-1"></i><?= $erreurs['prenom'] ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Email -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" placeholder="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                        class="w-full px-3 py-2.5 bg-gray-50 border <?= isset($erreurs['email']) ? 'border-red-400' : 'border-gray-200' ?> rounded-xl text-xs outline-none focus:bg-white focus:border-amber-500 font-medium">
                    <?php if (isset($erreurs['email'])): ?>
                        <p class="text-red-500 text-[10px] font-bold mt-1 pl-1"><i class="fas fa-exclamation-circle mr-1"></i><?= $erreurs['email'] ?></p>
                    <?php endif; ?>
                </div>
                <!-- Password -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" placeholder="password" value="<?= htmlspecialchars($_POST['password'] ?? '') ?>"
                        class="w-full px-3 py-2.5 bg-gray-50 border <?= isset($erreurs['password']) ? 'border-red-400' : 'border-gray-200' ?> rounded-xl text-xs outline-none focus:bg-white focus:border-amber-500 font-medium">
                    <?php if (isset($erreurs['password'])): ?>
                        <p class="text-red-500 text-[10px] font-bold mt-1 pl-1"><i class="fas fa-exclamation-circle mr-1"></i><?= $erreurs['password'] ?></p>
                    <?php endif; ?>
                </div>
            </div>



            <div class="pt-2">
                <button type="submit" class="w-full py-3 bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-xs rounded-xl shadow-md uppercase tracking-wider transition">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<!-- =========================================================================
     FENÊTRE MODALE DE CONFIRMATION DE SUPPRESSION (STRICTEMENT FIDÈLE À LA MAQUETTE)
     ========================================================================= -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/50 items-center justify-center z-50 p-4 animate-fade-in">

    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-6 text-center transform transition-all border border-gray-100 space-y-6">

        <!-- Rond Rouge avec le point d'exclamation de ta maquette -->
        <div class="flex justify-center">
            <div class="w-16 h-16 bg-amber-500 rounded-full flex items-center justify-center text-white text-3xl font-extrabold shadow-md shadow-red-500/20">
                <i class="fas fa-exclamation-circle"></i>
            </div>
        </div>

        <!-- Titre dynamique selon le rôle de la ligne -->
        <div>
            <h4 class="text-xl font-extrabold text-gray-900 tracking-tight" id="deleteModalTitle">Supprimer l' " + userRole + " ?</h4>
            <p class="text-sm text-gray-500 font-medium mt-3 px-4">
                Cette action entraînera la suppression de l'<span id="deleteUserRole">lecteur</span> <br>
                <span id="deleteUserName" class="font-bold text-gray-800"></span>.
            </p>
        </div>

        <!-- Boutons d'Action alignés côte à côte -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <!-- Bouton Annuler (Gris arrondi) -->
            <button onclick="closeDeleteModal()" class="px-5 py-2.5 bg-gray-300 hover:bg-gray-400 text-white font-bold rounded-xl text-xs transition tracking-wide shadow-sm">
                annuler
            </button>
            <!-- Bouton Supprimer (Rouge vif) -->
            <a id="deleteConfirmBtn" href="#" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-xs transition tracking-wide shadow-md shadow-amber-600/10">
                Supprimer
            </a>
        </div>
    </div>
</div>


<script>
    function toggleModal(show) {
        const modal = document.getElementById('auteurModal');
        if (show) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    }

    // Fonctions de contrôle de la modale de suppression
function openDeleteModal(userId, fullName, userRole) {
    const modal = document.getElementById('deleteModal');
    
    // 1. Adapter le titre selon le rôle (Auteur ou Lecteur)
    document.getElementById('deleteModalTitle').textContent = "Supprimer l' " + userRole + " ?";
    document.getElementById('deleteUserRole').textContent = userRole;
    
    // 2. Injecter le Prénom et le Nom récupérés de la ligne
    document.getElementById('deleteUserName').textContent = fullName;
    
    // 3. Construire le lien réel qui va appeler ton userController.php -> deleteAction
    document.getElementById('deleteConfirmBtn').href = "<?= WEBROOT ?>?controller=user&action=delete&id=" + userId;
    
    // 4. Afficher la modale proprement à l'écran
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}

</script>