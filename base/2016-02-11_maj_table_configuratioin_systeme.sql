ALTER TABLE `configuration_systeme` ADD `om_annee_budget` INT( 4 ) NOT NULL ;
UPDATE `evenements` SET `annee` = '2016';
ALTER TABLE `configuration_systeme` ADD `dossier_pieces_frais_deplacement` VARCHAR( 50 ) NOT NULL AFTER `dossier_lib_adresse_absolu` ;
