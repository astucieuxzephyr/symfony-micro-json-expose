=======================================
# Information :
=======================================



See : https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md

# Génération des clés SSH (Generate the SSH keys)
===============================================
$ mkdir -p app/var/jwt
$ openssl genrsa -out app/var/jwt/private.pem -aes256 4096
$ openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem

ou plus simplement, avec des clés très courtes :
------------------------------------------------
$ mkdir -p app/var/jwt
$ openssl genrsa -out app/var/jwt/private.pem 1024
$ openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem


====================
"""TESTING : VOIR
https://github.com/slashfan/LexikJWTAuthenticationBundleSandbox

Installation du slashfan/LexikJWTAuthenticationBundleSandbox :
1) Changer la minimum-stability ??

2)
$ composer require slashfan/jwt-authentication-bundle-sandbox
