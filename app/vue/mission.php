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
            <a href="./index.php?route=mission"><span class="active">Validation des missions</span></a>
            <a href="./index.php?route=frais"><span>Paiement des frais</span></a>
            <a href="./index.php?route=parametre"><span>Paramétrage</span></a>
        </div>
        <div class="copyright">
            <span>Copyright © 2025 Forest Bastien</span>
        </div>
    </nav>
    <!-- Affichage la page si autorisé sinon affiche une erreur -->

    <?php 
    if(isset($_SESSION['user']) && $_SESSION['user']['Sal_Responsable'] == 0) {
        echo '<p class="error-message" style="display: block; font-size: 20px;" id="error-message">Vous n&#39;êtes pas autorisé</p>';
    }else {?> 
    <!-- login form -->

    <main class="container">
        <h1>Validation des missions de vos subordonnés</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nom du salarié</th>
                        <th>Prénom du salarié</th>
                        <th>Début de la mission</th>
                        <th>Fin de la mission</th>
                        <th>Lieu de la mission</th>
                        <th>Validation</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Remplir le tableaux avec les missions -->
                    <?php foreach ($missions as $mission) {?>
                    <tr>
                        <form action="" method="post">
                            <td><?php echo $mission["Sal_Nom"] ?? "Non défini"; ?></td>
                            <td><?php echo $mission["Sal_Prenom"] ?? "Non défini";?></td>
                            <td><?php echo $mission["Mis_DateDebut"] ?? "Non défini";?></td>
                            <td><?php echo $mission["Mis_DateFin"] ?? "Non défini";?></td>
                            <td><?php echo $mission["Vil_Nom"] ?? "Non défini";?></td>
                            <td><?php if($mission['Mis_Validee'] == 0){echo '<button class="btn-validate">Valider</button></td>';}
                            else{
                                $validation = $mission['Mis_Validee'] == 1 ? "Validée" : "";
                                $validation .= $mission['Mis_Remboursee'] == 1 ? ", Remboursée" : "";
                                echo $validation; }?>
                            <!-- ajouter si la distance n'est pas remplis -->
                        </form>
                    </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </main>
    <?php } ?>
</body>
</html>
