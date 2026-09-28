<?php

session_start();

include "includes/connexion_bd.php";

$message = "";

if (isset($_POST['nom'], $_POST['email'], $_POST['mot_de_passe'], $_POST['confirmation'])) {

    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];
    $confirmation = $_POST['confirmation'];

    if ($mot_de_passe != $confirmation) {

        $message = "Les mots de passe ne correspondent pas.";

    } else {

        // Vérifier si l'email existe déjà
        $sql_verification = "SELECT id FROM utilisateurs WHERE email = ?";

        $requete_verification = $connexion->prepare($sql_verification);

        $requete_verification->bind_param("s", $email);
        $requete_verification->execute();

        $resultat = $requete_verification->get_result();

        if ($resultat->num_rows > 0) {

            $message = "Un compte existe déjà avec cet email.";

        } else {

            // Sécuriser le mot de passe
            $mot_de_passe_hash = password_hash(
                $mot_de_passe,
                PASSWORD_DEFAULT
            );

            $sql = "INSERT INTO utilisateurs 
                    (nom, email, mot_de_passe, date_inscription)
                    VALUES (?, ?, ?, NOW())";

            $requete = $connexion->prepare($sql);

            if ($requete) {

                $requete->bind_param(
                    "sss",
                    $nom,
                    $email,
                    $mot_de_passe_hash
                );

                if ($requete->execute()) {

                    // Récupérer l'identifiant du nouvel utilisateur
                    $utilisateur_id = $connexion->insert_id;

                    // Connecter automatiquement l'utilisateur
                    $_SESSION['utilisateur_id'] = $utilisateur_id;
                    $_SESSION['utilisateur'] = $nom;
                    $_SESSION['client_nom'] = $nom;
                    $_SESSION['client_email'] = $email;

                    // Aller à l'accueil
                    header("Location: index.php");
                    exit;

                } else {

                    $message = "Erreur lors de la création du compte.";
                }

                $requete->close();

            } else {

                $message = "Erreur lors de la préparation de la requête.";
            }
        }

        $requete_verification->close();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Créer un compte - Ma Parfumerie</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body class="page-inscription">

<header>

    <h1>✨ CRÉER UN COMPTE ✨</h1>

    <nav>

        <a href="index.php">Accueil</a>

        <a href="panier.php">Mon panier</a>

        <a href="contact.php">Contact</a>

        <a href="connexion.php">Se connecter</a>

    </nav>

</header>

<main>

    <div class="formulaire">

        <h2>🌸 Créez votre compte</h2>

        <?php if ($message != "") { ?>

            <p class="message-erreur">
                <?php echo htmlspecialchars(
                    $message,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>
            </p>

        <?php } ?>

        <form action="inscription.php" method="post">

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

            <label for="mot_de_passe">Mot de passe :</label>

            <input
                type="password"
                id="mot_de_passe"
                name="mot_de_passe"
                required
            >

            <label for="confirmation">Confirmer le mot de passe :</label>

            <input
                type="password"
                id="confirmation"
                name="confirmation"
                required
            >

            <button type="submit">
                Créer mon compte ✨
            </button>

        </form>

        <p>Vous avez déjà un compte ?</p>

        <a href="connexion.php" class="btn-panier">
            🔐 Se connecter
        </a>

    </div>

</main>

</body>

</html>