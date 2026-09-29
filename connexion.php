<?php

session_start();

include "includes/connexion_bd.php";

$message = "";

if (isset($_POST['email'], $_POST['mot_de_passe'])) {

    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    $sql = "SELECT * FROM utilisateurs WHERE email = ?";

    $requete = $connexion->prepare($sql);

    if ($requete) {

        $requete->bind_param("s", $email);
        $requete->execute();

        $resultat = $requete->get_result();

        if ($resultat->num_rows == 1) {

            $utilisateur = $resultat->fetch_assoc();

            if (password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
                $_SESSION['utilisateur_id'] = $utilisateur['id'];
                $_SESSION['utilisateur'] = $utilisateur['nom'];
                $_SESSION['client_nom'] = $utilisateur['nom'];
                $_SESSION['client_email'] = $utilisateur['email'];

                header("Location: index.php");
                exit;

            } else {

                $message = "Mot de passe incorrect ❌";
            }

        } else {

            $message = "Aucun compte trouvé avec cet email ❌";
        }

        $requete->close();

    } else {

        $message = "Une erreur est survenue lors de la connexion à la base de données ❌";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Se connecter - Ma Parfumerie</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body class="page-connexion">

<header>

    <h1>🔐 SE CONNECTER</h1>

    <nav>
        <a href="index.php">Accueil</a>
        <a href="panier.php">Mon panier</a>
        <a href="contact.php">Contact</a>
        <a href="inscription.php">Créer un compte</a>
    </nav>

</header>

<main>

    <div class="formulaire">

        <h2>🌸 Bienvenue</h2>

        <?php if ($message != "") { ?>

            <p class="message-erreur">
                <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
            </p>

        <?php } ?>

        <form action="connexion.php" method="post">

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

            <button type="submit">
                🔐 Se connecter
            </button>

        </form>

        <p>
            Vous n'avez pas encore de compte ?
        </p>

        <a href="inscription.php" class="btn-panier">
            ✨ Créer un compte
        </a>

    </div>

</main>

</body>

</html>
