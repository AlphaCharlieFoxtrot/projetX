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
            </div><br>
        <?php endforeach; ?>
        