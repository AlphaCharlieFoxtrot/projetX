<?php
    require_once('includes/pdo.php');
    require_once('includes/config.php');

    $ajoutProduit = isset($_POST['id']) ? intval($_POST['id']) : 0;

    $sql = 'SELECT * FROM produits WHERE id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $ajoutProduit, PDO::PARAM_INT);
    $stmt->execute();
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produit) {
        header('Location: boutique.php');
        exit;
    }

    // 🔹 Quantité par défaut à 1
    $quantite = isset($_POST['quantite']) ? intval($_POST['quantite']) : 1;
    if ($quantite < 1) $quantite = 1;

    // 🔹 Initialise le panier si vide
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    // 🔹 Copie le panier
    $panier = $_SESSION['panier'];

    // 🔹 Ajout ou incrémentation
    if (isset($panier[$ajoutProduit])) {
        $panier[$ajoutProduit]['quantite'] += $quantite;
    } else {
        $panier[$ajoutProduit] = [
            'id' => $produit['id'],
            'image' => $produit['img_url'],
            'nom' => $produit['nom'],
            'prix' => $produit['prix'],
            'description' => $produit['description'],
            'quantite' => $quantite
        ];
    }

    
    // 🔹 Sauvegarde dans la session
    $_SESSION['panier'] = $panier;

    // 🔹 Redirection vers le panier
    header('Location: panier.php');
    exit;
?>