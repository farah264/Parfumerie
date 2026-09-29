# Parfumerie – Site e-commerce

##  Présentation

Parfumerie est une application web e-commerce développée dans le cadre d'un projet académique.

L'application permet aux utilisateurs de consulter des parfums, créer un compte, ajouter des produits au panier et passer une commande.

Une interface d'administration permet également de consulter les commandes et de modifier leur statut.

##  Technologies utilisées :

- PHP
- MySQL
- HTML5
- CSS3
- XAMPP

##  Fonctionnalités :

### Client :
- Création de compte
- Connexion / déconnexion
- Consultation des parfums
- Ajout de produits au panier
- Validation d'une commande
- Confirmation de commande
- Envoyer un message

###  Administration :
- Consultation des commandes
- Consultation des informations clients
- Modification du statut des commandes

##  Base de données :

La base de données MySQL contient notamment les tables :

- utilisateurs
- produits
- commandes
- details_commandes

##  Installation en local :

1. Installer XAMPP.
2. Démarrer Apache et MySQL.
3. Placer le projet dans le dossier htdocs
4. Créer une base de données MySQL appelée parfumerie.
5. Configurer la connexion dans includes/connexion_bd.php.
6. Ouvrir le projet avec :

````text
http://localhost/parfumerie/
