<?php foreach ($produits as $produit): ?>
            <div class="produit">
                <img src="img/<?= htmlspecialchars($produit['img_url']) ?>" alt="image du produit">
                <h3><?= htmlspecialchars($produit['nom']) ?></h3>
                <p><?= htmlspecialchars($produit['description']) ?></p>
                <p><?= htmlspecialchars($produit['prix']) ?> €</p>
                <!-- ✅ Lien pour voir la page produit -->
                <a href="produit.php?id=<?= $produit['id'] ?> class='btn-view'">Voir le produit</a><br>

                <!-- ✅ Formulaire pour ajouter au panier -->
                <form method="post" action="ajouter_panier.php">
                    <input type="hidden" name="id" value="<?= $produit['id'] ?>">
                    <button type="submit">Ajouter au panier</button>
                </form>
                <form method="post" action="<?= BASE_URL . 'paiement.php'?>">
                    <input type="hidden" name="prix_produit" value="<?= $produit['prix'] ?>">
                    <button type="submit">Payer directement</button>
                </form>
            </div><br>
        <?php endforeach; ?>
        