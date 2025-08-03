<?php foreach ($produits as $produit): ?>
            <div class="produit">
                <img src="img/<?= $produit['img_url'] ?>" alt="image du produit">
                <h3><?= $produit['nom'] ?></h3>
                <p><?= $produit['description'] ?></p>
                <p><?= $produit['prix'] ?> €</p>
                <!-- ✅ Lien pour voir la page produit -->
                <a href="produit.php?id=<?= $produit['id'] ?> class='btn-view'">Voir le produit</a><br>

                <!-- ✅ Formulaire pour ajouter au panier -->
                <form method="post" action="ajouter_panier.php">
                    <input type="hidden" name="id" value="<?= $produit['id'] ?>">
                    <button type="submit">Ajouter au panier</button>
                </form>
            </div><br>
        <?php endforeach; ?>
        