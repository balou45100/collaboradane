--
-- Structure de la table `evenements_participants`
--

CREATE TABLE IF NOT EXISTS `evenements_participants` (
`id` int(6) NOT NULL,
  `id_evenement` int(6) NOT NULL,
  `id_participant` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `evenements_participants`
--
ALTER TABLE `evenements_participants`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `evenements_participants`
--
ALTER TABLE `evenements_participants`
MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;


--
-- Contenu de la table `evenements_participants`
--

INSERT INTO `evenements_participants` (`id`, `id_evenement`, `id_participant`) VALUES
(1, 1, 350),
(2, 1, 250);

--
-- Index pour les tables exportées
--
