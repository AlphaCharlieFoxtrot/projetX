<header>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="boutique.php">Boutique</a></li>
        </ul>
    </nav>
    <form method="get">
        <input type="text" name="search" placeholder="Rechercher...">
        <input type="submit" value="Rechercher">
    </form>
    <?php if (isset($_SESSION['user'])) : ?>
        <div class="user-info">
            <p>Bonjour, <?= $_SESSION['user']['username'] ?></p>
            <a href="logout.php">Déconnexion</a>
        </div>
    <?php else : ?>
        <div class="login">
            <a href="login.php">Connexion</a>
            <a href="register.php">Pas encore de compte? venez en créer un!</a>
        </div>
    <?php endif; ?>
</header>