ALTER TABLE `courrier` ADD `cree_par` INT( 32 ) NOT NULL DEFAULT '34'

ALTER TABLE `courrier` DROP `scan` 

ALTER TABLE `courrier` ADD `confidentiel` ENUM( 'O', 'N' ) NOT NULL DEFAULT 'N'


CREATE TABLE IF NOT EXISTS `droits` (
  `id_droit` smallint(5) NOT NULL AUTO_INCREMENT,
  `nom_droit` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_droit`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `droits`
--

INSERT INTO `droits` (`id_droit`, `nom_droit`) VALUES
(1, 'courrier');

DROP TABLE IF EXISTS `util_droits`;
CREATE TABLE IF NOT EXISTS `util_droits` (
  `id_util` smallint(5) NOT NULL DEFAULT '0',
  `id_droit` smallint(5) NOT NULL DEFAULT '0',
  `niveau` smallint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `util_droits`
--

INSERT INTO `util_droits` (`id_util`, `id_droit`, `niveau`) VALUES
(1, 1, 3),
(34, 1, 3);

- Exporter la table courrier, supprimer la clé primaire et la réimporter à nouveau

- ajouter une nouvelle clé primaire :
ALTER TABLE `courrier` ADD `id_courrier` INT( 32 ) NOT NULL AUTO_INCREMENT ,
ADD PRIMARY KEY ( `id_courrier` )
