# Paris Ecran 🎭🎥

## Description  📖

Paris Ecran est une application web développée dans le cadre d'un projet scolaire. Ce projet met en avant la gestion back-end d'un projet PHP basé sur une base de données MySQL.
Paris Ecran permet de gérer l'ensemble des étapes de la gestion cinématographique, allant de l'inscription des utilisateurs à la gestion des films, des réservations, des commentaires, et bien plus encore. Il propose également des outils avancés pour l'administration et les statistiques.

# Fonctionnalités ✅

## Front-End
### 1. Pages publiques :
- Page d'accueil avec une liste des séances disponibles : ✔️ Page : index.php
- Page de connexion et de création de compte utilisateur : ✔️ Page : inscription.php

### 2. Interactions utilisateur :
- Recherche asynchrone des séances : ✔️ Page : infos-film.php?id_film=4
- Gestion des réactions sur les commentaires : ✔️ Page : infos-film.php?id_film=4
- Modification des commentaires ou de la note : ✔️ Page : profil.php
### 4. Visuel et accessibilité :
- Design responsive : ✔️ Disponible sur toutes les pages
- Carte affichant l'emplacement des cinémas : ✔️ Page : index-cinema.php

### 4. Statistiques pour les utilisateurs :
- Taux de remplissage des salles trié par ordre décroissant : ✔️ Page : average-fill-room.php
- Distribution statistique des réservations : ✔️ Page : static-reservation.php

## Back-End
### 1. Gestion des utilisateurs :
- Création d'un compte utilisateur (s'inscrire) : ✔️ Page : inscription.php
- Modification du mot de passe : ✔️ Page : update-subscriber.php?id_sub=2
- Suppression d'un compte utilisateur : ✔️ Page : all-sub.php

### 2. Gestion des films :
- Ajout d'un nouveau film : ✔️ Page : create-film.php
- Association d'un acteur à un film : ✔️ Page : update-casting.php?id_film=4
- Annulation d'un film : ✔️ Page : all-film.php
- Mise à jour des prix (inflation) : ✔️ Page : inflation.php

### 3. Gestion des réservations :
- Création d'une réservation : ✔️ Page : infos-film.php
- Ajout de places à une réservation (si non payé) : ✔️ Page : reservation.php
- Suppression d'une réservation : ✔️ Page : reservation-sub-list.php?id_sub=5

### 4. API RESTful :
- Ajouter une séance : ✔️ API : add-seance.php
- Récupérer les informations des séances : ✔️ API : getSeances.php
- Mettre à jour une réservation : ✔️ API : updateReservation.php
- Obtenir les collaborations d'acteurs : ✔️ API : getActorCollabs.php

## Base de données
### 1. Structures de la base de données :
- Fichier d'import : ✔️ parisecran.sql

### 2. Requêtes SQL avancées :
- Films par arrondissement : ✔️ Page : index-cinema.php
- Trois genres les plus réservés : ✔️ Page : best-genre.php
- Nombre moyen de places réservées : ✔️ Page : all-sub.php
- Recettes par film : ✔️ Page : films-revenue.php
- Artistes préférés des spectateurs : ✔️ Page : actor.html.php

## Bonus et autres fonctionnalités
- Génération de données avec FakerPHP : ✔️
- Ajout de réactions asynchrones : ✔️ Page : infos-film.php
- Recherche avancée dans les synopsis : ✔️ Page : index-film.php
- Intégration d'affiches générées par IA : ✔️
- Back-office complet pour les administrateurs : ✔️


---
## Technologies utilisées 💻
- ![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
- ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
- ![phpMyAdmin](https://img.shields.io/badge/phpMyAdmin-6C78AF?style=for-the-badge&logo=phpmyadmin&logoColor=white)
- ![Composer](https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white)
- ![GitHub](https://img.shields.io/badge/GitHub-181717?style=for-the-badge&logo=github&logoColor=white)
- ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

## Installation 🛠️

### Prérequis

- **Serveur web** : Apache ou Nginx.
- **Base de données** : MySQL 5.7+.
- **PHP** : Version 7.4 ou supérieure.
- **Composer** : Pour gérer les dépendances PHP.

### Étapes

1. Clonez le dépôt :
   ```bash
   git clone https://github.com/Woodiss/ParisEcran.git
    ```

2. Installez les dépendances PHP :
    ```bash
    composer install
    ```

3. Importez le fichier SQL dans votre base de données :
    ```bash
    Importer directement le fichier pariesecran.sql dans votre interface PHPmyAdmin
    ```

4. Configurez les paramètres de connexion à la base de données dans DBAL/Connector.php.

5. Lancez votre serveur web et accédez au projet via votre navigateur.

### Structure du projet
```yaml
ParisEcran/
├── composer.json           # Dépendances PHP
├── composer.lock           # Verrouillage des dépendances
├── database/
│   └── parisecran.sql      # Script SQL initial
├── public/                 # Fichiers accessibles publiquement
│   ├── index.php           # Point d'entrée principal
│   ├── api/                # Fichiers API
│   ├── css/                # Fichiers CSS
│   └── js/                 # Scripts JavaScript et requêtes asynchrone
├── src/                    # Code métier de l'application
│   ├── DBAL/               # Fichiers de connexion à la base de données
│   ├── Entity/             # Gestion des entités de l'application
│   └── views/              # Fichiers de rendu
└── README.md               # Documentation du projet
```

### Auteurs 👨‍💻

| Profil Github                                                   | Poste                  |
|-----------------------------------------------------------------|------------------------|
| [The-Leyn](https://github.com/The-Leyn)                         | Développeur Full Stack |
| [Woodiss](https://github.com/Woodiss)                           | Développeur Full Stack |
| [MrDevaa](https://github.com/MrDevaa)                           | Développeur Back End   |
| [christopherDEPASQUAL](https://github.com/christopherDEPASQUAL) | Développeur Full Stack |
| [Amaury057](https://github.com/Amaury057)                       | Développeur Full Stack |


## Remerciements 💬

- Un grand merci à Michel CADENNES, notre professeur BACK de PHP/SQL, pour son accompagnement, ses conseils précieux tout au long de ce projet. Grâce à son expertise, nous avons pu approfondir nos compétences techniques et mener à bien ce travail.
Nous remercions également l'école HETIC pour nous avoir offert cette opportunité d'apprentissage et les moyens nécessaires pour réaliser ce projet ambitieux.


## Licence 📜

Ce projet est protégé par des droits. Il ne peut pas être utilisé, modifié ou distribué à des fins lucratives sans autorisation préalable.