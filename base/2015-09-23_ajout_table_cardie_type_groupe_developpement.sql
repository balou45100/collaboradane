-- phpMyAdmin SQL Dump
-- version 3.3.0
-- http://www.phpmyadmin.net
--
-- Serveur: calando.private.tice.ac-orleans-tours.fr
-- Généré le : Mer 23 Septembre 2015 à 12:30
-- Version du serveur: 5.0.51
-- Version de PHP: 5.3.3-7+squeeze14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `collaboratice`
--

-- --------------------------------------------------------

--
-- Structure de la table `cardie_type_groupe_developpement`
--

DROP TABLE IF EXISTS `cardie_type_groupe_developpement`;
CREATE TABLE IF NOT EXISTS `cardie_type_groupe_developpement` (
  `id_TGD` int(3) NOT NULL auto_increment,
  `intitule_TGD` varchar(100) NOT NULL,
  `actif` enum('O','N') NOT NULL default 'O',
  PRIMARY KEY  (`id_TGD`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `cardie_type_groupe_developpement`
--

INSERT INTO `cardie_type_groupe_developpement` (`id_TGD`, `intitule_TGD`, `actif`) VALUES
(1, 'Cycle 3', 'O'),
(2, 'Accrochage, illetrisme et absentéisme', 'O'),
(3, 'EIST', 'O'),
(4, 'Réseaux d''établissements', 'O'),
(5, 'Relations avec les familles, partenariats et orientation', 'O'),
(6, 'Médias et réseaux sociaux', 'O'),
(7, 'Outils innovants', 'O'),
(8, 'Évaluation positive', 'O'),
(9, 'Discimination, santé, handicap et citoyenneté', 'O'),
(10, 'Sciences à l''école', 'O'),
(11, 'Sportifs de haut niveau', 'O');

