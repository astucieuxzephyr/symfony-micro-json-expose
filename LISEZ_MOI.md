
# ==== SfMicro 3.0 app for exposing JSON data ====
Author : Tanguy Bodin-Hullin

## Introduction :
Symfony 2.8 a introduit un nouveau trait appelé microkernel
qui permet de simplifier grandement la création de petites applications Symfony
C'est cette fonctionnalité qui est ici utilisée pour exposer de simples données en JSON.

### Exemple pour accéder à l'appli sur localhost (en mode dev) :
http://symfonymicro/app_dev.php/json/example ====> une erreur apparait

### Exemple en mode prod :
http://symfonymicro/app.php/json/example


## References :

### References - MicroFramework
http://symfony.com/blog/new-in-symfony-2-8-symfony-as-a-microframework"
https://knpuniversity.com/screencast/new-in-symfony3/micro-kernel

### References - Security Bundle
http://jolicode.github.io/SecurityBundle-avec-de-l-aspirine


## Pour rappel
j'ai installé deux bundles pour tenter d'ajouter une clé / token sur l'API JSON...
- LexikJWTAuthenticationBundle
- Ma27ApiKeyAuthenticationBundle

# Commandes utilisées pour installer les bundles de sécurité :
- composer require symfony/security
- composer require lexik/jwt-authentication-bundle
- composer require ma27/api-key-authentication-bundle

Voir le fichier MicroKernel.php où ces bundles sont instanciés OU PAS
ainsi que :
- config/config.yml
- parameters.yml
- config/security.yml


## Utilisation du bundle ma27/api-key-authentication-bundle
 - 1) Il faut décommenter la ligne d'import du bundle dans la fonction registerBundles
du fichier /MicroKernel.php
 - 2) Le fichier de config de ce bundle a été appelé params_ma27apikeyauthentication.yml
Cette configuration doit être importée dans la config standard (config.yml).
Une ligne d'import a été ajoutée. Il suffit de décommenter cette ligne dans le fichier config.yml

___
## Description :

- Le controleur principal est dans AppBundle/Controller/DefaultController.php
- Il définit deux routes :
  - / (route index par défaut)
  - /app_dev.php/json/example
- Le controleur Test situé dans AppBundle/Tests/Controller/DefaultControllerTest.php

___
## ==== Config Apache2 pour projet SymfonyMicro ====
Attention : Bien mettre le dossier web

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
# SfMicro
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
