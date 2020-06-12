## prj-cir2-web-2019-2020

Site permettant de classer les coureurs cyclistes, inscrits dans les différents clubs de la région, sur chacune des courses de l'année, et de pouvoir sortir le classement général ainsi que quelques statistiques en fin de saison.

# Dépendances

Vous devez posséder sur votre machine :

PHP version 7 ou supérieur
Un serveur Web (Apache)
MySQL 
Le projet à été essayé sous XAMP et sous WINDOWS.

# Installation
Télécharger le fichier zip à partir de l'ENT, puis enregistrer le projet sous Xamp/htdocs.

# Mise en place du site
Le site possède sa propre base de donnée que vous devez charger afin de le rendre fonctionnel. Pour ce faire, rendez-vous sur phpmyadmin et suivez les étapes suivantes :

1. Cliquer sur la rubrique import à la base de votre serveur.
2. Télécharger le fichier table.sql se trouvant là où vous avez enregistré le projet dans le dossier BDD.
3. N'oubliez pas de sélectionner les options **_Jeu de caractères du fichier_ :** utf-8 et **_FORMAT_** SQL
4. Cliquer sur exécuter.

Tout est inclus dans le fichier table.sql, mais si vous voulez changer les logins de connexion, vous pouvez changer les constantes dans le fichier api/constants.php. À condition de ne pas oublier de les changer dans phpmyadmin.
De même pour votre domaine de virtual host dans front/constante.js .

# Utilisation

Pour affiché les données des cyclistes d'un club il suffit de se connecter sur le site et de rentrer le mail d'un des users nous vous conseillons d'avoir un bloc-note pour les mettres.

Pour voir les participants d'une course ou voir les données d'une course cliqué en haut à gauche sur le bouton courses.
Vous pourrez voir les courses, les participants, et en rajouter dans les deux cas.

Le site n'est pas encore finiset certaines fonctionnalités ne fonctionnes pas parfaitement.
Enjoy.
