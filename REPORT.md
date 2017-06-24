# Travail accompli :

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
- Doctrine fixtures pour pré-remplir une base de données (simple à mettre en place)
- Symfony serializer pour sérializer les entités (permet de choisir que renvoyer à l'utilisateur de l'API et de faire ça dans un service)
- Symfony Guard pour la sécurité
- Utilisation de Bootstrap

## Tests

- Tests unitaires de la plupart des services
- Petit test fonctionnel avec WebTestCase