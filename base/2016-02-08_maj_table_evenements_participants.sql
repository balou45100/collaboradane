ALTER TABLE `evenements_participants` CHANGE `frais` `frais` ENUM( 'A', 'S', 'C' ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'S';
