<?php
// Paramètres de connexion à la base de données
$host = "localhost";
$dbname = "epoka_missions";
$username = "root";
$password = "";

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer les données
    $sql = "SELECT Vil_No, Vil_Nom, Vil_CP FROM ville ORDER BY Vil_Nom ASC";

    // Préparation et exécution de la requête
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Récupération des résultats sous forme de tableau associatif
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Envoi des résultats au format JSON
    header('Content-Type: application/json');
    echo json_encode($results);

} catch (PDOException $e) {
    // Gestion des erreurs
    http_response_code(500); // Code d'erreur HTTP 500 (Erreur interne du serveur)
    echo json_encode(["error" => "Erreur de connexion : " . $e->getMessage()]);
}