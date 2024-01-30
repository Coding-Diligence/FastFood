# Application Web Fast Foods

## Aperçu

Fast Foods est une application web qui permet aux utilisateurs de parcourir et d'acheter divers produits de restauration rapide. Elle comprend des fonctionnalités telles que l'authentification des utilisateurs, la catégorisation des produits, la fonctionnalité de panier d'achat, et un panneau d'administration pour la gestion des produits et des utilisateurs.

## Table des matières

- [Pour commencer](#pour-commencer)
- [Fonctionnalités](#fonctionnalités)
- [Utilisation](#utilisation)
- [Structure des fichiers](#structure-des-fichiers)
- [Dépendances](#dépendances)
- [Contributions](#contributions)
- [Licence](#licence)

## Pour commencer

Pour exécuter cette application localement, suivez ces étapes :

1. Clonez le dépôt sur votre machine locale.

   ```bash
   git clone https://github.com/votre-nom/fast-foods-web-app.git

2. Assurez-vous d'avoir PHP et un serveur de base de données MySQL installés.

3. Importez le dump SQL fourni (`fastfoods.sql`) dans votre base de données MySQL.

4. Configurez la connexion à la base de données dans `database.php` en modifiant les paramètres appropriés.

5. Démarrez votre serveur local.

   ```bash
   php -S localhost:8000

Accédez à l'application dans votre navigateur en visitant http://localhost:8000.

## Fonctionnalités

- Authentification des Utilisateurs
- Catégorisation des Produits
- Panier d'Achat
- Panneau d'Administration

## Utilisation

- Page d'Accueil (`index.php`)
- Page de Connexion (`login.php`)
- Page de Panier (`panier.php`)
- Page Catégorie (`pizza.php`, etc.)
- Page Admin (`admin.php`)

## Structure des fichiers

fast-foods/
|-- admin.php
|-- category.php
|-- database.php
|-- fastfoods.sql
|-- header.php
|-- index.php
|-- login.php
|-- modele.php
|-- panier.php
|-- pizza.php
|-- README.md
|-- uploads/
|   |-- fastfood_logo.jpg
|-- css/
|   |-- login.css
|-- ...

