<?php
// Configuration de la connexion PostgreSQL

function getPDO(){
    static $pdo = null; 

    if ($pdo === null) {
        try {
            // Configuration standard PostgreSQL
            $dsn = "pgsql:host=127.0.0.1;port=5432;dbname=gestion_blog";
            
            $pdo = new PDO(
                $dsn,
                "postgres", 
                "postgres", 
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    // FORCE PHP à utiliser une connexion persistante pour court-circuiter Apache
                    PDO::ATTR_PERSISTENT => true 
                ]
            );
        } catch(PDOException $e) {
            die("Erreur de connexion PostgreSQL : " . $e->getMessage());
        }
    }
    return $pdo;
}



function closePDO() {
    // Note : pour détruire proprement une instance statique en PHP, 
    // on cible la variable statique interne pour libérer la mémoire.
    static $pdo = null;
    $pdo = null;
}

function executeSelect($sql,$params=[],$one=false){
     $pdo = getPDO();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    if($one){
        return $stmt->fetch();
    }else{
    return $stmt->fetchAll();
}
}

function executeUpdate($sql, $params = []){
    $pdo = getPDO();
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}

function executeDelete($sql, $params = []){
    $pdo = getPDO();
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}
