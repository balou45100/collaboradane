CREATE TABLE IF NOT EXISTS `cardie_visites_ef_historique` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `FK_ID_EF` int(11) NOT NULL,
  `DATE` date NOT NULL,
  `ETAT` int(2) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=205 ;