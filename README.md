Fast Foods Application Web
Aperçu
Fast Foods est une application web qui permet aux utilisateurs de parcourir et d'acheter divers articles de restauration rapide. Elle comprend des fonctionnalités telles que l'authentification des utilisateurs, la catégorisation des produits, la fonctionnalité de panier d'achat et un panneau d'administration pour la gestion des produits et des utilisateurs.

Table des matières
Commencer
Fonctionnalités
Utilisation
Structure des fichiers
Dépendances
Contributions
Licence
Commencer
Pour exécuter cette application web en local, suivez ces étapes :

Clonez le dépôt sur votre machine locale.

bash
Copy code
git clone https://github.com/votre-nom/fast-foods-web-app.git
Assurez-vous d'avoir PHP et un serveur de base de données MySQL installés.

Importez la sauvegarde SQL fournie (fastfoods.sql) dans votre base de données MySQL.

Configurez la connexion à la base de données dans database.php en mettant à jour les paramètres dans la structure de commutation en fonction de votre environnement.

Démarrez un serveur de développement PHP.

bash
Copy code
php -S localhost:8000
Accédez à l'application dans votre navigateur web à l'adresse http://localhost:8000.