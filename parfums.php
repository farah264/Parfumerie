<?php

session_start();

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "parfumerie");

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Définir l'encodage
$conn->set_charset("utf8mb4");

// Récupérer les produits
$sql = "SELECT * FROM produits";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nos Parfums - Ma Parfumerie</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<header>

    <h1>✨ MA PARFUMERIE ✨</h1>

    <nav>

        <a href="index.php">Accueil</a>

        <a href="parfums.php">Parfums</a>

        <a href="apropos.php">À propos</a>

        <a href="contact.php">Contact</a>

        <?php if (isset($_SESSION['utilisateur'])) { ?>

            <span>
                👋 Bonjour
                <?php
                echo htmlspecialchars(
                    $_SESSION['utilisateur'],
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>
            </span>

            <a href="deconnexion.php">
                🚪 Se déconnecter
            </a>

        <?php } else { ?>

            <a href="connexion.php">
                🔐 Se connecter
            </a>

        <?php } ?>

    </nav>

</header>

<main>

    <h2>✨ Nos Parfums ✨</h2>

    <p>
        Découvrez notre collection de parfums élégants et raffinés.
    </p>

    <div class="produits">

        <?php

        if ($result && $result->num_rows > 0) {

            while ($produit = $result->fetch_assoc()) {

        ?>

                <div class="produit">

                    <img
                        src="images/<?php echo htmlspecialchars(
                            $produit['image'],
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>"
                        alt="<?php echo htmlspecialchars(
                            $produit['nom'],
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>"
                    >

                    <h3>
                        <?php
                        echo htmlspecialchars(
                            $produit['nom'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </h3>

                    <p>
                        <?php
                        echo htmlspecialchars(
                            $produit['description'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </p>

                    <p>
                        Prix :
                        <?php
                        echo number_format(
                            (float)$produit['prix'],
                            2,
                            ',',
                            ' '
                        );
                        ?>
                        DT
                    </p>

                    <a
                        href="panier.php?produit=<?php echo urlencode($produit['nom']); ?>&prix=<?php echo urlencode($produit['prix']); ?>"
                        class="btn-panier"
                    >
                        🛒 Ajouter au panier
                    </a>

                </div>

        <?php

            }

        } else {

            echo "<p>Aucun parfum disponible pour le moment.</p>";

        }

        ?>

    </div>

</main>

</body>

</html>

<?php

// Fermer la connexion
$conn->close();

?>