<?php
    require_once('includes/pdo.php');
    require_once('includes/config.php');

    $sql = "SELECT * FROM `produits`";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Bienvenue</h1>
    <section class="catalogue">
            <?php
                // afficher tous les produits de la boutique en premier lieu
                // barre de navigation a faire dans le header
                // afficher les produits de la boutique en second lieu
            ?>
        <h2 class="conteiner catalogue"><?php  ?></h2>
    </section>
</body>
</html>