<?php
    require_once 'includes/config.php';
    require_once BASE_URL . 'includes/pdo.php';

    $idModif = isset($_POST['id']) ? intval($_POST['id']) : null;
    if(!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }
    $panier = $_SESSION['panier'];

    // Vérification si le panier existe et n'est pas vide
    if(isset($panier) && !empty($panier)){
        if($idModif != null && isset($panier[$idModif])){
            unset($panier[$idModif]);
            $_SESSION['panier'] = $panier;

            header('Location: panier.php');
            exit;
        }
    }
    
?>