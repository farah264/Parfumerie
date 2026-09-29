<?php

session_start();

if (!isset($_SESSION['client_id'])) {

    header("Location: connexion.php");
    exit;
}

include "includes/connexion_bd.php";

$client_id = (int) $_SESSION['client_id'];

$sql_client = "
    SELECT *
    FROM clients
    WHERE id = ?
";


$requete_client = $connexion->prepare($sql_client);


if (!$requete_client) {
    die("Erreur lors de la préparation de la requête.");
}


$requete_client->bind_param(
    "i",
    $client_id
);


$requete_client->execute();


$resultat_client = $requete_client->get_result();


$client = $resultat_client->fetch_assoc();


$requete_client->close();

if (!$client) {

    session_destroy();

    header("Location: connexion.php");
    exit;
}

$email_client = $client['email'];
$sql_commandes = "
    SELECT *
    FROM commandes
    WHERE email = ?
    ORDER BY date_commande DESC
";
$requete_commandes = $connexion->prepare($sql_commandes);


if (!$requete_commandes) {
    die("Erreur lors de la récupération des commandes.");
}


$requete_commandes->bind_param(
    "s",
    $email_client
);


$requete_commandes->execute();


$resultat_commandes = $requete_commandes->get_result();

?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Mon espace client - Ma Parfumerie</title>

    <link rel="stylesheet" href="css/style.css">

</head>


<body class="page-client">
    
<header>

    <h1>
        🌸 MON ESPACE CLIENT 🌸
    </h1>


    <nav>

        <a href="index.php">
            Accueil
        </a>

        <a href="a propos.php">
            À propos
        </a>

        <a href="panier.php">
            🛒 Mon panier
        </a>

        <a href="contact.php">
            Contact
        </a>

        <a href="deconnexion.php">
            🚪 Déconnexion
        </a>

    </nav>

</header>
<main>

    <div class="espace-client">

        <div class="bienvenue-client">

            <h2>
                ✨ Bienvenue
                <?php
                echo htmlspecialchars(
                    $client['nom'],
                    ENT_QUOTES,
                    'UTF-8'
                );
                ?>
                !
            </h2>


            <p>
                Bienvenue dans votre espace personnel.
                Vous pouvez consulter vos informations
                et suivre vos commandes.
            </p>

        </div>

        <div class="client-section">

            <h2>
                👤 Mes informations
            </h2>


            <div class="informations-client">


                <div class="information-box">

                    <strong>
                        Nom
                    </strong>

                    <span>

                        <?php
                        echo htmlspecialchars(
                            $client['nom'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>

                    </span>

                </div>



                <div class="information-box">

                    <strong>
                        📧 Email
                    </strong>

                    <span>

                        <?php
                        echo htmlspecialchars(
                            $client['email'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>

                    </span>

                </div>


                <?php if (isset($client['telephone'])) { ?>

                    <div class="information-box">

                        <strong>
                            📱 Téléphone
                        </strong>

                        <span>

                            <?php
                            echo htmlspecialchars(
                                $client['telephone'],
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>

                        </span>

                    </div>

                <?php } ?>


            </div>

        </div>

        <div class="client-section">

            <h2>
                📦 Mes commandes
            </h2>


            <?php

            if ($resultat_commandes->num_rows > 0) {

                while (
                    $commande =
                    $resultat_commandes->fetch_assoc()
                ) {

            ?>


                <div class="commande-client">


                    <div class="commande-header">

                        <h3>
                            🛍️ Commande
                            #<?php
                            echo (int) $commande['id'];
                            ?>
                        </h3>


                        <span class="statut
                            <?php

                            echo strtolower(
                                str_replace(
                                    ' ',
                                    '-',
                                    $commande['statut']
                                )
                            );

                            ?>"
                        >

                            <?php
                            echo htmlspecialchars(
                                $commande['statut'],
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>

                        </span>

                    </div>


                    <div class="commande-details">


                        <p>

                            💰
                            <strong>Total :</strong>

                            <?php
                            echo htmlspecialchars(
                                $commande['total'],
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>

                            DT

                        </p>



                        <p>

                            📅
                            <strong>Date :</strong>

                            <?php
                            echo htmlspecialchars(
                                $commande['date_commande'],
                                ENT_QUOTES,
                                'UTF-8'
                            );
                            ?>

                        </p>


                    </div>


                </div>


            <?php

                }

            } else {

            ?>


                <div class="aucune-commande">

                    <p>
                        🛍️ Vous n'avez pas encore passé
                        de commande.
                    </p>


                    <a
                        href="index.php"
                        class="btn-panier"
                    >
                        🌸 Découvrir nos parfums
                    </a>

                </div>


            <?php

            }

            ?>


        </div>

        <div class="actions-client">

            <a
                href="index.php"
                class="btn-panier"
            >
                🌸 Continuer mes achats
            </a>


            <a
                href="deconnexion.php"
                class="btn-deconnexion"
            >
                🚪 Se déconnecter
            </a>

        </div>


    </div>

</main>


</body>

</html>

<?php

$requete_commandes->close();

?>
