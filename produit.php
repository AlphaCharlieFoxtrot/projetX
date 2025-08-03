<?php
require_once('includes/pdo.php');
require_once('includes/config.php');

$produitId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = 'SELECT * FROM produits WHERE id = :id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $produitId, PDO::PARAM_INT);
$stmt->execute();
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    echo 'Produit introuvable';
    exit;
}

$similarSql = 'SELECT * FROM produits WHERE categorie = :categorie AND id != :id ORDER BY RAND() LIMIT 5';
$similarStmt = $pdo->prepare($similarSql);
$similarStmt->bindValue(':categorie', $produit['categorie'], PDO::PARAM_STR);
$similarStmt->bindValue(':id', $produitId, PDO::PARAM_INT);
$similarStmt->execute();
$produitSimilaire = $similarStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nom du produit - Projet X</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <!-- Ton header existant -->
        <?php include_once(BASE_URL . 'includes/header.php') ?>
    </header>

    <main class="product-page">
        <section class="product-container">
            <!-- ✅ Images produit (style Amazon avec miniatures) -->
            <div class="product-gallery">
                <!--
                <div class="thumbnails">
                    <img src="<?= $produit['img_url'] ?>" alt="Miniature 1">
                    <img src="<?= $produit['img_url'] ?>" alt="Miniature 2">
                    <img src="<?= $produit['img_url'] ?>" alt="Miniature 3">
                </div>-->
                <div class="main-image">
                    <img src="<?= $produit['img_url'] ?>" alt="Nom du produit">
                </div>
            </div>

            <!-- ✅ Détails produit -->
            <div class="product-details">
                <h1 class="product-title"><?= htmlspecialchars($produit['nom']) ?></h1>
                <!--<p class="product-brand">Marque: <strong>Louis Vuitton</strong></p>
                <div class="product-rating">
                    ⭐⭐⭐⭐☆ <span>(120 avis)</span>
                </div>-->
                <p class="product-price"><?= number_format($produit['prix'], 2, ',', ' ') ?> €</p>
                <p class="product-description"><?= htmlspecialchars($produit['description']) ?></p>

                <!-- ✅ Sélecteurs (taille/couleur) 
                <div class="product-options">
                    <label for="size">Taille :</label>
                    <select id="size" name="size">
                        <option>-- Choisir --</option>
                        <option>XS</option>
                        <option>S</option>
                        <option>M</option>
                        <option>L</option>
                        <option>XL</option>
                    </select>
                
                    <label for="color">Couleur :</label>
                    <select id="color" name="color">
                        <option>Noir</option>
                        <option>Blanc</option>
                        <option>Marron</option>
                    </select>
                </div>
                -->

                <!-- ✅ Formulaire ajout au panier -->
                <form action="ajouter_panier.php" method="POST" class="product-actions">
                    <input type="hidden" name="id" value="<?= $produitId ?>">
                    <button type="submit" class="btn-add-to-cart">Ajouter au panier</button>
                    <button type="button" class="btn-buy-now">Acheter maintenant</button>
                </form>

                <!-- ✅ Infos supp -->
                <ul class="product-extra-info">
                    <li>✅ Livraison gratuite sous 3 à 5 jours</li>
                    <li>✅ Retour gratuit sous 30 jours</li>
                    <li>✅ Garantie 2 ans</li>
                </ul>
            </div>
        </section>

        <!-- ✅ Section produits similaires (style Amazon) display en row limiter a 5 items puis card vide avec logo '+'-->
        <section class="related-products">
            <h2>Produits similaires</h2>
            <div class="related-list">
                <?php foreach ($produitSimilaire as $sim): ?>
                    <div class="related-item">
                        <a href="produit.php?id=<?= $sim['id'] ?>">
                            <img src="img/<?= $sim['img_url'] ?>" alt="<?= htmlspecialchars($sim['nom']) ?>">
                            <p><?= htmlspecialchars($sim['nom']) ?></p>
                            <span><?= number_format($sim['prix'], 2, ',', ' ') ?> €</span>
                        </a>
                    </div><br>
                <?php endforeach; ?>
                <?php if (count($produitSimilaire) === 5): ?>
                    <br><div class="related-item more">
                        <a href="boutique.php?categorie=<?= urlencode($produit['categorie']) ?>">Voir +</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- ✅ Avis clients 
        <section class="customer-reviews">
            <h2>Avis clients</h2>
            <article class="review">
                <h3>Superbe produit</h3>
                <p>⭐️⭐️⭐️⭐️⭐️</p>
                <p>"Un produit magnifique, conforme à mes attentes. Je recommande !"</p>
                <small>- Marie, 15 janvier 2025</small>
            </article>
            <article class="review">
                <h3>Très satisfait</h3>
                <p>⭐️⭐️⭐️⭐️☆</p>
                <p>"Qualité incroyable, seul petit bémol : la livraison un peu lente."</p>
                <small>- Julien, 2 février 2025</small>
            </article>
        </section>-->
    </main>

    <footer>
        <!-- Ton footer existant -->
    </footer>
</body>

</html>