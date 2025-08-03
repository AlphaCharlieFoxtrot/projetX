<?php
    require_once('includes/pdo.php');
    require_once('includes/config.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include_once 'includes/header.php'; ?>
    <section class="banner">
        <img src="/" alt="banner image" class="banner-image">
        <h1>Welcome to Projet X</h1>
    </section>
    <section class="carroussel_ctg">
        <h2>Project Overview</h2>
        <p>This is a brief overview of Projet X. Here you can find all the necessary information about the project.</p>
        <article class="conteiner_carroussel nouveau">
            <?php /* foreach ($news as $new)://sous controle dashboard admin -> table aLaUne à créer(date créattion: pas de date? = no table aLaUne) //nouveauté a l'affiche ?>
                <h3><?= $new['titre'] ?></h3>
                <p><?= $new['description'] ?></p>
                <a href="/index.php" class="btn">Read More</a>
            <?php endforeach; */?>
        </article>
        <article class="conteiner_ctg femmes">
            <div class="card_ctg">
                <h3>Card Title 1</h3>
                <p>This is a description of the first card. It contains relevant information about the project.</p>
            </div>
            <div class="card_ctg hommes">
                <h3>Card Title 2</h3>
                <p>This is a description of the second card. It contains additional details about the project.</p>
            </div>
            <div class="card_ctg enfants">
                <h3>Card Title 3</h3>
                <p>This is a description of the third card. It provides further insights into the project.</p>
            </div>
            <div class="card_ctg accessoires">
                <h3>Card Title 4</h3>
                <p>This is a description of the fourth card. It offers more information about the project.</p>
            </div>
        </article>
    </section>
</body>
</html>