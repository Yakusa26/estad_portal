-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 17 juil. 2024 à 23:29
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
-- Base de données : `estad_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
CREATE TABLE IF NOT EXISTS `etudiants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(255) NOT NULL,
  `deuxieme_prenom` varchar(255) DEFAULT NULL,
  `nom_de_famille` varchar(255) NOT NULL,
  `sexe` enum('Masculin','Feminin') NOT NULL,
  `date_de_naissance` date NOT NULL,
  `quartier` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `code_postal` varchar(10) NOT NULL,
  `adresse` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `nationalite` varchar(255) NOT NULL,
  `matricule` varchar(20) DEFAULT NULL,
  `annee` varchar(20) DEFAULT NULL,
  `numero_ordre` varchar(20) DEFAULT NULL,
  `cycle` varchar(20) DEFAULT NULL,
  `niveau` varchar(20) DEFAULT NULL,
  `type_formation_id` int NOT NULL,
  `filiere_id` int DEFAULT NULL,
  `specialite_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type_formation_id` (`type_formation_id`),
  KEY `filiere_id` (`filiere_id`),
  KEY `specialite_id` (`specialite_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `prenom`, `deuxieme_prenom`, `nom_de_famille`, `sexe`, `date_de_naissance`, `quartier`, `ville`, `departement`, `code_postal`, `adresse`, `email`, `telephone`, `nationalite`, `matricule`, `annee`, `numero_ordre`, `cycle`, `niveau`, `type_formation_id`, `filiere_id`, `specialite_id`) VALUES
(1, 'eaze', 'eaze', 'eaz', 'Feminin', '2024-07-18', '', 'eaze', 'eaze', 'ezae', 'eazee', 'dqsd@dqsd.fr', 'eaze', 'eaze', 'EU3240001', '2024/2025', '220242025', 'Master', '0', 3, 1, 1),
(2, 'eaze', 'eaze', 'eaz', 'Feminin', '2024-07-18', '', 'eaze', 'eaze', 'ezae', 'eazee', 'dqsd@dqsd.fr', 'eaze', 'eaze', 'EU2240001', '2024/2025', '220242025', 'Master', 'M2', 2, 2, 8);

-- --------------------------------------------------------

--
-- Structure de la table `filieres`
--

DROP TABLE IF EXISTS `filieres`;
CREATE TABLE IF NOT EXISTS `filieres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `filieres`
--

INSERT INTO `filieres` (`id`, `libelle`) VALUES
(1, 'Informatique et Arts Numériques'),
(2, 'Énergie Renouvelable et Environnement'),
(3, 'Réseaux et Télécommunications'),
(4, 'IA (Intelligence Artificielle)'),
(5, 'Cyber Sécurité'),
(6, 'Gestion de Projet'),
(7, 'BIG DATA'),
(8, 'Ingénierie Technico-Artistique et Evénementiel');

-- --------------------------------------------------------

--
-- Structure de la table `filierespartypesformation`
--

DROP TABLE IF EXISTS `filierespartypesformation`;
CREATE TABLE IF NOT EXISTS `filierespartypesformation` (
  `type_formation_id` int NOT NULL,
  `filiere_id` int NOT NULL,
  KEY `type_formation_id` (`type_formation_id`),
  KEY `filiere_id` (`filiere_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `filierespartypesformation`
--

INSERT INTO `filierespartypesformation` (`type_formation_id`, `filiere_id`) VALUES
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 2),
(3, 3),
(4, 4),
(4, 5),
(4, 6),
(4, 7),
(2, 8),
(3, 8);

-- --------------------------------------------------------

--
-- Structure de la table `specialites`
--

DROP TABLE IF EXISTS `specialites`;
CREATE TABLE IF NOT EXISTS `specialites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `filiere_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `filiere_id` (`filiere_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `specialites`
--

INSERT INTO `specialites` (`id`, `libelle`, `filiere_id`) VALUES
(1, 'Génie Logiciel', 1),
(2, 'Infographie et Web Design', 1),
(3, 'E-commerce et Marketing', 1),
(4, 'Cyber Sécurité', 1),
(5, 'Base de Données', 1),
(6, 'Arts Numérique', 1),
(7, 'Énergie Renouvelable', 2),
(8, 'Electro Technique', 2),
(9, 'Informatique Industrielle et Automatisme', 2),
(10, 'Réseaux et Sécurité', 3),
(11, 'Télécommunications', 3);

-- --------------------------------------------------------

--
-- Structure de la table `typesformation`
--

DROP TABLE IF EXISTS `typesformation`;
CREATE TABLE IF NOT EXISTS `typesformation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `typesformation`
--

INSERT INTO `typesformation` (`id`, `libelle`) VALUES
(1, 'Cycle Préparatoire'),
(2, 'Formations Initiales'),
(3, 'Formations Continues'),
(4, 'Formations Certifiantes');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
