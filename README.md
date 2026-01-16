# Guide Intégration API Mobile Citizen SN

# Pre requis

PHP > 8.2

# Demarer le projet

## 1. Cloner le projet

Faites `git clone https://github.com/KanyC11/AppmobileBackCLS.git`

## 2. Installation des dependances

Faites un `composer install`

## 3. Configurer l'environnement

Taper `cp .env.example .env`

## 4. Générer la clé d'application

`php artisan key:generate`

## 5. Migration de la base de données

php artisan migrate

## 6. Lancer le serveur

`php artisan serve`

## API accessible via :

Développement : http://127.0.0.1:8000/api

## POINTS D'ACCÈS :

Points d’accès GET pour consultation, téléchargement ou streaming
Catégories

## Lister toutes les catégories :

GET http://127.0.0.1:8000/api/categories

## Voir une catégorie :

GET http://127.0.0.1:8000/api/categories/{id}

## Créer une catégorie :

POST http://127.0.0.1:8000/api/categories
Supprimer une catégorie :
DELETE http://127.0.0.1:8000/api/categories/{id}

## Documents

### Lister tous les documents :

GET http://127.0.0.1:8000/api/documents

### Voir un document :

GET http://127.0.0.1:8000/api/documents/{id}

### Créer un document :

POST http://127.0.0.1:8000/api/documents
Supprimer un document :
DELETE http://127.0.0.1:8000/api/documents/{id}

## Événements

### Lister tous les événements :

GET http://127.0.0.1:8000/api/evenements

### Voir un événement :

GET http://127.0.0.1:8000/api/evenements/{id}

### Créer un événement :

POST http://127.0.0.1:8000/api/evenements

### Supprimer un événement :

DELETE http://127.0.0.1:8000/api/evenements/{id}

## Intervenants

### Lister tous les intervenants :

GET http://127.0.0.1:8000/api/intervenants

### Voir un intervenant :

GET http://127.0.0.1:8000/api/intervenants/{id}

### Créer un intervenant :

POST http://127.0.0.1:8000/api/intervenants

### Supprimer un intervenant :

DELETE http://127.0.0.1:8000/api/intervenants/{id}

## Evenement_intervenant

### Lister tous les intervenants :

GET http://127.0.0.1:8000/api/evenement-intervenants

## Membres

### Lister tous les membres :

GET http://127.0.0.1:8000/api/membres

### Voir un membre :

GET http://127.0.0.1:8000/api/membres/{id}

### Créer un membre :

POST http://127.0.0.1:8000/api/membres

### Mettre à jour un membre :

PUT http://127.0.0.1:8000/api/membres/{id}

### Supprimer un membre :

DELETE http://127.0.0.1:8000/api/membres/{id}

## Podcasts

### Lister tous les podcasts :

GET http://127.0.0.1:8000/api/podcasts

### Voir un podcast :

GET http://127.0.0.1:8000/api/podcasts/{id}

### Créer un podcast :

POST http://127.0.0.1:8000/api/podcasts

### Mettre à jour un podcast :

PUT http://127.0.0.1:8000/api/podcasts/{id}

### Supprimer un podcast :

DELETE http://127.0.0.1:8000/api/podcasts/{id}

### Télécharger un podcast :

GET http://127.0.0.1:8000/api/podcasts/{id}/download

### Streamer un podcast :

GET http://127.0.0.1:8000/api/podcasts/{id}/stream

### Récupère les 8 derniers podcasts

GET http://127.0.0.0:8000/api/lastpodcasts

## Dashboard

### Obtenir toutes les données pour le dashboard :

GET http://127.0.0.1:8000/api/dashboard
