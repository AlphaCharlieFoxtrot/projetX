<?php
require_once('includes/pdo.php');
require_once('includes/config.php');

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
$search = $_GET['search'] ?? '';

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
if ($limit < 1) $limit = 5; //sécurité
$offset = ($page - 1) * $limit;

$url = '?';

//créer $var pour filtre caté et pour le tri
$categorie = $_GET['categorie'] ?? '';
$tri = $_GET['tri'] ?? '';

$allowedCategories = ['homme', 'femme', 'enfant', 'accessoire'];
if (!in_array($categorie, $allowedCategories)) {
    $categorie = '';
}

//créer une $var where et param
$where = [];
$params = [];

//recherche
if (!empty($search)) {
    $where[] = 'nom LIKE :search OR description LIKE :search';
    $params[':search'] = '%' . $search . '%';
}

//catégorie
if (!empty($categorie)) {
    $where[] = 'categorie = :categorie';
    $params[':categorie'] = $categorie;
}

//construction WHERE final
$whereSql = '';
if (!empty($where)) {
    $whereSql = 'WHERE ' . implode(' AND ', $where);
}

//ORDER BY
$orderBy = '';//Definir apres le switch

switch ($tri) {
    case 'prix_asc':
        $orderBy = 'ORDER BY prix ASC';
        break;
    case 'prix_desc':
        $orderBy = 'ORDER BY prix DESC';
        break;
    case 'nom_asc':
        $orderBy = 'ORDER BY nom ASC';
        break;
    case 'nom_desc':
        $orderBy = 'ORDER BY nom DESC';
        break;

    default:
        $orderBy = '';//pas de tri spécifique
}

$sql = "SELECT * FROM produits $whereSql $orderBy LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);

foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($isAjax) {
    include 'includes/product_list.php';
    exit;
}

$countSql = "SELECT COUNT(*) FROM produits $whereSql";
$countStmt = $pdo->prepare($countSql);
foreach ($params as $key => $value) {
    $countStmt->bindValue($key, $value);
}
$countStmt->execute();
$total = $countStmt->fetchColumn();

$titre = count($produits) . ' produits trouvés pour: ' . $search;

$nbPages = ceil($total / $limit);

//construire l'url de base pour pagination
$query = [];

if (!empty($search)) {
    $query['search'] = $search;
}
if (!empty($categorie)) {
    $query['categorie'] = $categorie;
}
if (!empty($tri)) {
    $query['tri'] = $tri;
}
if (!empty($limit)) {
    $query['limit'] = $limit;
}

//generer la chaine GET sans 'page'
$baseUrl = '?' . http_build_query($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>boutique</title>
</head>

<body>
    <?php include_once 'includes/header.php'; ?>
    <form method="GET" action="boutique.php">
        <input type="text" name="search" placeholder="Rechercher..." value="<?= htmlspecialchars($search) ?>">
        
        <select name="limit">
            <option value="5" <?= $limit == 5 ? 'selected' : '' ?>>5</option>
            <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
            <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
            <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50</option>
        </select>

        <select name="categorie">
            <option value="">-- Toutes les catégories --</option>
            <option value="homme">Homme</option>
            <option value="femme">Femme</option>
            <option value="enfant">Enfant</option>
            <option value="accessoire">Accessoire</option>
        </select>

        <select name="tri">
            <option value="">-- Trier par --</option>
            <option value="prix_asc">Prix croissant</option>
            <option value="prix_desc">Prix décroissant</option>
            <option value="nom_asc">Nom A-Z</option>
            <option value="nom_desc">Nom Z-A</option>
        </select>

        <button type="submit">Filtrer</button>
    </form>
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
        <?php include 'includes/product_list.php'; ?>
    </section>
    <br>
    <article class="pagination">
        <?php for ($i = 1; $i <= $nbPages; $i++): ?>
            <?php
            // Ajoute la page au lien
            $link = $baseUrl . (empty($query) ? '' : '&') . 'page=' . $i;
            ?>
            <?php if ($i == $page): ?>
                <strong><?= $i ?></strong>
            <?php else: ?>
                <a href="<?= $link ?>"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>
        </section>
    </article>
    <script src="assets/js/boutique.js"></script>
</body>

</html>