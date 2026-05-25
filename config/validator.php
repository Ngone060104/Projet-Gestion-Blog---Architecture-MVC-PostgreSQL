<?php
//verifier champs vides
function isEmpty(string $key, ?string $value, array &$errors, string $msg = "Ce champ est obligatoire"): void {
    if ($value === null || empty(trim($value))) {
        $errors[$key] = $msg;
    }
}
// 4. Vérifie l'adresse Email avec une Regex (Plus stricte que filter_var)
function isMailRegex(string $value): bool {
    // Motif standard pour valider la structure texte@domaine.extension
    $pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
    return (bool) preg_match($pattern, trim($value));
}

// 6. Indique si le tableau d'erreurs est vide (Inchangé)
function validate(array $errors): bool {
    return count($errors) === 0;
}



