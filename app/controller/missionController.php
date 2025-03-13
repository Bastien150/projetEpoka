<?php 
//verifie si les identifiants sont correctent
function getLastMissions(){
    //refaire la requete pour 30 jours trié par le derniers
    $sql = "SELECT Mis_No, Sal_Nom, Sal_Prenom,Vil_Nom, Mis_DateDebut, Mis_DateFin, Mis_Validee, Mis_Remboursee
    FROM mission INNER JOIN salarie ON Mis_NoSalarie = Sal_No INNER JOIN ville ON Mis_NoVille = Vil_No ORDER BY Mis_DateFin";

    $result = executeSQL($sql, []);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function getMissionsById($idMission){
    //refaire la requete pour 30 jours trié par le derniers
    $sql = "SELECT * FROM mission  WHERE Mis_No = ?";

    $result = executeSQL($sql, [$idMission]);
    return $result->fetch(PDO::FETCH_ASSOC);
}

function getAgenceById($idAgence){
    $sql = "SELECT * FROM agence WHERE Ag_No = ?";

    $result = executeSQL($sql, [$idAgence]);
    return $result->fetch(PDO::FETCH_ASSOC);
}

function getSalarieById($idSalarie){
    $sql = "SELECT * FROM salarie WHERE Sal_No = ?";

    $result = executeSQL($sql, [$idSalarie]);
    return $result->fetch(PDO::FETCH_ASSOC);
}

function getAllVilles(){
    //refaire la requete pour 30 jours trié par le derniers
    $sql = "SELECT * FROM Ville";

    $result = executeSQL($sql, []);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Permet d'enregisterer en bdd la distance choisit
 */
function enregistrerDistance($departVille, $arriveVille, $distanceKm){
    $sql = "INSERT INTO distance (Dist_NoVille1, Dist_NoVille2, Dist_Km) VALUES (?, ?, ?)";

    $result = executeSQL($sql, [$departVille, $arriveVille, $distanceKm]);
    $result->fetch(PDO::FETCH_ASSOC);
    return 'Ajout de la nouvelle distance';
}

function getAllDistances(){
    $sql = "SELECT v1.Vil_Nom AS Ville1, v2.Vil_Nom AS Ville2, d.Dist_NoVille1, d.Dist_NoVille2, d.Dist_KM
FROM distance d
INNER JOIN ville v1 ON d.Dist_NoVille1 = v1.Vil_No
INNER JOIN ville v2 ON d.Dist_NoVille2 = v2.Vil_No
";

    $result = executeSQL($sql, []);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

function modifierParametre($remboursementKm, $hebergement){
    $sql = "UPDATE parametrage SET Par_IndemniteKm = ?, Par_IndemniteJour =  ?";

    $result = executeSQL($sql, [$remboursementKm, $hebergement]);
    $result->fetch(PDO::FETCH_ASSOC) ;
    return 'Paramètre mis à jours !';
}

function getAllParametre(){
    $sql = "SELECT * FROM parametrage";

    $result = executeSQL($sql, []);
    return $result->fetch(PDO::FETCH_ASSOC);
}

function montantMission($Mis_No){
    $param = getAllParametre();
    $mission = getMissionsById($Mis_No);
    $salarie = getSalarieById($mission['Mis_NoSalarie']);
    $agences = getAgenceById($salarie['Sal_NoAgence']);
    $distance = getDistance($agences['Ag_NoVille'], $mission['Mis_NoVille']) ;

    if($distance != false){
        $date1 = new DateTime($mission['Mis_DateDebut']); // Première date
        $date2 = new DateTime($mission['Mis_DateFin']); // Deuxième date

        // Calculer la différence entre les deux dates
        $interval = $date1->diff($date2);
        $joursHeberger = $interval->days; // Nombre total de jours

        return ($distance['Dist_Km'] * $param['Par_IndemniteKm']) + ($joursHeberger * $param['Par_IndemniteJour']) ." €";
    }else{
        return "Valeurs maquantes";
    }
}


function getDistance($depart, $arriver){
    $sql = "SELECT * FROM distance  WHERE Dist_NoVille1 = ? AND Dist_NoVille2 = ?";

    $result = executeSQL($sql, [$depart, $arriver]);
    return $result->fetch(PDO::FETCH_ASSOC);
}