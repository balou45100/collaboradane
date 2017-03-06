ALTER TABLE `personnes_ressources_domaines_budget` ADD `somme_imp_attribuee` DECIMAL(8,2) NOT NULL AFTER `nbr_heures_attribuees`;
ALTER TABLE `personnes_ressources_domaines_budget` ADD `id_domaine` INT(4) NOT NULL AUTO_INCREMENT , ADD PRIMARY KEY (`id_domaine`) ;
ALTER TABLE `fonctions_des_personnes_ressources` ADD `somme_imp` DECIMAL(5,2) NOT NULL ;

DROP TABLE IF EXISTS `imp`;
CREATE TABLE IF NOT EXISTS `imp` (
`id` int(5) NOT NULL,
  `taux` int(2) NOT NULL,
  `montant` decimal(7,2) NOT NULL,
  `annee` int(4) NOT NULL DEFAULT '2015',
  `defaut` ENUM('O','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `imp`
--

INSERT INTO `imp` (`id`, `taux`, `montant`, `annee`,`defaut`) VALUES
(1, 1, 312.50, 2015,'N'),
(2, 2, 625.00, 2015,'N'),
(3, 3, 1250.00, 2015,'O'),
(4, 4, 2500.00, 2015,'N'),
(5, 5, 3750.00, 2015,'N');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `imp`
--
ALTER TABLE `imp`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `imp`
--
ALTER TABLE `imp`
MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;

ALTER TABLE `personnes_ressources_domaines_budget` CHANGE `somme_imp_attribuee` `somme_imp_attribuee` REAL NOT NULL 
