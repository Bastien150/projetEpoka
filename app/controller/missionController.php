<?php 
//verifie si les identifiants sont correctent
function getLastMissions(){
    //refaire la requete pour 30 jours trié par le derniers
    $sql = "SELECT Mis_No, Sal_Nom, Sal_Prenom,Vil_Nom, Mis_DateDebut, Mis_DateFin, Mis_Validee, Mis_Remboursee
    FROM mission INNER JOIN salarie ON Mis_NoSalarie = Sal_No INNER JOIN ville ON Mis_NoVille = Vil_No ORDER BY Mis_DateFin";

    $result = executeSQL($sql, []);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}