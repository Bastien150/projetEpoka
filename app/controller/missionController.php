<?php 
/**
 * Récupère tout les mission qui ont comme responsable le user
 */
function getLastMissions(){
    $sql = "SELECT Mis_No, Sal_Nom, Sal_NoResponsable, Ag_NoVille, Sal_Prenom,Vil_Nom, Mis_DateDebut, Mis_DateFin, Mis_Validee, Mis_Remboursee
    FROM mission INNER JOIN salarie ON Mis_NoSalarie = Sal_No INNER JOIN ville ON Mis_NoVille = Vil_No INNER JOIN Agence ON Sal_NoAgence = Ag_No WHERE Sal_NoResponsable = ? ORDER BY Mis_DateFin";

    $result = executeSQL($sql, [$_SESSION['user']['Sal_NoResponsable']]);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}
/**
 * Permet de récupéré les missions des 
 */
function getMissionsById($idMission){
    //refaire la requete pour 30 jours trié par le derniers
    $sql = "SELECT * FROM mission  WHERE Mis_No = ?";

    $result = executeSQL($sql, [$idMission]);
    return $result->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère une agence par son id
 */
function getAgenceById($idAgence){
    $sql = "SELECT * FROM agence WHERE Ag_No = ?";

    $result = executeSQL($sql, [$idAgence]);
    return $result->fetch(PDO::FETCH_ASSOC);
}

/**
 * Récupère toute les agence
 */
function getAllAgence(){
    $sql = "SELECT * FROM agence";

    $result = executeSQL($sql, []);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Recupère une ville par son id
 */
function getVilleById($idVille){
    $sql = "SELECT * FROM ville WHERE Vil_No = ?";

    $result = executeSQL($sql, [$idVille]);
    return $result->fetch(PDO::FETCH_ASSOC);
}

/**
 * récupère un salarié par son id
 */
function getSalarieById($idSalarie){
    $sql = "SELECT * FROM salarie WHERE Sal_No = ?";

    $result = executeSQL($sql, [$idSalarie]);
    return $result->fetch(PDO::FETCH_ASSOC);
}

/**
 * Recupère toutes les villes
 */
function getAllVilles(){
    //refaire la requete pour 30 jours trié par le derniers
    $sql = "SELECT * FROM Ville";

    $result = executeSQL($sql, []);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Permet d'enregisterer en bdd la distance choisit
 */
function enregistrerDistance($departVille, $arriveVille, $distanceKm) {
    try {
        // Préparation de la requête SQL
        $sql = "INSERT IGNORE INTO distance (Dist_NoVille1, Dist_NoVille2, Dist_Km) VALUES (?, ?, ?)";
        
        // Exécution de la requête avec les paramètres
        $result = executeSQL($sql, [$departVille, $arriveVille, $distanceKm]);
        
        // Vérification du résultat
        if ($result && $result->rowCount() > 0) {
            return 'Ajout de la nouvelle distance';
        } else {
            return 'La distance existe déjà ou n\'a pas pu être insérée';
        }
    } catch (Exception $e) {
        return "Erreur de l'ajout de la distance: " . $e->getMessage();
    }
}



/** 
 * Récupere toutes les distances enregistré
 */
function getAllDistances(){
    $sql = "SELECT v1.Vil_Nom AS Ville1, v2.Vil_Nom AS Ville2, d.Dist_NoVille1, d.Dist_NoVille2, d.Dist_KM
    FROM distance d
    INNER JOIN ville v1 ON d.Dist_NoVille1 = v1.Vil_No
    INNER JOIN ville v2 ON d.Dist_NoVille2 = v2.Vil_No";

    $result = executeSQL($sql, []);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Modifie les paramètres par les nouveaux
 * @return string message succes / erreur
 */
function modifierParametre($remboursementKm, $hebergement){
    try{
        $sql = "UPDATE parametrage SET Par_IndemniteKm = ?, Par_IndemniteJour =  ?";

        $result = executeSQL($sql, [$remboursementKm, $hebergement]);
        $result->fetch(PDO::FETCH_ASSOC) ;

        return 'Paramètre mis à jours !';
    }catch(PDOException $e){
        return "Erreur lors de l'enregistrement du nouveau paramétrage";
    }
}

/**
 * Récupère tout les paramètre enregistré
 */
function getAllParametre(){
    $sql = "SELECT * FROM parametrage";

    $result = executeSQL($sql, []);
    return $result->fetch(PDO::FETCH_ASSOC);
}

/**
 * Permet de calculer le montant total de la mission
 * En prennant en compte km et durée en jour
 * @return string montant en euro ou ereur
 */
function montantMission($Mis_No){
    $param = getAllParametre();
    $mission = getMissionsById($Mis_No);
    $salarie = getSalarieById($mission['Mis_NoSalarie']);
    $agences = getAgenceById($salarie['Sal_NoAgence']);
    $distance = getDistance($agences['Ag_NoVille'], $mission['Mis_NoVille']) ;

    if($distance != false){
        $dateDepart = new DateTime($mission['Mis_DateDebut']); 
        $dateArrive = new DateTime($mission['Mis_DateFin']);

        // Calcule la différence entre les deux dates
        $interval = $dateDepart->diff($dateArrive);
        $totalJoursHeberger = $interval->days; 

        return ($distance['Dist_Km'] * $param['Par_IndemniteKm']) + ($totalJoursHeberger * $param['Par_IndemniteJour']) ." €";
    }else{
        return "Distance non-définie";
    }
}

/**
 * Renvoie toute les distance enregistré
 * @return array liste des distances
 */
function getDistance($depart, $arriver){
    $sql = "SELECT * FROM distance  WHERE Dist_NoVille1 = ? AND Dist_NoVille2 = ?";

    $result = executeSQL($sql, [$depart, $arriver]);
    return $result->fetch(PDO::FETCH_ASSOC);
}

/**
 * enregistre la validation la mission
 * @return string message succes / erreur 
 */
function validationMission($Mis_No){
    try{
        $sql = "UPDATE mission SET Mis_Validee = 1 where Mis_No=  ?";

        $result = executeSQL($sql, [$Mis_No]);
        $result->fetch(PDO::FETCH_ASSOC);
    
        return "La mission à bien été validée";
    }catch(PDOException $e){
        return "Erreur lors de la validation de la mission";
    }
}

/**
 * enregistre le remboursement de la mission
 * @return string message succes / erreur 
 */
function remboursementMission($missionNo){
    try{
        $sql = "UPDATE mission SET Mis_Remboursee = 1 where Mis_No=  ?";

        $result = executeSQL($sql, [$missionNo]);
        $result->fetch(PDO::FETCH_ASSOC);

        return "La mission à bien été remboursée !";
    }catch(PDOException $e){
        return "Erreur lors du remboursement de la mission";
    }
}