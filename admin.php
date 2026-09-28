<?php

session_start();

/* ============================= */
/* MOT DE PASSE ADMINISTRATEUR */
/* ============================= */

$mot_de_passe_admin = "admin123";


/* ============================= */
/* VÉRIFIER LA CONNEXION ADMIN */
/* ============================= */

if (!isset($_SESSION['admin'])) {

    if (isset($_POST['mot_de_passe'])) {

        if ($_POST['mot_de_passe'] === $mot_de_passe_admin) {

            $_SESSION['admin'] = true;

            /* Éviter de renvoyer le formulaire */
            header("Location: admin.php");
            exit;

        } else {

            $erreur = "❌ Mot de passe incorrect.";

        }
    }
}


/* ============================= */
/* AFFICHER LA CONNEXION */
/* ============================= */

if (!isset($_SESSION['admin'])) {
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administration</title>

    <link rel="stylesheet" href="css/style.css">

</head>

<body>

<header>

    <h1>🔐 ESPACE ADMINISTRATEUR</h1>

</header>


<main>

    <div class="formulaire">

        <h2>Connexion administrateur</h2>


        <?php if (isset($erreur)) { ?>

            <p class="message-erreur">
                <?php echo htmlspecialchars($erreur); ?>
            </p>

        <?php } ?>


        <form method="post">

            <label for="mot_de_passe">
                Mot de passe :
            </label>

            <input
                type="password"
                id="mot_de_passe"
                name="mot_de_passe"
                required
            >

            <button type="submit">
                🔐 Accéder à l'administration
            </button>

        </form>

    </div>

</main>

</body>

</html>

<?php

exit;

}


/* ============================= */
/* CONNEXION À LA BASE DE DONNÉES */
/* ============================= */

include "includes/connexion_bd.php";


/* ============================= */
/* MODIFIER LE STATUT */
/* ============================= */

if (isset($_POST['modifier_statut'])) {

    $id_commande = filter_input(
        INPUT_POST,
        'id_commande',
        FILTER_VALIDATE_INT
    );

    $nouveau_statut = $_POST['statut'] ?? '';


    /* Statuts autorisés */

    $statuts_autorises = [
        "En attente",
        "Préparée",
        "Livrée"
    ];


    if (
        $id_commande !== false &&
        $id_commande !== null &&
        in_array($nouveau_statut, $statuts_autorises, true)
    ) {

        $sql_update = "
            UPDATE commandes
            SET statut = ?
            WHERE id = ?
        ";


        $requete_update = $connexion->prepare($sql_update);


        if ($requete_update) {

            $requete_update->bind_param(
                "si",
                $nouveau_statut,
                $id_commande
            );

            $requete_update->execute();

            $requete_update->close();
        }
    }


    /* Retour à la page admin */

    header("Location: admin.php");
    exit;
}


/* ============================= */
/* RÉCUPÉRER LES COMMANDES */
/* ============================= */

$sql = "
    SELECT *
    FROM commandes
    ORDER BY date_commande DESC
";


$resultat = $connexion->query($sql);

?>

<!DOCTYPE html>

<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Administration - Ma Parfumerie</title>

    <link rel="stylesheet" href="css/style.css">

</head>


<body>


<header>

    <h1>
        🌸 ADMINISTRATION 🌸
    </h1>


    <nav>

        <a href="index.php">
            Accueil
        </a>

        <a href="admin.php">
            📦 Commandes
        </a>

    </nav>

</header>


<main>

    <h2>
        📦 Gestion des commandes
    </h2>


    <div class="commandes-admin">


        <?php

        if ($resultat && $resultat->num_rows > 0) {

            while ($commande = $resultat->fetch_assoc()) {

        ?>


            <div class="commande-box">


                <h3>

                    👤

                    <?php
                    echo htmlspecialchars(
                        $commande['nom'],
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>

                </h3>


                <div class="commande-info">


                    <!-- EMAIL -->

                    <p>

                        📧 <strong>Email :</strong>

                        <?php
                        echo htmlspecialchars(
                            $commande['email'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>

                    </p>


                    <!-- TÉLÉPHONE -->

                    <p>

                        📱 <strong>Téléphone :</strong>

                        <?php
                        echo htmlspecialchars(
                            $commande['telephone'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>

                    </p>


                    <!-- ADRESSE -->

                    <p>

                        🏠 <strong>Adresse :</strong>

                        <?php
                        echo htmlspecialchars(
                            $commande['adresse'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>

                    </p>


                    <!-- VILLE -->

                    <p>

                        🏙️ <strong>Ville :</strong>

                        <?php
                        echo htmlspecialchars(
                            $commande['ville'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>

                    </p>


                    <!-- TOTAL -->

                    <p>

                        💰 <strong>Total :</strong>

                        <?php
                        echo htmlspecialchars(
                            $commande['total'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>

                        DT

                    </p>


                    <!-- DATE -->

                    <p>

                        📅 <strong>Date :</strong>

                        <?php
                        echo htmlspecialchars(
                            $commande['date_commande'],
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>

                    </p>


                    <!-- STATUT -->

                    <p>

                        📦 <strong>Statut :</strong>


                        <span
                            class="statut
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

                    </p>


                </div>


                <!-- ============================= -->
                <!-- MODIFICATION DU STATUT -->
                <!-- ============================= -->

                <form
                    method="post"
                    class="form-statut"
                >


                    <input
                        type="hidden"
                        name="id_commande"
                        value="<?php
                        echo (int) $commande['id'];
                        ?>"
                    >


                    <label for="statut-<?php echo (int) $commande['id']; ?>">

                        Modifier le statut :

                    </label>


                    <select
                        name="statut"
                        id="statut-<?php echo (int) $commande['id']; ?>"
                    >


                        <option
                            value="En attente"
                            <?php

                            if ($commande['statut'] === "En attente") {
                                echo "selected";
                            }

                            ?>
                        >
                            🕐 En attente
                        </option>


                        <option
                            value="Préparée"
                            <?php

                            if ($commande['statut'] === "Préparée") {
                                echo "selected";
                            }

                            ?>
                        >
                            📦 Préparée
                        </option>


                        <option
                            value="Livrée"
                            <?php

                            if ($commande['statut'] === "Livrée") {
                                echo "selected";
                            }

                            ?>
                        >
                            🚚 Livrée
                        </option>


                    </select>


                    <button
                        type="submit"
                        name="modifier_statut"
                    >

                        🔄 Modifier

                    </button>


                </form>


            </div>


        <?php

            }

        } else {

            echo "<p>Aucune commande pour le moment.</p>";

        }

        ?>


    </div>

</main>


</body>

</html>