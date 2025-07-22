<?php
require_once('includes/pdo.php');
require_once('includes/config.php');

$search = $_GET['search'] ?? '';

$page = isset($_GET['page']) ? intval($_GET['page']) :1;
$limit = 5;
$offset = ($page-1)* $limit;

$url = '?' ;

if(!empty($search)){
    $sql = 'SELECT * FROM produits WHERE nom LIKE :search OR description LIKE :search LIMIT :limit OFFSET :offset';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $countSql = 'SELECT COUNT(*) FROM produits WHERE nom LIKE :search OR description LIKE :search';
    $countStmt = $pdo->prepare($countSql);
    $countStmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $countStmt->execute();
    $total = $countStmt->fetchColumn();

    $titre = count($produits) . ' produits trouvés pour: ' . $search;
}else{
    $sql = 'SELECT * FROM produits LIMIT :limit OFFSET :offset';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total = $pdo->query('SELECT COUNT(*) FROM produits')->fetchColumn();

    $titre = 'Bienvenue dans notre boutique';
}

$nbPages = ceil($total/$limit);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>boutique</title>
</head>

<body>
    <?php include(BASE_URL . 'includes.php/header.php'); ?>
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
    <article class="pagination">
        <?php for($i=1;$i<=$nbPages;$i++): ?>
            <?php $link = '?'; ?>
            <?php if(!empty($search)):?>
                <?php $link .= 'search=' . urlencode($search) . '&';?>
            <?php endif; ?>
            <?php $link .= 'page=' . $i; ?>
            <?php if($i == $page): ?>
                <?= '<strong>' . $i . ' </strong>'; ?>
            <?php else: ?>
                <?= '<a href="' . $link . '">' . $i . ' </a>'; ?>
            <?php endif; ?>
        <?php endfor; ?>
    </article>
</body>

</html>