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
            <a href="./index.php?route=frais"><span>Paiement des frais</span></a>
            <a href="./index.php?route=parametre"><span class="active">Paramétrage</span></a>
        </div>
        <div class="copyright">
            <span>Copyright © 2025 Forest Bastien</span>
        </div>
    </nav>
    <?php
    if (isset($_SESSION['user']) && $_SESSION['user']['Sal_Personnel'] == 0) {
        echo '<p class="error-message" style="display: block; font-size: 20px;" id="error-message">Vous n&#39;êtes pas autorisé</p>';
    } else { ?>
        <!-- login form -->
        <main class="container">
            <h1>Paramétrage de l'application</h1>
            <h2>Montant du remboursement au Km</h2>
            
            <!-- Form remboursement -->
            <div class="row-2">
                <div class="form-groups">
                    <label for="remboursementKm">Remboursement au Km :</label>
                    <input type="number" id="remboursementKm" name="remboursementKm">
                </div>

                <div class="form-groups">
                    <label for="hebergement">Indemnité d'hébergement :</label>
                    <input type="number" id="hebergement" name="hebergement">
                </div>
            </div>

            <div class="totalCenter">
                <input type="submit" value="Valider">
            </div>

            <hr>

            <!-- Form Distance -->
            <h2>Distance entre villes</h2>

            <div class="row-2" style="margin-bottom: 0;">
                <div class="form-groups">
                    <label for="remboursementKm">De :</label>
                    <input type="number" id="remboursementKm" name="remboursementKm">
                </div>

                <div class="form-groups">
                    <label for="hebergement">À :</label>
                    <input type="number" id="hebergement" name="hebergement">
                </div>
            </div>
            <div class="totalCenter" style="margin: 0 0 2rem 0;">
                <div class="form-group">
                    <label for="hebergement">Distance en km :</label>
                    <input type="number" id="hebergement" name="hebergement" style="margin-right: 330px">
                </div>
            </div>
            
            <div class="totalCenter">
                <input type="submit" value="Valider">
            </div>

            <hr>

            <!-- déjà saisies -->
            <h2>Distance entre villes déjà saisies</h2>
            <div class="form-container ">
                <table>
                    <thead>
                        <tr>
                            <th>De</th>
                            <th>À</th>
                            <th>Km</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </main>
    <?php } ?>

</body>

</html>