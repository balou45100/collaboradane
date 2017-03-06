ALTER TABLE `evenements` ADD `date_evenement_fin` DATE NOT NULL AFTER `date_evenement`;
ALTER TABLE `evenements` ADD `fk_repertoire` INT(9) NOT NULL AFTER `fk_rne`;
ALTER TABLE `evenements` ADD `autre_lieu` VARCHAR(256) NOT NULL AFTER `fk_repertoire`;
ALTER TABLE `evenements` CHANGE `date_evenement` `date_evenement_debut` DATE NOT NULL;
