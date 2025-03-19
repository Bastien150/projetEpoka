<?php 
/**
 * verifie si les identifiants sont correctent
 */
function login($userid, $pass){
    $sql = "SELECT * FROM salarie WHERE Sal_No = ?";
    $result = executeSQL($sql, [$userid]);
    $user = $result->fetch(PDO::FETCH_ASSOC);

    //verifie le mot de passe de l'utilisateur
    if(isset($user['Sal_MotDePasse']) && $user['Sal_MotDePasse'] == $pass){
        $_SESSION['user'] = $user;
    }else {
        if(isset($_SESSION['user'])){
            unset($_SESSION['user']);
        }
    }
}

/**
 * vérifie si la personne est connecté
 * @return boolean true si connecter sinon false
 */
function isLoggedIn(){
    if(isset($_SESSION['user']) && $_SESSION['user'] != null){
        return true;
    }
    return false; 
}

function deconnecter(){
    if(isset($_SESSION['user'])){
        unset($_SESSION['user']);
    }
}