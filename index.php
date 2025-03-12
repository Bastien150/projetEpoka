<?php
session_start();
const BASE_URL = "http://localhost/projetEpoka";
$route = $_GET['route'] ?? 'login';
require_once __DIR__ . '/app/controller/loginController.php';
require_once __DIR__ . '\app\model\database.php';

switch ($route) {
    case 'login':
        //Déconnection
        deconnecter();
       
        //si on a envoyer le formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['utilisateur'] ?? '';
            $password = $_POST['password'] ?? '';

            login($username, $password);
            if(isset($_SESSION['user'])){
                echo $_SESSION['user'];
            }

            if (isLoggedIn()) {
                header('Location: ' . BASE_URL . '/index.php?route=validation');
            } else {
                $_SESSION['erreur'] = "Mauvais utilisateur ou mot de passe";
            }
        }
        require_once __DIR__ . '/app/vue/login.php';
        break;

    case 'validation':
        /* vérifier si connecter sinon login */
        if (!isLoggedIn()) {
            $_SESSION['erreur'] = "Veuillez vous connecter avant ...";
            header('Location: ' . BASE_URL . '/index.php?route=login');
        }

        require_once __DIR__ . '/app/vue/validation.php';
        exit;

    case 'frais':
        /* vérifier si connecter sinon login */
        if (!isLoggedIn()) {
            $_SESSION['erreur'] = "Veuillez vous connecter avant ...";
            header('Location: ' . BASE_URL . '/index.php?route=login');
        }

        require_once __DIR__ . '/app/vue/frais.php';
        exit;

    case 'parametre':
        /* vérifier si connecter sinon login */
        if (!isLoggedIn()) {
            $_SESSION['erreur'] = "Veuillez vous connecter avant ...";
            header('Location: ' . BASE_URL . '/index.php?route=login');
        }

        require_once __DIR__ . '/app/vue/parametre.php';
        exit;
}
