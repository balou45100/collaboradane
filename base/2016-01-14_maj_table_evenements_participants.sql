ALTER TABLE `evenements_participants` CHANGE `etat_om` `etat_om` INT(2) NOT NULL DEFAULT '0' COMMENT '0 NonEdite, 1 édité, 2 présent, 3 absent, 4 validé, 5 refusé';
