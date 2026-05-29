<!-- view/signalement/listSignalement.php -->
<div class="space-y-6 w-full font-sans animate-fade-in">
    
    <!-- En-tête -->
    <div class="border-b border-gray-100 p-5 bg-white rounded-2xl ">
        <h2 class="text-xl font-extrabold text-gray-800 tracking-tight">Signalements Reçus</h2>
    </div>

    <!-- Grille des signalements -->
    <?php if (!empty($signalements)): ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <?php foreach ($signalements as $s): ?>
                <!-- CARTE ALERTE SIGNALEMENT -->
                <div class="bg-white p-6 rounded-3xl border <?= $s['statut'] === 'En attente' ? 'border-red-100 bg-gradient-to-br from-white to-red-50/10' : 'border-gray-100' ?> shadow-sm flex flex-col justify-between space-y-4">
                    
                    <!-- En-tête de l'alerte -->
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <span class="text-[10px] font-bold uppercase tracking-wider text-red-500 bg-red-50 px-2 py-0.5 rounded-md">
                                Motif : <?= htmlspecialchars($s['motif']) ?>
                            </span>
                            <h4 class="text-xs font-bold text-gray-400 mt-2 font-mono">Article: <?= htmlspecialchars($s['article_titre']) ?></h4>
                        </div>
                        
                        <div class="text-right shrink-0">
                            <p class="text-xs font-bold text-gray-700">Par : <?= htmlspecialchars($s['lecteur_prenom'] . ' ' . $s['lecteur_nom']) ?></p>
                            <p class="text-[9px] text-gray-400 font-mono"><?= date('d/m H:i', strtotime($s['date_signalement'])) ?></p>
                        </div>
                    </div>

                    <!-- Message ciblé -->
                    <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100/50">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Commentaire incriminé :</p>
                        <p class="text-xs text-gray-600 italic font-serif">"<?= htmlspecialchars($s['commentaire_texte']) ?>"</p>
                    </div>

                    <!-- Boutons d'actions -->
                    <div class="flex items-center justify-between pt-2">
                        <!-- Badge de traitement -->
                        <span class="text-[10px] font-bold uppercase <?= $s['statut'] === 'En attente' ? 'text-amber-500 animate-pulse' : 'text-gray-400' ?>">
                            ● <?= htmlspecialchars($s['statut']) ?>
                        </span>

                        <div class="flex items-center gap-2">
                            <?php if ($s['statut'] === 'En attente'): ?>
                                <!-- Bouton Rejeter l'alerte (Gris) -->
                                <a href="<?= path('signalement', 'dismiss') ?>&id=<?= $s['id_signalement'] ?>" 
                                   class="px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-[10px] font-bold uppercase tracking-wider rounded-lg transition">
                                    Innocenter / Rejeter
                                </a>
                                <!-- Bouton Supprimer le commentaire via le commentController (Rouge) -->
                                <a href="<?= path('comment', 'delete') ?>&id=<?= $s['id_comment'] ?>" 
                                   onclick="return confirm('Supprimer définitivement ce commentaire abusif ?')"
                                   class="px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold uppercase tracking-wider rounded-lg transition shadow-sm">
                                    Supprimer le message
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            <?php endforeach; ?>

        </div>
    <?php else: ?>
        <div class="bg-white p-12 rounded-3xl border border-gray-100 shadow-sm text-center max-w-md mx-auto mt-8">
            <div class="inline-flex p-4 bg-green-50 text-green-500 rounded-full mb-3">
                <i class="fas fa-shield-alt text-2xl"></i>
            </div>
            <h4 class="text-gray-700 font-bold text-sm mb-1">Espace totalement sécurisé</h4>
            <p class="text-xs text-gray-400">Aucun commentaire n'est actuellement signalé par la communauté.</p>
        </div>
    <?php endif; ?>

</div>
