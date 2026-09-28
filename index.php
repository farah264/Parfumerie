<?php

session_start();

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ma Parfumerie</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body class="accueil">

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
                <?php echo htmlspecialchars(
                    $_SESSION['utilisateur'],
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>
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

    <h2>Bienvenue dans notre parfumerie 🌸</h2>

    <p>
        Découvrez notre univers de parfums élégants et raffinés.
    </p>

    <p>
        ✨ Explorez notre collection et trouvez le parfum qui vous correspond. ✨
    </p>

    <a href="parfums.php" class="btn-panier">
        🌸 Découvrir nos parfums
    </a>

</main>

</body>

</html>