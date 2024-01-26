# Répartion des tâches lors de la réalisation du **micro-service Planning** du projet "Cht'eduque"

### Réalisé par Quentin Leuliet et Julian Wicke

## Tâches de Quentin

- Initialisation du projet symfony
  - Création du projet
  - Installation des dépendences
  - Configuration de l'environnement
- Initialisation du git

- API Planning : 
  - Gestion global des requêtes & redirection en fonction du type de requête
    - Redirection dans le code vers les fonctions adaptés en fonction du type de requête & de la route
    - Création des controllers
  - Route */Lessons* : 
    - Fonction pour la request GET
      - Système de recherche dans la bdd
      - Possibilité d'ajoute des arguments pour trier et consulter des données précis
      - Gestion des erreurs associés
  - Fonction pour la request POST
    - Système d'ajout d'un nouvelle élément dans la base de donnée - - Gestion des erreurs associés
    - Route /ClassStudents :
  - Fonction pour la request GET
    - Système de recherche dans la bdd
    - Possibilité d'ajoute des arguments pour trier et consulter des données précis
    - Gestion des erreurs associés
  - Fonction pour la request POST
    - Système d'ajout d'un nouvelle élément dans la base de donnée
    - Gestion des erreurs associés


## Tâches de Julian

- Pour la route *\Lessons* : 
  - Fonction pour la requête PUT
    - Système de remplacement d'un élément dans la base de donnée
    - Gestion des erreurs associés
  - Fonction pour la requête PATCH
    - Système de modification d'un élément dans la base de donnée
    - Gestion des erreurs associés
  - Fonction pour la requête DELETE
    - Système de suppression d'un élément dans la base de donnée
    - Gestion des erreurs associés

- Pour la route *\ClassStudents* :
  - Fonction pour la requête PUT
    - Système de remplacement d'un élément dans la base de donnée
    - Gestion des erreurs associés
  - Fonction pour la requête PATCH
    - Système de modification d'un élément dans la base de donnée
    - Gestion des erreurs associés
  - Fonction pour la requête DELETE
    - Système de suppression d'un élément dans la base de donnée
    - Gestion des erreurs associés

- Documentation collection Postman
  - Création de la collection
  - Création des requêtes

- Mise en production sur AWS :
  - Création d'une instance EC2
  - Création d'une clé SSH
  - Installation et configuration du serveur Apache
  - Installation de la base de données  

## Fait en commun 
- Création d'un readme
  - Création d'un fichier markdown pour la documentation
  - Explication de l'installation du projet
  - Explication de l'installation de la base de données
  - Explication des différentes routes et de leurs fonctionnements