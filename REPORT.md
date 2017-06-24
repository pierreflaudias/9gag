# Travail accompli :

# Pierre FLAUDIAS et Antoine ALBESSARD

## Site fonctionnel

- Site de base 9GAG
- Possiblité de créer un post (appelé LOL) avec titre et image
- Possibilité de commenter et upvoter/downvoter ce post (autant de fois que l'on veut pas de gestion par utilisateur)
- Possibilté de supprimer (post et commentaire)
- Authentification (pour toute action de modification)

## API

- Mêmes fonctionnalités que le site
- Authentification par token (créer un compte pour avoir un token)

## Outils utilisés

- Docker pour la base de données
- Doctrine fixtures pour pré-remplir une base de données (simple à mettre en place et utilise les commandes Symfony)
- Symfony serializer pour sérializer les entités (permet de choisir quels attributs renvoyer à l'utilisateur de l'API et de faire le dans un service)
- Symfony Guard pour la sécurité (authentification simple et customizable avec un firewall et un token)
- Utilisation de Bootstrap

## Tests

- Tests unitaires de la plupart des services
- Petit test fonctionnel avec WebTestCase
