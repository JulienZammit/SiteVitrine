-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 19 avr. 2022 à 19:01
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pinfclean`
--

-- --------------------------------------------------------

--
-- Structure de la table `activites_disponibles`
--

DROP TABLE IF EXISTS `activites_disponibles`;
CREATE TABLE IF NOT EXISTS `activites_disponibles` (
  `id_acti_dispo` int(11) NOT NULL AUTO_INCREMENT,
  `activite` int(11) NOT NULL,
  `creneaux` int(11) NOT NULL,
  `est_dispo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_acti_dispo`),
  KEY `activite` (`activite`),
  KEY `creneaux` (`creneaux`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `activites_disponibles`
--

INSERT INTO `activites_disponibles` (`id_acti_dispo`, `activite`, `creneaux`, `est_dispo`) VALUES
(1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `blog`
--

DROP TABLE IF EXISTS `blog`;
CREATE TABLE IF NOT EXISTS `blog` (
  `titre` varchar(500) NOT NULL,
  `texte` varchar(5000) NOT NULL,
  `date` date NOT NULL,
  `archive` int(11) NOT NULL,
  `idActu` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(2000) NOT NULL,
  PRIMARY KEY (`idActu`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_type_activite` int(11) NOT NULL AUTO_INCREMENT,
  `type_activite` varchar(255) NOT NULL,
  PRIMARY KEY (`id_type_activite`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_type_activite`, `type_activite`) VALUES
(1, 'Triathlon'),
(2, 'Natation'),
(3, 'Piscine');

-- --------------------------------------------------------

--
-- Structure de la table `creneaux_horaires`
--

DROP TABLE IF EXISTS `creneaux_horaires`;
CREATE TABLE IF NOT EXISTS `creneaux_horaires` (
  `id_crénaux` int(11) NOT NULL AUTO_INCREMENT,
  `debut` datetime NOT NULL,
  `fin` datetime NOT NULL,
  PRIMARY KEY (`id_crénaux`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `creneaux_horaires`
--

INSERT INTO `creneaux_horaires` (`id_crénaux`, `debut`, `fin`) VALUES
(1, '2022-04-20 08:30:00', '2022-04-20 09:15:00');

-- --------------------------------------------------------

--
-- Structure de la table `faq`
--

DROP TABLE IF EXISTS `faq`;
CREATE TABLE IF NOT EXISTS `faq` (
  `id_question` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `reponse` varchar(1024) NOT NULL,
  PRIMARY KEY (`id_question`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `oubli`
--

DROP TABLE IF EXISTS `oubli`;
CREATE TABLE IF NOT EXISTS `oubli` (
  `id_oubli` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id_oubli`),
  KEY `id_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
  `id_reservation` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur` int(11) NOT NULL,
  `activite_reservee` int(11) NOT NULL,
  `statut` int(11) NOT NULL,
  PRIMARY KEY (`id_reservation`),
  KEY `utilisateur` (`utilisateur`),
  KEY `activite_reservee` (`activite_reservee`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `utilisateur`, `activite_reservee`, `statut`) VALUES
(2, 1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `sports`
--

DROP TABLE IF EXISTS `sports`;
CREATE TABLE IF NOT EXISTS `sports` (
  `id_activité` int(11) NOT NULL AUTO_INCREMENT,
  `type_activité` int(11) NOT NULL,
  `nomsport` varchar(255) NOT NULL,
  `mini_description` varchar(255) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `tarif` float NOT NULL,
  `lien_image_associee` varchar(255) NOT NULL,
  `lien_vue` varchar(255) NOT NULL,
  PRIMARY KEY (`id_activité`),
  KEY `type_activité` (`type_activité`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sports`
--

INSERT INTO `sports` (`id_activité`, `type_activité`, `nomsport`, `mini_description`, `description`, `tarif`, `lien_image_associee`, `lien_vue`) VALUES
(1, 2, 'Apprentissage Natation', 'Description par défaut', 'Grande Description par défaut', 10.5, './assets/img/sports/9d4ac3e23ec3fb0955f7692115a3c19b.jpeg', ''),
(2, 3, 'Aquabike', 'Description par défaut', 'Grande Description par défaut', 11, '', ''),
(3, 3, 'AquaGym', 'Description par défaut', 'Grande Description par défaut', 1, '', ''),
(4, 2, 'Entrainement Natation', 'Description par défaut', 'Grande Description par défaut', 1, '', ''),
(5, 1, 'Half', 'Description par défaut', 'Grande Description par défaut', 1, '', ''),
(6, 1, 'IronMan', 'Description par défaut', 'Grande Description par défaut', 1, '', ''),
(7, 1, 'Olympique', 'Description par défaut', 'Grande Description par défaut', 1, '', ''),
(8, 2, 'Perfectionnement Natation', 'Description par défaut', 'Grande Description par défaut', 1, '', ''),
(9, 2, 'Perfectionnement Natation eau libre', 'Description par défaut', 'Grande Description par défaut', 1, '', ''),
(10, 1, 'Sprint', 'Description par défaut', 'Grande Description par défaut', 1, '', '');

-- --------------------------------------------------------

--
-- Structure de la table `suivis_activitees`
--

DROP TABLE IF EXISTS `suivis_activitees`;
CREATE TABLE IF NOT EXISTS `suivis_activitees` (
  `id_suivi` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur` int(11) NOT NULL,
  `activité` int(11) NOT NULL,
  `nombre_seances` int(11) NOT NULL,
  PRIMARY KEY (`id_suivi`),
  KEY `suiviacti-user` (`utilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `sexe` int(11) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
  `blacklist` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `sexe`, `mail`, `password`, `isAdmin`, `blacklist`) VALUES
(1, 'ledy', 'flo', 0, 'klach1703@gmail.com', '$2y$10$22FbG4/B9LMtW9dFV8O1IeVrMmeFKRFbwZMBgXrwXNU3evLdSixAm', 1, 0),
(24, 'Goudal', 'Louis', 0, 'louisgoudal1@gmail.com', '$2y$10$0FqIKnJmu5lccTvLPxzJEuuJ4v.60StBCtp8wrvELxpEQsasCQGmy', 0, 0);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `activites_disponibles`
--
ALTER TABLE `activites_disponibles`
  ADD CONSTRAINT `activites_disponibles_ibfk_1` FOREIGN KEY (`activite`) REFERENCES `sports` (`id_activité`),
  ADD CONSTRAINT `activites_disponibles_ibfk_2` FOREIGN KEY (`creneaux`) REFERENCES `creneaux_horaires` (`id_crénaux`);

--
-- Contraintes pour la table `oubli`
--
ALTER TABLE `oubli`
  ADD CONSTRAINT `oubli_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`activite_reservee`) REFERENCES `activites_disponibles` (`id_acti_dispo`);

--
-- Contraintes pour la table `sports`
--
ALTER TABLE `sports`
  ADD CONSTRAINT `sports_ibfk_1` FOREIGN KEY (`type_activité`) REFERENCES `categories` (`id_type_activite`);

--
-- Contraintes pour la table `suivis_activitees`
--
ALTER TABLE `suivis_activitees`
  ADD CONSTRAINT `suiviacti-acti` FOREIGN KEY (`id_suivi`) REFERENCES `sports` (`id_activité`),
  ADD CONSTRAINT `suiviacti-user` FOREIGN KEY (`utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
