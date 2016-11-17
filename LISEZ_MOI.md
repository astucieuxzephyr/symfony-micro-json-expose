
# SfMicro 3.0 app for exposing JSON data
- Author : Tanguy Bodin-Hullin

## Introduction :
*Symfony 2.8* a introduit un nouveau trait appelé *microkernel*
qui permet de simplifier grandement la création de petites applications Symfony
C'est cette fonctionnalité qui est ici utilisée pour exposer de simples données en JSON.

Notre objectif était ici d'ajouter une couche de sécurité permettant une récupération sécurisée de ces données.
La couche de sécurité choisie ici est le *standard JWT (Json Web Token)*
Pour implémenter cette couche, l'idée est d'utiliser LexikJWTAuthenticationBundle

Une autre couche de sécurité qui pourrait être utilisée serait le Ma27ApiKeyAuthenticationBundle

## Rappel technique sur les jetons JWT (JSON Web Token)

*JSON Web Token* (JWT, que les anglophones prononcent jot) est un standard ouvert permettant à deux parties d’échanger de manière sûre des informations encapsulées dans un *jeton signé numériquement*.
En pratique, JWT est utilisé pour mettre en oeuvre des solutions d’authentification SSO ou de sécurisation de web services.

Bien que le protocole *OAuth 2* soit très utilisé par des plateformes à forte audience exposant une API web,
JWT apparaît dans beaucoup de cas d’utilisation comme une *alternative intéressante car beaucoup plus simple à mettre en oeuvre* et stateless (le jeton n’est pas stocké dans une base de données, ce qui rend la solution adaptée aux transactions HTTP et adaptée et donc scalable).

Dans la pratique, un *jeton JWT* est une *chaîne de caractères décomposable en 3 sections séparées par un point*
*[entete].[charge utile].[clé privée de signature]*

1) L'*entete* contient des méta-données JSON, encodé en base 64. Il doit contenir au minimum le type de jeton et l’algorithme de chiffrement utilisé pour le signer numériquement.

2) La *charge utile* est un document au format JSON encodé en base 64, contenant des données fonctionnelles minimales que l’on souhaite transmettre au service (ces propriétés sont appelées claims ou revendications selon la terminologie de la RFC).
En pratique, on y fait transiter des informations sur l’identité de l’utilisateur (login, nom complet, rôles, etc.).
Il ne doit pas contenir de données sensibles.

3) La *signature numérique* du jeton est une *clé privée utilisée pour signer le jeton*, et *qui est stockée côté serveur*.

### Exemple concret

Dans cet exemple, le client a besoin de demander au serveur une liste de comptes.
Il s'agit d'une information protégée et le serveur ne peut pas fournir cette liste à n'importe qui.

1) Le *client* commence par demander au serveur une ressource via une requete :
GET /api/restricted/accounts

2) Cette demande n'étant pas sécurisée,
le *serveur* renvoie une erreur HTTP/1.1 401 avec un message "Jeton invalide"

3) Le *client* comprend qu'il faut une authentification,
il lance donc une nouvelle requete POST /api/authenticate
Cette requete POST inclut un couple username=xxx/password=yyy

4) Le *serveur* accepte cette authentification si elle est valide :
il génère un jeton JWT (token) (voir plus haut pour la composition de ce jeton)
{"token": "eyJ0esdlflf.hhpz15efl.zdsSDflzjf"}
(Si l'authentification n'est pas valide il renvoie bien sûr une erreur HTTP 401)

5) Le *client* récupère le jeton JWT
Il réenvoie une requete GET /api/restricted/accounts
mais dans la partie Authorization de la requete HTTP/1.1, il ajoute le jeton JWT.
On a ainsi :
Authorization: Bearer eyJ0esdlflf.hhpz15efl.zdsSDflzjf

6) Le *serveur* voit que cette demande est sécurisée. Il vérifie le jeton JWT, et s'il le valide,
il renvoie les données au client dans une requete HTTP/1.1 200
Par exemple :
[
  {"name":"Account 0"},
  {"name":"Account 1"}
]

7) Le *client* récupère les données souhaitées !

Nous avons vu au travers de cet exemple que le serveur doit exposer 2 services :
- un service *d’authentification* POST :
POST /api/authenticate
- un service GET *à accès restreint* retournant par exemple une liste de comptes :
GET /api/restricted/accounts

## Utilisation

### Pour accéder à l'exemple sur localhost (en mode dev) :
http://symfonymicro/app_dev.php/api/example

Pour accéder à l'exemple (en mode prod)
http://symfonymicro/app.php/api/example


## Optionnel : Utilisation du bundle ma27/api-key-authentication-bundle
*ATTENTION  : l'implémentation avec ce bundle n'est pas fonctionnelle pour le moment !!*
 - 1) Il faut décommenter la ligne d'import du bundle dans la fonction registerBundles
du fichier /MicroKernel.php
 - 2) Le fichier de config de ce bundle a été appelé params_ma27apikeyauthentication.yml
Cette configuration doit être importée dans la config standard (config.yml).
Une ligne d'import a été ajoutée. Il suffit de décommenter cette ligne dans le fichier config.yml


## Description :

- Le controleur principal est dans AppBundle/Controller/DefaultController.php
- Il définit deux routes :
  - / (route index par défaut)
  - /app_dev.php/json/example
- Le controleur Test situé dans AppBundle/Tests/Controller/DefaultControllerTest.php

## Configuration Apache2 pour votre projet SymfonyMicro
Attention : Bien mettre le dossier *web* comme dossier terminal du DocumentRoot

### Windows
    <VirtualHost SymfonyMicro>
        ServerAdmin tanguybh2@hotmail.com
        DocumentRoot "C:/wamp/www/sfmicro/web"
        ServerName SymfonyMicro
    	RewriteEngine On
        RewriteCond %{HTTP:Authorization} ^(.*)
        RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
        ErrorLog "logs/SymfonyMicro-error.log"
        CustomLog "logs/SymfonyMicro-access.log" common
    </VirtualHost>

### Linux (Ubuntu for Windows)

    <VirtualHost *:80>
        ServerAdmin tanguybh2@hotmail.com
        DocumentRoot /mnt/c/wamp/www/sfmicro/web
        ServerName symfonymicro

        RewriteEngine On
        RewriteCond %{HTTP:Authorization} ^(.*)
        RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]

        ErrorLog ${APACHE_LOG_DIR}/SymfonyMicro_error.log
        CustomLog ${APACHE_LOG_DIR}/SymfonyMicro_access.log combined
    </VirtualHost>

## D - Etapes permettant de reproduire la création de ce projet

Ces étapes sont détaillées ici pour ceux qui veulent comprendre comment ce projet a été implémenté.

### 1) Créer un projet ikoene/symfony-micro avec [Composer](https://getcomposer.org/).

```bash
composer create-project ikoene/symfony-micro
```

### 2) Ajouter les bundles correspondant à la couche de sécurité

D'abord, il faut ajouter
- *symfony/security* bundle

Puis vous devez choisir et installer l'un des bundles suivants pour implémener la sécurité de vos données JSON
- soit *LexikJWTAuthenticationBundle* (pour l'authentification par jeton JWT)
- soit *Ma27ApiKeyAuthenticationBundle* (pas encore terminé ...)

Voici les commandes utilisées pour installer les bundles de sécurité
```` bash
$ composer require symfony/security
$ composer require lexik/jwt-authentication-bundle
$ composer require ma27/api-key-authentication-bundle
````

- Il faut ensuite ajouter les bundles voulus dans le fichier MicroKernel.php

ainsi que pramétrer les fichiers :
- config/config.yml
- parameters.yml
- config/security.yml


### 3) Generer les clés pour l'authentification JWT

Voir : https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md
Les clés doivent être stockées dans /app/var/jwt/ directory

## Références utiles :

### A - Symfony MicroFramework
- http://symfony.com/blog/new-in-symfony-2-8-symfony-as-a-microframework"
- https://knpuniversity.com/screencast/new-in-symfony3/micro-kernel

### B - Security Bundle
- http://jolicode.github.io/SecurityBundle-avec-de-l-aspirine

### C - JSON Web Token (JWT)
- http://blog.inovia-conseil.fr/?p=236

### D - Créer une API REST avec Symfony
- https://zestedesavoir.com/tutoriels/1280/creez-une-api-rest-avec-symfony-3/amelioration-de-lapi-rest/securisation-de-lapi-2-2/
