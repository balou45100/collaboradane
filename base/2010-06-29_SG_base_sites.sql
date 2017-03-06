-- phpMyAdmin SQL Dump
-- version 3.3.0
-- http://www.phpmyadmin.net
--
-- Serveur: calando.private.tice.ac-orleans-tours.fr
-- Généré le : Lun 28 Juin 2010 à 12:13
-- Version du serveur: 5.0.51
-- Version de PHP: 5.2.6-1+lenny6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `sites`
--

-- --------------------------------------------------------

--
-- Structure de la table `applis`
--

DROP TABLE IF EXISTS `applis`;
CREATE TABLE IF NOT EXISTS `applis` (
  `id_appli` int(10) NOT NULL auto_increment,
  `nom_appli` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id_appli`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Structure de la table `applis_site`
--

DROP TABLE IF EXISTS `applis_site`;
CREATE TABLE IF NOT EXISTS `applis_site` (
  `id_site` int(11) NOT NULL default '0',
  `id_appli` int(10) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_categorie` int(11) default '0',
  `categorie` char(20) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `droits`
--

DROP TABLE IF EXISTS `droits`;
CREATE TABLE IF NOT EXISTS `droits` (
  `id_droits` tinyint(1) NOT NULL auto_increment,
  `droits30` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`id_droits`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Structure de la table `identification`
--

DROP TABLE IF EXISTS `identification`;
CREATE TABLE IF NOT EXISTS `identification` (
  `id_login` int(11) NOT NULL auto_increment,
  `login` char(20) NOT NULL default '',
  `mdpasse` char(20) default NULL,
  PRIMARY KEY  (`id_login`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1492 ;

-- --------------------------------------------------------

--
-- Structure de la table `login_site`
--

DROP TABLE IF EXISTS `login_site`;
CREATE TABLE IF NOT EXISTS `login_site` (
  `id_site` int(11) default '0',
  `id_login` int(11) NOT NULL default '0',
  `droits` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `responsable`
--

DROP TABLE IF EXISTS `responsable`;
CREATE TABLE IF NOT EXISTS `responsable` (
  `id_responsable` int(11) NOT NULL auto_increment,
  `nom` char(100) default NULL,
  `prenom` char(100) default NULL,
  `email` char(100) default NULL,
  `fonction` char(100) default NULL,
  PRIMARY KEY  (`id_responsable`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1166 ;

-- --------------------------------------------------------

--
-- Structure de la table `responsable_site`
--

DROP TABLE IF EXISTS `responsable_site`;
CREATE TABLE IF NOT EXISTS `responsable_site` (
  `id_site` int(11) NOT NULL default '0',
  `id_responsable` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `serveurs`
--

DROP TABLE IF EXISTS `serveurs`;
CREATE TABLE IF NOT EXISTS `serveurs` (
  `id_serveur` int(3) NOT NULL auto_increment,
  `nom_serveur` varchar(30) NOT NULL default '',
  `url` varchar(70) NOT NULL,
  `role` varchar(20) default NULL,
  PRIMARY KEY  (`id_serveur`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Structure de la table `short_open_tag`
--

DROP TABLE IF EXISTS `short_open_tag`;
CREATE TABLE IF NOT EXISTS `short_open_tag` (
  `id_site` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `site`
--

DROP TABLE IF EXISTS `site`;
CREATE TABLE IF NOT EXISTS `site` (
  `id_site` int(11) NOT NULL auto_increment,
  `nom_dossier` varchar(50) NOT NULL default '',
  `serveur` int(3) NOT NULL default '1',
  `RNE` varchar(8) default NULL,
  `date_ouverture` datetime default NULL,
  `mot_cle_1` varchar(25) default NULL,
  `mot_cle_2` varchar(25) default NULL,
  `mot_cle_3` varchar(25) default NULL,
  `mot_cle_4` varchar(25) default NULL,
  `mot_cle_5` varchar(25) default NULL,
  `mot_cle_6` varchar(25) default NULL,
  `mot_cle_7` varchar(25) default NULL,
  `mot_cle_8` varchar(25) default NULL,
  `mot_cle_9` varchar(25) default NULL,
  `mot_cle_10` varchar(25) default NULL,
  `id_categorie` int(11) default NULL,
  PRIMARY KEY  (`id_site`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2069 ;

-- --------------------------------------------------------

--
-- Structure de la table `webmestre`
--

DROP TABLE IF EXISTS `webmestre`;
CREATE TABLE IF NOT EXISTS `webmestre` (
  `id_webmestre` int(11) NOT NULL auto_increment,
  `nom` char(50) default NULL,
  `prenom` char(50) default NULL,
  `email` char(100) default NULL,
  PRIMARY KEY  (`id_webmestre`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1141 ;

-- --------------------------------------------------------

--
-- Structure de la table `webmestre_site`
--

DROP TABLE IF EXISTS `webmestre_site`;
CREATE TABLE IF NOT EXISTS `webmestre_site` (
  `id_site` int(11) NOT NULL default '0',
  `id_webmestre` int(11) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
