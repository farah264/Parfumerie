<?php

session_start();

/* Créer le panier */
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

/* Ajouter un parfum */
if (isset($_GET['produit'], $_GET['prix'])) {

    $produit = trim($_GET['produit']);
    $prix = (float) $_GET['prix'];

    $_SESSION['panier'][] = [
        'produit' => $produit,
        'prix' => $prix
    ];
}

/* Vider le panier */
if (isset($_GET['vider'])) {
    $_SESSION['panier'] = [];
}

/* Calcul du total */
$total = 0;

foreach ($_SESSION['panier'] as $article) {
    $total += (float) $article['prix'];
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mon panier</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<header>

    <h1>🛒 MON PANIER</h1>

    <nav>

        <a href="index.php">Accueil</a>

        <a href="parfums.php">Nos parfums</a>

    </nav>

</header>

<main>

    <div class="panier">

        <h2>✨ Mes parfums</h2>

        <?php if (empty($_SESSION['panier'])) { ?>

            <h3>Votre panier est vide 🛒</h3>

        <?php } else { ?>

            <?php foreach ($_SESSION['panier'] as $article) { ?>

                <div class="article-panier">

                    <h3>
                        <?php
                        echo htmlspecialchars(
                            $article['produit'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </h3>

                    <p>
                        Prix :
                        <?php echo number_format((float)$article['prix'], 2, ',', ' '); ?>
                        DT
                    </p>

                </div>

            <?php } ?>

            <hr>

            <h2>
                Total :
                <?php echo number_format($total, 2, ',', ' '); ?> DT
            </h2>

            <!-- BOUTONS -->

            <div class="actions-panier">

                <a href="parfums.php" class="btn-panier">
                    ← Continuer mes achats
                </a>

                <a href="client.php" class="btn-panier">
                    Valider la commande
                </a>

                <a href="panier.php?vider=1" class="btn-supprimer">
                    Supprimer
                </a>

            </div>

        <?php } ?>

    </div>

</main>

</body>

</html>