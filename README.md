# Comment lancer le projet Super Collect

## 1 - Télécharger le projet 

### A - Depuis GitHub

1. Aller sur le repository GitHub de Super Collect [ici](https://github.com/DylanGrouchetzky/soutenance3WA) 
2. Récupérer le lien SSH ou HTTPS (comme vous préférez)
3. Dans votre terminal de commande taper :
```git 
    git clone lienGitHub .
```
Le point sert a cloner dans le dossier oû vous êtes présent

### B - Depuis votre

1. copier cette url : " https://github.com/DylanGrouchetzky/soutenance3WA.git "
2. Dans votre terminal de commande taper :
```git 
    git clone lienGitHub .
```
Le point sert a cloner dans le dossier oû vous êtes présent

## 2 - Installer/Update Composer

Dans le dossier Super Collect qui vient d'être créé ou dans le dossier oû vous avez faits l'installation :

1. Dans terminal de commande taper la commande suivante pour installer composer :
```composer
composer install
```
2. Puis la suivante pour mettre le mettre à jour :
```composer
composer update
```

## 3 - Installer la base de donnée

Une fois composer installé et mis à jour ils vous faudra faire :

1. Copier le fichier " .env " et le renomer " .env.local " 
2. Modifier la variable de " #DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/baseDeDonnee" avec vos donnée de connection MySql(nom d'utilisateur, mot de passe et nom de la base de données)
3. Taper la commande suivante dans le terminal pour créé la base de donnée:
```php
php bin/console d:d:c
```
4. Puis la commende suivante vas permettre de joué les migrations:
```php
php bin/console d:m:m
```
5.Ensuite pour joué les fausses donnée présente ;
```php
php bin/onsole d:f:l
```

## 4 - Lancer le projet

1. Effectué la commande suivante 
```php 
symfony server:start 
```