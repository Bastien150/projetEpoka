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
            <a href="./index.php?route=login"><span class="active"><?php echo isLoggedIn() ? "Déconnexion" : "Connexion"; ?></span></a>
            <a href="./index.php?route=mission"><span>Validation des missions</span></a>
            <a href="./index.php?route=frais"><span>Paiement des frais</span></a>
            <a href="./index.php?route=parametre"><span>Paramétrage</span></a>
        </div>
        <div class="copyright">
            <span>Copyright © 2025 Epoka</span>
        </div>
    </nav>
    <!-- Affichage de l'erreur si il y en a -->
    <p class="error-message" style="display: block;" id="error-message"><?php echo $_SESSION['erreur'] ?? "";?></p>
    <?php if(isset($_SESSION['erreur'])){ unset($_SESSION['erreur']);} ?>
    <!-- login form -->
    <main class="login-container">
        <h1>Connexion</h1>
        <form class="login-form" action="./index.php?route=login" method="POST">
            <div class="form-group">
                <label for="email">Utilisateur :</label>
                <input type="text" id="utilisateur" name="utilisateur" placeholder="Entrez votre identifiant" required>
                <p class="error-message" id="email-error">Veuillez entrer une adresse e-mail valide.</p>
            </div>

            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
                <p class="error-message" id="password-error">Le mot de passe est requis.</p>
            </div>

            <button type="submit" class="btn-submit">Se connecter</button>
        </form>
    </main>

</body>
</html>
