<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - PPE Missions Epoka</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-links">
            <a href="./index.php?route=login"><span><?php echo isLoggedIn() ? "Déconnexion" : "Connexion"; ?></span></a>
            <a href="./index.php?route=mission"><span>Validation des missions</span></a>
            <a href="./index.php?route=frais"><span class="active">Paiement des frais</span></a>
            <a href="./index.php?route=parametre"><span>Paramétrage</span></a>
        </div>
        <div class="copyright">
            <span>Copyright © 2025 Forest Bastien</span>
        </div>
    </nav>
    <?php 
    if(isset($_SESSION['user']) && $_SESSION['user']['Sal_Personnel'] == 0) {
        echo '<p class="error-message" style="display: block; font-size: 20px;" id="error-message">Vous n&#39;êtes pas autorisé</p>';
    }else {?> 

    <!-- login form -->
    <main class="container">
        <h1>Paiement des missions</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nom du salarié</th>
                        <th>Prénom du salarié</th>
                        <th>Début de la mission</th>
                        <th>Fin de la mission</th>
                        <th>Lieu de la mission</th>
                        <th>montant</th>
                        <th>Paiement</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Remplis le tableau avec d'abord les non-remboursé -->
                    <?php foreach ($missions as $mission) {
                        $montantMission = montantMission($mission["Mis_No"]);
                        if($mission['Mis_Remboursee'] == 0){
                        ?>
                    <tr>
                        <form action="./index.php?route=frais" method="post">
                            <td><?php echo $mission["Sal_Nom"] ?? "Non défini"; ?></td>
                            <td><?php echo $mission["Sal_Prenom"] ?? "Non défini";?></td>
                            <td><?php echo $mission["Mis_DateDebut"] ?? "Non définie";?></td>
                            <td><?php echo $mission["Mis_DateFin"] ?? "Non définie";?></td>
                            <td><?php echo $mission["Vil_Nom"] ?? "Non défini";?></td>
                            <td><?php echo $montantMission; ?></td>
                            <td><?php if($mission['Mis_Remboursee'] == 0 && $montantMission == 'Distance non-définie'){echo '
                            <div class="tooltip">
                                <button class="btn-validate" disabled>Rembourser</button>
                                <span class="tooltiptext">Distance entre '.$mission["Vil_Nom"].' et '.getVilleById($mission['Ag_NoVille'])['Vil_Nom'].' non-définit</span>
                            </div>';}
                            elseif($mission['Mis_Validee'] == 0){echo '
                                <div class="tooltip">
                                    <button class="btn-validate" disabled>Rembourser</button>
                                    <span class="tooltiptext">La mission n&#39;est pas valider</span>
                                </div>';}
                            else{
                                echo '<input type="text" hidden value="'.$mission['Mis_No'].'" name="Mis_No">
                                <button class="btn-validate" name="remboursementMission">Rembourser</button></td>';
                            }
                            ?>
                                <!-- ajouter si la distance n'est pas remplis disabled + message avec infobulle -->
                        </form>
                    </tr>
                    <?php }} ?>
                    <!-- Remplir le tableaux avec les frais -->
                    <?php foreach ($missions as $mission) {
                        $montantMission = montantMission($mission["Mis_No"]);
                        if($mission['Mis_Remboursee'] == 1){
                        ?>
                    <tr>
                        <form action="./index.php?route=frais" method="post">
                            <td><?php echo $mission["Sal_Nom"] ?? "Non défini"; ?></td>
                            <td><?php echo $mission["Sal_Prenom"] ?? "Non défini";?></td>
                            <td><?php echo $mission["Mis_DateDebut"] ?? "Non définie";?></td>
                            <td><?php echo $mission["Mis_DateFin"] ?? "Non définie";?></td>
                            <td><?php echo $mission["Vil_Nom"] ?? "Non défini";?></td>
                            <td><?php echo $montantMission; ?></td>
                            <td><?php echo $mission['Mis_Remboursee'] == 1 ? "Remboursée" : ""; ?>
                        </form>
                    </tr>
                    <?php }} ?>
                </tbody>
            </table>
        </div>
    </main>
    <?php }
    if(isset($_SESSION['resultRemboursement'])){
        ?>
        <div class="totalCenter">
            <div class="success" id="notificationSuccess">
                <div class="success__icon">
                    <svg fill="none" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" d="m12 1c-6.075 0-11 4.925-11 11s4.925 11 11 11 11-4.925 11-11-4.925-11-11-11zm4.768 9.14c.0878-.1004.1546-.21726.1966-.34383.0419-.12657.0581-.26026.0477-.39319-.0105-.13293-.0475-.26242-.1087-.38085-.0613-.11844-.1456-.22342-.2481-.30879-.1024-.08536-.2209-.14938-.3484-.18828s-.2616-.0519-.3942-.03823c-.1327.01366-.2612.05372-.3782.1178-.1169.06409-.2198.15091-.3027.25537l-4.3 5.159-2.225-2.226c-.1886-.1822-.4412-.283-.7034-.2807s-.51301.1075-.69842.2929-.29058.4362-.29285.6984c-.00228.2622.09851.5148.28067.7034l3 3c.0983.0982.2159.1748.3454.2251.1295.0502.2681.0729.4069.0665.1387-.0063.2747-.0414.3991-.1032.1244-.0617.2347-.1487.3236-.2554z" fill="#393a37" fill-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="success__title">&nbsp;<?php echo $_SESSION['resultRemboursement'];?></div>
                <div class="success__close" id="closeNotification"><svg height="20" viewBox="0 0 20 20" width="20" xmlns="http://www.w3.org/2000/svg">
                        <path d="m15.8333 5.34166-1.175-1.175-4.6583 4.65834-4.65833-4.65834-1.175 1.175 4.65833 4.65834-4.65833 4.6583 1.175 1.175 4.65833-4.6583 4.6583 4.6583 1.175-1.175-4.6583-4.6583z" fill="#393a37"></path>
                    </svg></div>
            </div>
        </div>
        <?php
        }
        unset($_SESSION['resultRemboursement']);
    ?>
</body>
</html>
