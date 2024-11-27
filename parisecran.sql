-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 14 nov. 2024 à 16:25
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `parisecran`
--

-- --------------------------------------------------------

--
-- Structure de la table `casting`
--

DROP TABLE IF EXISTS `casting`;
CREATE TABLE IF NOT EXISTS `casting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `biography` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `casting`
--

INSERT INTO `casting` (`id`, `firstName`, `lastName`, `biography`) VALUES
(1, 'Jean', 'Dupont', 'Acteur de théâtre expérimenté.'),
(2, 'Marie', 'Curie', 'Violoniste talentueuse.'),
(3, 'Paul', 'Durand', 'Humoriste apprécié.');

-- --------------------------------------------------------

--
-- Structure de la table `cinema`
--

DROP TABLE IF EXISTS `cinema`;
CREATE TABLE IF NOT EXISTS `cinema` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `presentation` text,
  `address` text,
  `borough` varchar(255) DEFAULT NULL,
  `geolocation` point DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cinema`
--

INSERT INTO `cinema` (`id`, `name`, `presentation`, `address`, `borough`, `geolocation`, `phone`, `email`) VALUES
(1, 'Grand Théâtre', 'Un grand théâtre situé au centre-ville.', '123 Rue Principale', 'Centre', NULL, '1234567890', 'contact@grandtheatre.com'),
(2, 'Petit Théâtre', 'Un théâtre intime pour les petits spectacles.', '45 Rue des Artistes', 'Nord', NULL, '0987654321', 'info@petittheatre.com');

-- --------------------------------------------------------

--
-- Structure de la table `film`
--

DROP TABLE IF EXISTS `film`;
CREATE TABLE IF NOT EXISTS `film` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `synopsis` text,
  `duration` time DEFAULT NULL,
  `price` float DEFAULT NULL,
  `language` enum('français','VO','surtitré','audio') DEFAULT NULL,
  `genre_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`genre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `film`
--

INSERT INTO `film` (`id`, `title`, `image`, `synopsis`, `duration`, `price`, `language`, `genre_id`) VALUES
(1, 'Roméo et Juliette', '', 'Une tragédie romantique classique.', '02:30:00', 20, 'français', 1),
(2, 'Le Comédien', '', 'Un spectacle humoristique plein de surprises.', '01:45:00', 15, 'français', 2),
(3, 'Concert Symphonique', '', 'Une performance orchestrale.', '02:00:00', 30, 'VO', 3);

-- --------------------------------------------------------

--
-- Structure de la table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `helpText` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id`, `name`, `helpText`) VALUES
(1, 'Théâtre', 'Représentations théâtrales'),
(2, 'Comédie', 'Spectacles humoristiques'),
(3, 'Concert', 'Performances musicales'),
(4, 'Danse', 'Performances de danse');

-- --------------------------------------------------------

--
-- Structure de la table `representation`
--

DROP TABLE IF EXISTS `representation`;
CREATE TABLE IF NOT EXISTS `representation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_date` datetime NOT NULL,
  `last_date` datetime NOT NULL,
  `film_id` int NOT NULL,
  `room_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `spectacle_id` (`film_id`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `representation`
--

INSERT INTO `representation` (`id`, `first_date`, `last_date`, `film_id`, `room_id`) VALUES
(1, '2024-12-01 20:00:00', '2024-12-01 22:30:00', 1, 1),
(2, '2024-12-05 19:00:00', '2024-12-05 20:45:00', 2, 2),
(3, '2024-12-10 21:00:00', '2024-12-10 23:00:00', 3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `role` varchar(100) NOT NULL,
  `casting_id` int NOT NULL,
  `film_id` int NOT NULL,
  PRIMARY KEY (`casting_id`,`film_id`,`role`),
  KEY `spectacle_id` (`film_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`role`, `casting_id`, `film_id`) VALUES
('Acteur principal', 1, 1),
('Comédien', 3, 2),
('Violoniste', 2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `room`
--

DROP TABLE IF EXISTS `room`;
CREATE TABLE IF NOT EXISTS `room` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `gauge` int DEFAULT NULL,
  `cinema_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `theatre_id` (`cinema_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `room`
--

INSERT INTO `room` (`id`, `name`, `gauge`, `cinema_id`) VALUES
(1, 'Salle Principale', 500, 1),
(2, 'Salle Intime', 200, 2);

-- --------------------------------------------------------

--
-- Structure de la table `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `booked` int DEFAULT '0',
  `paid` tinyint(1) DEFAULT '0',
  `amount` float DEFAULT NULL,
  `comment` text,
  `notation` int DEFAULT NULL,
  `reactions` json DEFAULT NULL,
  `film_id` int NOT NULL,
  `subscriber_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `spectacle_id` (`film_id`),
  KEY `subscriber_id` (`subscriber_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `schedule`
--

INSERT INTO `schedule` (`id`, `date`, `booked`, `paid`, `amount`, `comment`, `notation`, `reactions`, `film_id`, `subscriber_id`) VALUES
(1, '2024-12-01 20:00:00', 2, 1, 40, 'Très bon spectacle', 5, '{\"likes\": 10, \"laughs\": 3, \"dubious\": 0, \"dislikes\": 0}', 1, 1),
(2, '2024-12-05 19:00:00', 1, 1, 15, 'Spectacle amusant', 4, '{\"likes\": 5, \"laughs\": 5, \"dubious\": 0, \"dislikes\": 1}', 2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `subscriber`
--

DROP TABLE IF EXISTS `subscriber`;
CREATE TABLE IF NOT EXISTS `subscriber` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthdate` datetime DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `subscriber`
--

INSERT INTO `subscriber` (`id`, `username`, `password`, `email`, `birthdate`, `first_name`, `last_name`) VALUES
(1, 'jdoe', 'password123', 'jdoe@example.com', '1990-01-01 00:00:00', 'John', 'Doe'),
(2, 'asmith', 'password456', 'asmith@example.com', '1985-05-20 00:00:00', 'Anna', 'Smith');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `film`
--
ALTER TABLE `film`
  ADD CONSTRAINT `film_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE SET NULL;

--
-- Contraintes pour la table `representation`
--
ALTER TABLE `representation`
  ADD CONSTRAINT `representation_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `representation_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `role_ibfk_1` FOREIGN KEY (`casting_id`) REFERENCES `casting` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_ibfk_2` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`cinema_id`) REFERENCES `cinema` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`film_id`) REFERENCES `film` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`subscriber_id`) REFERENCES `subscriber` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
