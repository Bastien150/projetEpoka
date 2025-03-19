<?php
header('Content-Type: application/json');

// Active l'affichage des erreurs pour faciliter le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Paramètres de connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "epoka_missions";

// Fonction pour envoyer une réponse JSON et terminer le script
function sendJsonResponse($success, $message) {
    echo json_encode(["success" => $success, "message" => $message]);
    exit;
}

// Récupération des données POST
$dateDebut = $_POST['dateDebut'] ?? '';
$dateFin = $_POST['dateFin'] ?? '';
$noSalarie = $_POST['noSalarie'] ?? '';
$noVille = $_POST['noVille'] ?? '';

// Validation des champs obligatoires
if (empty($dateDebut) || empty($dateFin) || empty($noSalarie) || empty($noVille)) {
    sendJsonResponse(false, "Tous les champs sont obligatoires");
}

// Conversion en entiers
$noSalarie = intval($noSalarie);
$noVille = intval($noVille);

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    sendJsonResponse(false, "Erreur de connexion à la base de données: " . $conn->connect_error);
}

// Préparation de la requête SQL
$query = "INSERT INTO mission (Mis_NoSalarie, Mis_NoVille, Mis_DateDebut, Mis_DateFin) VALUES (?, ?, STR_TO_DATE(?, '%d/%m/%Y'), STR_TO_DATE(?, '%d/%m/%Y'))";
$stmt = $conn->prepare($query);

if (!$stmt) {
    sendJsonResponse(false, "Erreur lors de la préparation de la requête: " . $conn->error);
}

// Liaison des paramètres
$stmt->bind_param("iiss", $noSalarie, $noVille, $dateDebut, $dateFin);

// Exécution de la requête
if ($stmt->execute()) {
    sendJsonResponse(true, "Mission ajoutée avec succès");
} else {
    sendJsonResponse(false, "Erreur lors de l'exécution de la requête: " . $stmt->error);
}

// Fermeture de la requête et de la connexion
$stmt->close();
$conn->close();
?>
