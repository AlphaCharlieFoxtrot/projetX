<?php
require_once BASE_URL . 'includes/pdo.php';
require_once BASE_URL . 'includes/config.php';

$panier = $_SESSION['panier'] ?? [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
</head>

<body>
    <?php
    include_once BASE_URL . 'includes/header.php';
    //logique: si isset panier et !empty panier = affichage produit(s) + somme du panier totale
    //else = h1.Votre panier est vide + a.boutique
    ?>
    <h1>Panier</h1>
    <?php if (isset($panier) && !empty($panier)): ?>
        <?php foreach ($panier as $produit): ?>
            <div class="produit">
                <a href="produit.php?id=<?= $produit['id'] ?>" class="btn-view">
                    <img src="img/<?= htmlspecialchars($produit['img_url']) ?>" alt="image du produit">
                </a>
                <h3><?= $produit['nom'] ?></h3>
                <p><?= $produit['description'] ?></p>
                <p><?= $produit['prix'] * $produit['quantite'] ?> €</p>
                <!-- ✅ Lien pour voir la page produit -->
                <a href="produit.php?id=<?= $produit['id'] ?>" class="btn-view">Voir le produit</a><br>

                <form method="post" action="modifier_panier.php">
                    <input type="hidden" name="id" value="<?= $produit['id'] ?>">
                    <button type="submit">Enlever du panier</button>
                </form>
            </div><br>
        <?php endforeach; ?>
        <?php
        $prixPanier = 0;
        foreach ($panier as $produit) {
            $prixPanier += $produit['prix'] * $produit['quantite'];
        }
        echo "<h2>Prix total de votre panier: {$prixPanier} € </h2>";
        ?>
        <article>
            <form method="post" action="paiement.php">
                <input type="hidden" name="prix_panier" value="<?= $prixPanier ?>">
                <button type="submit">Payer</button>
            </form>
        </article>
    <?php else: ?>
        <h2>Votre panier est vide.</h2>
    <?php endif ?>
</body>

</html>