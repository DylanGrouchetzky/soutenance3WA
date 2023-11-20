# Comment lancer le projet Super Collect

## 1 - Télécharger le projet 

* Aller sur le projet GitHub de Super Collect [ici](https://github.com/DylanGrouchetzky/soutenance3WA) 
* Récupérer le lien SSH ou HTTPS pour pouvoir le cloner sur votre machine avec le commande ```git clone url```

## 2 - Installer/Update Composer

* Dans terminal de commande taper la commande suivante pour installer composer :
```composer
composer install
```
* Puis la suivante pour mettre le mettre à jour :
```composer
composer update
```

## 3 - Installer la base de donnée

* Créé un fichier .env.local dans à la racine du projet en copiant le .env 
* Modifier la variable de " # DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/baseDeDonnee" " avoir vos paramétre de connection à MySql et le nom de la base de données
* Effectué la commande suivante : ``` php bin/console d:d:c ``` pour créé la base de donnée 
* Puis la commande ``` php bin/console d:m:m ``` joué les migrations de la base de données et accepter la demande.
* Ensuite ``` php bin/console d:f:l ``` et accepter la demande pour pouvoir joué les fausses données

## 4 - Lancer le projet

* Effectué la commande suivante ``` symfony server:start ```