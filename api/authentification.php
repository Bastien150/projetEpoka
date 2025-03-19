<?php
// Paramètres de connexion à la base de données
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "epoka_missions";

// Récupération des données POST
$no = $_POST['no'] ?? '';
$mdp = $_POST['mdp'] ?? '';

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Préparation de la requête SQL
$stmt = $conn->prepare("SELECT * FROM salarie WHERE Sal_No = ? AND Sal_MotDePasse = ?");
$stmt->bind_param("ss", $no, $mdp);

// Exécution de la requête
$stmt->execute();
$result = $stmt->get_result();

// Vérification du résultat
if ($result->num_rows > 0) {
    // Authentification réussie
    $user = $result->fetch_assoc();
    echo json_encode(array("success" => true, "message" => "Authentification réussie", "user" => $user));
} else {
    // Authentification échouée
    echo json_encode(array("success" => false, "message" => "Identifiants incorrects"));
}

$stmt->close();
$conn->close();
?>