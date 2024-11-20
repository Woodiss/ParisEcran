-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 19 nov. 2024 à 22:15
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `casting`
--

INSERT INTO `casting` (`id`, `firstName`, `lastName`, `biography`) VALUES
(1, 'Jean', 'Dupont', 'Acteur de théâtre expérimenté.'),
(2, 'Marie', 'Curie', 'Violoniste talentueuse.'),
(3, 'Paul', 'Durand', 'Humoriste apprécié.'),
(4, 'Damien', 'Gorge', 'Acteur un peut random');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `film`
--

INSERT INTO `film` (`id`, `title`, `image`, `synopsis`, `duration`, `price`, `language`, `genre_id`) VALUES
(1, 'Roméo et Juliette', '', 'Une tragédie romantique classique.', '02:30:00', 20, 'français', 1),
(2, 'Le Comédien', '', 'Un spectacle humoristique plein de surprises.', '01:45:00', 15, 'français', 2),
(3, 'Concert Symphonique', '', 'Une performance orchestrale.', '02:00:00', 30, 'VO', 3),
(4, 'Woodis', 'woodis.jpg', 'Woodis, un héros intrépide, découvre un artefact magique lui permettant de voyager entre les mondes. Sa mission : sauver l’espace-temps menacé par une force obscure. À travers des univers fascinants et dangereux, il doit restaurer l’équilibre avant que tout ne sombre dans le chaos.', '01:55:00', 21, 'français', 2),
(5, 'DP', 'dp.jpg', 'Dans une petite ville ivoirienne, DP, un personnage farfelu et imprévisible, transforme chaque situation banale en une aventure hilarante. Entre quiproquos, idées absurdes et gags inattendus, rien ni personne n’échappe à son humour décalé. Préparez-vous à pleurer de rire dans cette comédie où l’ordinaire devient extraordinaire !', '02:05:00', 20, 'français', 2),
(6, 'Willex', 'willex.jpg', 'Lorsqu’une menace imminente met en danger la sécurité mondiale, l’élite de l’armée de l’air lance l’opération Willex. Avec courage et précision, une escouade de pilotes d’élite mène une mission à haut risque pour neutraliser l’ennemi. Entre combats aériens spectaculaires et décisions héroïques, l’avenir repose entre leurs mains.', '02:26:00', 23, 'français', 4),
(7, 'Leyn', 'leyn.jpg', 'Dans une petite ville paisible, Leyn, un individu troublant et insaisissable, sème la terreur. Manipulateur et méthodique, il plonge ses victimes dans des jeux psychologiques pervers, où la frontière entre réalité et cauchemar s’efface. Alors que la tension monte, chacun devra affronter ses propres démons pour espérer survivre.', '01:19:00', 18, 'français', 3),
(8, 'Deva', 'deva.jpg', 'Deva, un jeune danseur passionné, tombe sous le charme de Meera, une belle et talentueuse indienne. Entre chansons envoûtantes et chorégraphies éclatantes, il devra prouver que l’amour, tout comme la danse, demande courage et détermination. Une comédie musicale bollywoodienne pleine de rires, de romance et de rythmes enflammés !', '03:05:00', 24, 'français', 1),
(9, 'Magus', 'magus.jpg', 'Dans un monde où magie et ténèbres cohabitent, Arion, un jeune sorcier en quête de vérité, libère accidentellement une horde de démons scellés depuis des siècles. Pour sauver son royaume, il doit maîtriser un pouvoir ancien tout en affrontant des forces surnaturelles redoutables. Une aventure épique où le courage et la magie s’unissent pour triompher du mal.', '02:31:00', 25, 'français', 1),
(10, 'nexus', 'nexus.jpg', 'Dans un futur où l’humanité dépend d’un réseau énergétique interdimensionnel, une faille catastrophique menace de détruire la réalité. Kael, un ingénieur rebelle, découvre que cette rupture est liée à un secret enfoui dans sa propre mémoire. Entre courses-poursuites dans des mégalopoles et incursions dans des dimensions inconnues, il devra affronter des ennemis autant humains qu’extraterrestres pour sauver l’univers.', '02:10:00', 21, 'français', 1),
(11, 'Hoalbdek', 'hoalbdek.jpg', 'Lorsqu’un groupe d’amis décide d\'explorer la légendaire maison HOALBDEK, connue pour avoir englouti ses visiteurs dans des phénomènes surnaturels, ils découvrent rapidement que les rumeurs étaient bien en-deçà de la réalité. La maison, hantée par une force maléfique ancienne, joue avec leurs peurs les plus profondes, les piégeant dans un cauchemar sans fin. Survivre signifie non seulement échapper à la maison, mais aussi affronter les sombres secrets qu’ils y découvrent.', '01:40:00', 35, 'français', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `genre`
--

INSERT INTO `genre` (`id`, `name`, `helpText`) VALUES
(1, 'Animation', 'Histoires animées et colorées'),
(2, 'Action', 'Adrénaline et combats explosifs'),
(3, 'Comédie', 'Humour et situations drôles'),
(4, 'Horreur', 'Frissons et suspense terrifiants'),
(5, 'Science-Fiction', 'Futur et mondes imaginaires');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`role`, `casting_id`, `film_id`) VALUES
('Acteur principal', 1, 1),
('Acteur', 4, 1),
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `representation_id` int NOT NULL,
  `subscriber_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `spectacle_id` (`representation_id`),
  KEY `subscriber_id` (`subscriber_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `schedule`
--

INSERT INTO `schedule` (`id`, `date`, `booked`, `paid`, `amount`, `comment`, `notation`, `reactions`, `representation_id`, `subscriber_id`) VALUES
(1, '2024-12-01 20:00:00', 2, 1, 40, 'Très bon spectacle', 1, '{\"likes\": 10, \"laughs\": 3, \"dubious\": 0, \"dislikes\": 0}', 1, 1),
(2, '2024-12-05 19:00:00', 1, 1, 15, 'Spectacle amusant', 4, '{\"likes\": 5, \"laughs\": 5, \"dubious\": 0, \"dislikes\": 1}', 2, 2),
(3, '2024-12-11 18:04:45', 3, 1, 50, 'Très bon film !', 5, '{\"likes\": 10, \"laughs\": 3, \"dubious\": 0, \"dislikes\": 0}', 1, 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  ADD CONSTRAINT `schedule_ibfk_2` FOREIGN KEY (`subscriber_id`) REFERENCES `subscriber` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedule_ibfk_3` FOREIGN KEY (`representation_id`) REFERENCES `representation` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
