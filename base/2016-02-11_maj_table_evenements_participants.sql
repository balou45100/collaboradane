ALTER TABLE `evenements_participants` ADD `montant_om_chorus` DECIMAL( 6, 2 ) NOT NULL ,
ADD `montant_ef_chorus` DECIMAL( 6, 2 ) NOT NULL ,
ADD `montant_paye_chorus` DECIMAL( 6, 2 ) NOT NULL ,
ADD `annee_imputation` INT( 4 ) NOT NULL ;
UPDATE `evenements_participants` SET `annee_imputation` = '2016';
