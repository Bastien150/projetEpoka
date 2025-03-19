<?php
session_start();
const BASE_URL = "https://glubul/projetEpoka";
$route = $_GET['route'] ?? 'login';
require_once __DIR__ . '/app/controller/loginController.php';
require_once __DIR__ . '/app/controller/missionController.php';
require_once __DIR__ . '\app\model\database.php';

switch ($route) {
    case 'login':
        //Déconnection
        deconnecter();
       
        //si on a envoyer le formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['utilisateur'] ?? '';
            $password = $_POST['password'] ?? '';

            //vérification des identifiants
            login($username, $password);

            //vérif si l'user est connecté 
            if (isLoggedIn()) {
                header('Location: ' . BASE_URL . '/index.php?route=mission');
            } else {
                $_SESSION['erreur'] = "Mauvais utilisateur ou mot de passe";
            }
        }
        require_once __DIR__ . '/app/vue/login.php';
        exit;

    case 'mission':
        /* vérifier si connecter sinon login */
        if (!isLoggedIn()) {
            $_SESSION['erreur'] = "Veuillez vous connecter avant ...";
            header('Location: ' . BASE_URL . '/index.php?route=login');
        }
        
        /* traitement form validation */
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['validate'])){
            $missionNo = $_POST['Mis_No'];
            if(isset($missionNo)){
                $_SESSION['resultValitation'] = validationMission($missionNo);
            }
        }


        $missions = getLastMissions();
        require_once __DIR__ . '/app/vue/mission.php';
        exit;

    case 'frais':
        /* vérifier si connecter sinon login */
        if (!isLoggedIn()) {
            $_SESSION['erreur'] = "Veuillez vous connecter avant ...";
            header('Location: ' . BASE_URL . '/index.php?route=login');
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remboursementMission'])){
            $missionNo = $_POST['Mis_No'];
            if(isset($missionNo)){
                $_SESSION['resultRemboursement'] = remboursementMission($missionNo);
            }
        }

        $missions = getLastMissions();
        require_once __DIR__ . '/app/vue/frais.php';
        exit;

    case 'parametre':
        /* vérifier si connecter sinon login */
        if (!isLoggedIn()) {
            $_SESSION['erreur'] = "Veuillez vous connecter avant ...";
            header('Location: ' . BASE_URL . '/index.php?route=login');
        }
        
        /* traite formDistance et enregistre dans la bdd*/
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['distanceForm'])) {
            $departVille = $_POST['departVille'];
            $arriveVille = $_POST['arriverVille'];
            $distanceKm = $_POST['distanceKmVille'];

            $_SESSION['resultQuery'] = enregistrerDistance($departVille, $arriveVille, $distanceKm);
        }

        /* traite formRemboursement et enregistre dans la bdd*/
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['formRemboursement'])) {
            $remboursementKm = $_POST['remboursementKm'];
            $hebergement = $_POST['hebergement'];

            $_SESSION['resultQuery'] = modifierParametre($remboursementKm, $hebergement);
        }

        /* Récupere les paramètre, distances et villes enregistrer */
        $distances = getAllDistances();
        $villes = getAllVilles();
        $param = getAllParametre();
        $agences = getAllAgence();

        require_once __DIR__ . '/app/vue/parametre.php';
        exit;
}
