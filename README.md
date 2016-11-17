
# JSON exposure implementation on Symfony 3 micro-framework
- Author : Tanguy Bodin-Hullin

## Presentation

This app is a small project which goal is to :
- use Symfony MicroFramework to expose some JSON data as a server.
- implement the JWT (JSON Web Token) security standard to secure the recovering of these data.

## Technologies
### MicroKernelTrait

The **MicroKernelTrait** allows you to create a fully-functional Symfony application in as little as one file. It allows you to start with a tiny application, and then add features and structure as you need to. Its goal to give you the power to choose your bundles and structure.

### JSON Web Token (JWT)

JSON Web Token is an open standard allowing two parts to exchange informations encapsulated in a numerically signed token.
It is used to implement some SSO authentication solutions or webservices security.

### LexikJWTAuthenticationBundle
This bundle provides JWT (JSON Web Token) authentication for your Symfony REST API default using the namshi/jose library.
In other terms, it allows to protect your REST API
It requires Symfony 2.8+ (and the OpenSSL library if you intend to use the default provided encoder)

The key used in the JWT can be a pair of SSH RSA Keys
These keys must first be generated and put in the /var/jwt/ path

### Ma27ApiKeyAuthenticationBundle

**This part is not finished yet**

## Basic Usage

Once installed, go to the URL
- /app_dev/json/example to see the JSON exposed.

_______________
## for FRENCH people : Introduction :
Symfony 2.8 a introduit un nouveau trait appelé microkernel
qui permet de simplifier grandement la création de petites applications Symfony
C'est cette fonctionnalité qui est ici utilisée pour exposer de simples données en JSON.

*Lisez le fichier LISEZ_MOI.md*

JSON Web Token (JWT, que les anglophones prononcent jot) est un standard ouvert permettant à deux parties d’échanger de manière sûre des informations encapsulées dans un jeton signé numériquement.
En pratique, JWT est utilisé pour mettre en oeuvre des solutions d’authentification SSO ou de sécurisation de web services.
_______________


## Steps followed to create this project (if you want to learn..)

# 1) Create a new symfony-micro project with [Composer](https://getcomposer.org/).

```bash
composer create-project ikoene/symfony-micro
```

# 2) Add the Security Bundles

You need to choose and install one of the following bundles to implement the security :
- either *LexikJWTAuthenticationBundle*
- or *Ma27ApiKeyAuthenticationBundle*

# 3) Generate the Keys for JWT authentication

See : https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md
The generated keys must be stored in /app/var/jwt/ directory

## References :

### A - Symfony MicroFramework
- http://symfony.com/blog/new-in-symfony-2-8-symfony-as-a-microframework"
- https://knpuniversity.com/screencast/new-in-symfony3/micro-kernel

### B - Security Bundle
- http://jolicode.github.io/SecurityBundle-avec-de-l-aspirine (in french)

### C - JSON Web Token (JWT)
- http://blog.inovia-conseil.fr/?p=236 (in french)
