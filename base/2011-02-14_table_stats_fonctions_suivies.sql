-- phpMyAdmin SQL Dump
-- version 3.3.0
-- http://www.phpmyadmin.net
--
-- Serveur: calando.private.tice.ac-orleans-tours.fr
-- Généré le : Lun 14 Février 2011 à 12:03
-- Version du serveur: 5.0.51
-- Version de PHP: 5.2.6-1+lenny6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `collaboratice`
--

-- --------------------------------------------------------

--
-- Structure de la table `stats_fonctions_suivies`
--

CREATE TABLE IF NOT EXISTS `stats_fonctions_suivies` (
  `id` int(3) unsigned zerofill NOT NULL auto_increment,
  `intitule` varchar(35) NOT NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Contenu de la table `stats_fonctions_suivies`
--

INSERT INTO `stats_fonctions_suivies` (`id`, `intitule`, `description`) VALUES
(001, 'Tableau de bord', NULL),
(002, 'Répertoire ECL', NULL),
(003, 'Gestion tickets', NULL),
(004, 'Personnes ressources', NULL),
(005, 'Formations', NULL),
(006, 'Répertoire sociétés', NULL),
(007, 'Répertoire contacts', NULL),
(008, 'Répertoire contacts privés', NULL),
(009, 'Gestion Festivals TICE', NULL),
(010, 'Gestion rencontres TICE', NULL),
(011, 'Gestion matériels', NULL),
(012, 'Gestion tâches', NULL),
(013, 'Favoris', NULL),
(014, 'Gestion crédits', NULL),
(015, 'Suivi collaboratice', NULL),
(016, 'Recherche', NULL),
(017, 'Gestion catégories privées', NULL),
(018, 'Statistiques', NULL),
(019, 'Préférences utilisateur', NULL),
(020, 'Répertoire membres collaboratice', ''),
(021, 'Administration', NULL),
(022, 'Gestion dossiers', NULL),
(023, 'Publipostage', NULL),
(024, 'évolutions futures', NULL),
(025, 'Gestion courrier', NULL),
(026, 'Gestion groupes', NULL);
