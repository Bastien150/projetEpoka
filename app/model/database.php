<?php
function executeSQL($sql, $params = []) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=epoka_missions;charset=utf8", "root", "root");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    } catch(PDOException $e) {
        die("Erreur d'exécution de la requête : " . $e->getMessage());
    }
}