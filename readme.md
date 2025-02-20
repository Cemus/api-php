# API Utilisateur

Cette API permet de gérer les utilisateurs dans une base de données via des requêtes HTTP. Elle supporte les opérations suivantes :

- Créer un utilisateur.
- Récupérer la liste des utilisateurs.

## Table des matières

- [Installation]
- [Base URL]
- [Authentification]
- [EndPoints]
- [Créer un utilisateur]
- [Récupérer la liste des utilisateurs]
- [Exemples de requêtes]
- [CORS (Cross-Origin Resource Sharing)]
- [Codes de réponse HTTP]

## Installation

Prérequis
Serveur web (Apache ou Nginx) avec PHP et accès à une base de données (par exemple MySQL).
PDO (PHP Data Objects) pour la gestion de la base de données.
Étapes d'installation
Clonez ou téléchargez ce projet sur votre serveur.
Assurez-vous que la base de données est configurée et que le fichier de connexion (connexion.php) contient les bonnes informations d'accès.
Exécutez le projet sur un serveur local, comme localhost:45555.
Base URL
L'API est accessible à l'URL suivante :
http://localhost:45555/api-php/server/server.php

Authentification
Cette API ne nécessite pas d'authentification pour l'instant. Vous pouvez ajouter un système d'authentification comme un token JWT si nécessaire.

EndPoints

1. Créer un utilisateur
   Méthode : POST
   URL : /user
   Description : Crée un utilisateur avec un alias, un email et un mot de passe.
   Requête
   Le corps de la requête doit être au format JSON, par exemple :

json
Copier
{
"alias": "dzdzzddzd",
"email": "truc@email.com",
"password": "84884848azdzadazdzzad"
}
Réponse
Code 200 (Succès) : Utilisateur créé avec succès.
json
Copier
{
"message": "Utilisateur dzdzzddzd ajouté !",
"code response": 200
}
Code 400 (Données invalides) : Les données envoyées sont invalides ou incomplètes.
json
Copier
{
"message": "Donnes non trouvees",
"code response": 400
}
Code 400 (Utilisateur existant) : L'email existe déjà dans la base de données.
json
Copier
{
"message": "Existe deja",
"code response": 400
}
Code 500 (Erreur serveur) : Une erreur serveur est survenue.
json
Copier
{
"message": "Erreur serveur",
"code response": 500
} 2. Récupérer la liste des utilisateurs
Méthode : GET
URL : /users
Description : Récupère la liste de tous les utilisateurs.
Réponse
Code 200 (Succès) : Retourne la liste des utilisateurs.
json
Copier
{
"status": "success",
"data": [
{
"alias": "dzdzzddzd",
"email": "truc@email.com"
},
...
]
}
Code 200 (Aucun utilisateur) : Aucun utilisateur trouvé dans la base de données.
json
Copier
{
"status": "success",
"message": "Personne dans le coin"
}
Code 404 (Erreur) : Erreur lors de la récupération des utilisateurs.
json
Copier
{
"status": "error",
"message": "Erreur"
}
Exemples de requêtes

1. Tester l'ajout d'un utilisateur
   Utilisez Postman ou un autre outil pour envoyer une requête POST.
   URL : http://localhost:45555/api-php/server/server.php/user
   Corps de la requête en JSON :
   json
   Copier
   {
   "alias": "john_doe",
   "email": "john.doe@example.com",
   "password": "strongpassword123"
   }
   Vérifiez la réponse (Code 200 si l'utilisateur est ajouté avec succès).
2. Tester la récupération des utilisateurs
   Utilisez Postman ou un autre outil pour envoyer une requête GET.
   URL : http://localhost:45555/api-php/server/server.php/users
   Vérifiez la réponse (Code 200 avec la liste des utilisateurs ou un message indiquant qu'il n'y en a pas).
   CORS (Cross-Origin Resource Sharing)
   L'API prend en charge les en-têtes CORS pour permettre aux clients externes (comme un front-end React ou Vue.js) de faire des requêtes depuis un autre domaine. Les en-têtes CORS suivants sont utilisés dans les réponses :

Access-Control-Allow-Origin: same : Permet uniquement les requêtes provenant du même domaine.
Access-Control-Allow-Methods: POST, GET : Les méthodes HTTP autorisées pour cette API.
Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With : Les en-têtes autorisés.

## Codes de réponse HTTP

Les codes d'état suivants sont utilisés pour indiquer l'état des requêtes :

- 200 OK : La requête a réussi.
- 400 Bad Request : Les données envoyées sont invalides ou incomplètes.
- 404 Not Found : La ressource demandée n'a pas été trouvée.
- 405 Method Not Allowed : La méthode HTTP utilisée n'est pas autorisée.
- 500 Internal Server Error : Erreur interne du serveur.
