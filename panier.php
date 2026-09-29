<?php

session_start();


$conn = new mysqli("localhost", "root", "", "parfumerie");

if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");


if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}


if (isset($_GET['produit_id'])) {

    $produit_id = filter_input(
        INPUT_GET,
        'produit_id',
        FILTER_VALIDATE_INT
    );

    if ($produit_id !== false && $produit_id !== null) {

        $sql = "SELECT id, nom, prix FROM produits WHERE id = ?";

        $requete = $conn->prepare($sql);

        if ($requete) {

            $requete->bind_param("i", $produit_id);
            $requete->execute();

            $resultat = $requete->get_result();

            if ($produit = $resultat->fetch_assoc()) {

                $_SESSION['panier'][] = [
                    'produit_id' => (int)$produit['id'],
                    'produit' => $produit['nom'],
                    'prix' => (float)$produit['prix']
                ];
            }

            $requete->close();
        }
    }
}


if (isset($_GET['vider'])) {
    $_SESSION['panier'] = [];
}


$total = 0;

foreach ($_SESSION['panier'] as $article) {
    $total += (float)$article['prix'];
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mon panier</title>

    <link rel="stylesheet" href="style.css">

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
                        <?php
                        echo number_format(
                            (float)$article['prix'],
                            2,
                            ',',
                            ' '
                        );
                        ?>
                        DT
                    </p>

                </div>

            <?php } ?>

            <hr>

            <h2>
                Total :
                <?php
                echo number_format(
                    $total,
                    2,
                    ',',
                    ' '
                );
                ?>
                DT
            </h2>

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

<?php

$conn->close();

?>
