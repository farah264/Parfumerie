<?php

$message_envoye = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Pour l'instant, le formulaire affiche simplement
    // un message de confirmation.
    header("Location: contact.php?success=1");
    exit();
}

if (isset($_GET['success'])) {
    $message_envoye = true;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact - Ma Parfumerie</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body class="<?php echo $message_envoye ? 'message-envoye' : ''; ?>">

<header>

    <h1>📩 CONTACTEZ-NOUS</h1>

    <nav>
        <a href="index.php">Accueil</a>
        <a href="panier.php">Mon panier</a>
    </nav>

</header>

<main>

    <div class="formulaire">

        <h2>🌸 Contactez notre parfumerie</h2>

        <?php if ($message_envoye) { ?>

            <div class="message-succes">
                ✓
            </div>

            <p class="texte-succes">
                Merci pour votre message ! 🌸<br>
                Nous vous répondrons bientôt.
            </p>

            <p>
                <a href="contact.php" class="btn-panier">
                    ✉️ Envoyer un autre message
                </a>
            </p>

        <?php } else { ?>

            <p>
                Nous sommes à votre disposition pour répondre à vos questions.
            </p>

            <form action="contact.php" method="post">

                <label for="nom">Nom et prénom :</label>

                <input
                    type="text"
                    id="nom"
                    name="nom"
                    required
                >

                <label for="email">Email :</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                >

                <label for="message">Message :</label>

                <textarea
                    id="message"
                    name="message"
                    rows="6"
                    required
                ></textarea>

                <button type="submit">
                    Envoyer le message 💌
                </button>

            </form>

        <?php } ?>

    </div>

</main>

</body>

</html>