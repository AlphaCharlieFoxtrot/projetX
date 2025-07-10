<?php
require_once('includes/pdo.php');
require_once('includes/config.php');

if (empty($_GET['search'])) {
    $sql = "SELECT * FROM `produits`";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $search = '%' . $_GET['search'] . '%';

    $sql = 'SELECT * FROM `produits` WHERE description LIKE :search OR nom LIKE :search';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => $search]);
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$titre = empty($_GET["search"]) ? "Tous les produits" : 'Produits contenant "' . htmlspecialchars($_GET["search"]) . '"';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>boutique</title>
</head>

<body>
    <h1>Bienvenue</h1>
    <section class="catalogue">
        <?php
        // afficher tous les produits de la boutique en premier lieu
        // barre de navigation a faire dans le header
        // afficher les produits de la boutique en second lieu
        ?>
        <h3>
            <?= $titre ?>
        </h3>
        <?php foreach ($produits as $produit): ?>
            <div class="produit">
                <img src="img/<?= $produit['image'] ?>" alt="image du produit">
                <h3><?= $produit['nom'] ?></h3>
                <p><?= $produit['description'] ?></p>
                <p><?= $produit['prix'] ?> €</p>
                <a href="produit.php?id=<?= $produit['id'] ?>">Voir le produit</a>
                <form action="ajouter_panier.php">
                    <input type="hidden" name="id" value="<?= $produit['id'] ?>">
                    <input type="submit" value="Ajouter au panier">
                </form>
            </div>
        <?php endforeach; ?>
    </section>
</body>

</html>