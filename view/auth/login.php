<!-- view/auth/login.php -->
<div class="w-full max-w-md bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
    
    <!-- Entête de la carte de connexion -->
    <div class="text-center mb-8">
        <div class="inline-flex p-3 bg-amber-500/10 text-amber-500 rounded-2xl mb-3">
            <i class="fas fa-feather-alt text-2xl"></i>
        </div>
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight font-serif">EBLOG</h1>
        <p class="text-sm text-gray-400 mt-1">Connectez-vous à votre espace de gestion</p>
    </div>

    <!-- Alerte d'erreur globale (Compte introuvable ou banni) -->
    <?php if (isset($erreurs['global'])): ?>
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm font-medium flex items-center gap-2">
            <i class="fas fa-exclamation-circle text-red-500"></i>
            <span><?= $erreurs['global'] ?></span>
        </div>
    <?php endif; ?>

    <!-- Formulaire d'authentification centralisé en POST -->
    <form action="<?= WEBROOT ?>" method="POST" class="space-y-5" novalidate>
        
        <!-- Vos inputs cachés obligatoires pour guider votre routeur core/route.php -->
        <input type="hidden" name="controller" value="auth">
        <input type="hidden" name="action" value="login">
        
        <!-- Champ Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Adresse Email</label>
            <input type="text" name="email" id="email" 
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                placeholder="Ex: astou@blog.com"
                class="w-full px-4 py-3 rounded-xl border <?= isset($erreurs['email']) ? 'border-red-400 focus:ring-red-200' : 'border-gray-200 focus:border-amber-500' ?> focus:ring-4 outline-none transition text-gray-700 font-medium">
            <?php if (isset($erreurs['email'])): ?>
                <p class="text-red-500 text-xs mt-1 font-medium"><i class="fas fa-exclamation-circle mr-1"></i><?= $erreurs['email'] ?></p>
            <?php endif; ?>
        </div>

        <!-- Champ Mot de passe -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Mot de passe</label>
            <input type="password" name="password" id="password" 
                placeholder="••••••••"
                class="w-full px-4 py-3 rounded-xl border <?= isset($erreurs['password']) ? 'border-red-400 focus:ring-red-200' : 'border-gray-200 focus:border-amber-500' ?> focus:ring-4 outline-none transition text-gray-700 font-medium">
            <?php if (isset($erreurs['password'])): ?>
                <p class="text-red-500 text-xs mt-1 font-medium"><i class="fas fa-exclamation-circle mr-1"></i><?= $erreurs['password'] ?></p>
            <?php endif; ?>
        </div>

        <!-- Bouton de soumission principal -->
        <button type="submit" class="w-full py-3.5 bg-gray-900 hover:bg-gray-800 text-white font-bold rounded-xl shadow-lg shadow-gray-200 transition transform hover:-translate-y-0.5 active:translate-y-0 tracking-wide">
            Se connecter
        </button>
    </form>
</div>
