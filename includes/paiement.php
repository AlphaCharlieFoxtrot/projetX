<?php
require_once 'includes/pdo.php';
require_once 'includes/config.php';

$prixPanier = isset($_POST['prix_panier']);
$prixProduit = isset($_POST['prix_produit']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <article>
        <h1>Page de paiement</h1>
        <?php if($prixPanier): ?>
            <p>Vous avez choisi de payer votre panier.</p>
            <p>Le montant total de votre panier est: <?= $prixPanier ?> €</p>
            <!-- Formulaire de paiement -->
            <form method="post" action="confirmation.php">
                <input type="hidden" name="prix_panier" value="<?= $prixPanier ?>">
                <button type="submit">Confirmer le paiement</button>
            </form>
        <?php elseif($prixProduit): ?>
            <p>Vous avez choisi de payer un produit spécifique.</p>
            <p>Le prix du produit sélectionné est: <?= $prixProduit ?> €</p>
            <!-- Formulaire de paiement -->
            <form method="post" action="confirmation.php">
                <input type="hidden" name="prix_produit" value="<?= $prixProduit ?>">
                <button type="submit">Confirmer le paiement</button>
            </form>
        <?php endif; ?>
        
        <p>Vous pouvez aussi retourner à la boutique pour continuer vos achats.</p>
        <a href="boutique.php">Retour à la boutique</a>
        <a href="panier.php">Retour au panier</a>
        <a href="index.php">Retour à l'accueil</a>
    </article>
</body>
</html>