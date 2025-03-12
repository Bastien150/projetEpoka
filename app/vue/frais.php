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
            <a href="./index.php?route=validation"><span>Validation des missions</span></a>
            <a href="./index.php?route=frais"><span class="active">Paiement des frais</span></a>
            <a href="./index.php?route=parametre"><span>Paramétrage</span></a>
        </div>
        <div class="copyright">
            <span>Copyright © 2025 Epoka</span>
        </div>
    </nav>
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
                    <tr>
                        <td>aaaaa</td>
                        <td>aaaaa</td>
                        <td>01/04/2025</td>
                        <td>05/04/2025</td>
                        <td>aaaaa</td>
                        <td>500€</td>
                        <td><button class="btn-validate">Rembourser</button></td>
                    </tr>
                    <tr>
                        <td>aaaaa</td>
                        <td>aaaaa</td>
                        <td>01/04/2025</td>
                        <td>05/04/2025</td>
                        <td>aaaaa</td>
                        <td>500€</td>
                        <td>Remboursée</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
