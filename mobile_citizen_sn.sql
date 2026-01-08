-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 08 jan. 2026 à 11:31
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mobile_citizen_sn`
--

-- --------------------------------------------------------

--
-- Structure de la table `intervenant`
--

DROP TABLE IF EXISTS `intervenant`;
CREATE TABLE IF NOT EXISTS `intervenant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(245) NOT NULL,
  `nom` varchar(245) NOT NULL,
  `sexe` varchar(45) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sn_categorie`
--

DROP TABLE IF EXISTS `sn_categorie`;
CREATE TABLE IF NOT EXISTS `sn_categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(245) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sn_document`
--

DROP TABLE IF EXISTS `sn_document`;
CREATE TABLE IF NOT EXISTS `sn_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(245) NOT NULL,
  `categorie` int(11) NOT NULL,
  `fichier` varchar(245) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sn_document_categorie_idx` (`categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sn_evenemement_intervenant`
--

DROP TABLE IF EXISTS `sn_evenemement_intervenant`;
CREATE TABLE IF NOT EXISTS `sn_evenemement_intervenant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `intervenant` int(11) NOT NULL,
  `evenement` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sn_evenemement_participant_participant_idx` (`intervenant`),
  KEY `fk_sn_evenemement_participant_evenement_idx` (`evenement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sn_evenement`
--

DROP TABLE IF EXISTS `sn_evenement`;
CREATE TABLE IF NOT EXISTS `sn_evenement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(245) NOT NULL,
  `description` text NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `type` varchar(245) NOT NULL,
  `lieu` varchar(245) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sn_membre`
--

DROP TABLE IF EXISTS `sn_membre`;
CREATE TABLE IF NOT EXISTS `sn_membre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(245) DEFAULT NULL,
  `nom` varchar(245) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `sn_podcast`
--

DROP TABLE IF EXISTS `sn_podcast`;
CREATE TABLE IF NOT EXISTS `sn_podcast` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(245) NOT NULL,
  `description` text NOT NULL,
  `membre` int(11) NOT NULL,
  `fichier` varchar(245) NOT NULL,
  `categorie` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sn_podcast_categorie_idx` (`categorie`),
  KEY `fk_sn_podcast_membre_idx` (`membre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `sn_document`
--
ALTER TABLE `sn_document`
  ADD CONSTRAINT `fk_sn_document_categorie` FOREIGN KEY (`categorie`) REFERENCES `sn_categorie` (`id`);

--
-- Contraintes pour la table `sn_evenemement_intervenant`
--
ALTER TABLE `sn_evenemement_intervenant`
  ADD CONSTRAINT `fk_sn_evenemement_participant_evenement` FOREIGN KEY (`evenement`) REFERENCES `sn_evenement` (`id`),
  ADD CONSTRAINT `fk_sn_evenemement_participant_participant` FOREIGN KEY (`intervenant`) REFERENCES `intervenant` (`id`);

--
-- Contraintes pour la table `sn_podcast`
--
ALTER TABLE `sn_podcast`
  ADD CONSTRAINT `fk_sn_podcast_categorie` FOREIGN KEY (`categorie`) REFERENCES `sn_categorie` (`id`),
  ADD CONSTRAINT `fk_sn_podcast_membre` FOREIGN KEY (`membre`) REFERENCES `sn_membre` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
