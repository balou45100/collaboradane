-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Serveur: calando.private.tice.ac-orleans-tours.fr
-- Généré le : Lun 21 Décembre 2009 à 10:28
-- Version du serveur: 5.0.32
-- Version de PHP: 5.2.0-8+etch15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `collaboratice`
--

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

DROP TABLE IF EXISTS `favoris`;
CREATE TABLE IF NOT EXISTS `favoris` (
  `id_favori` int(11) NOT NULL auto_increment,
  `adresse` varchar(200) NOT NULL,
  `intitule` varchar(60) NOT NULL,
  `id_categ` int(11) NOT NULL,
  PRIMARY KEY  (`id_favori`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

--
-- Contenu de la table `favoris`
--

INSERT INTO `favoris` (`id_favori`, `adresse`, `intitule`, `id_categ`) VALUES
(1, 'http://www.ac-orleans-tours.fr/tice/', '01 Site Mission TICE', 2),
(2, 'http://mission.tice.ac-orleans-tours.fr/marratech/reservation/', '03 Réservation pour Marratech', 2),
(3, 'http://195.83.89.19:8010/', '04 Marratech', 2),
(4, 'http://crdp.tice.ac-orleans-tours.fr/grr/login.php', '05 Réservation salles CRDP', 2),
(5, 'http://10.45.128.206/user/scan/scan.shtml', '06 Scanner réseau (au CRDP)', 2),
(6, 'http://www.ac-orleans-tours.fr/rectorat/melouvert/annuaire.htm', '01 annuaire académique', 3),
(7, 'http://www.ac-orleans-tours.fr/rectorat/melouvert/webmail.htm', '02 webmail académique', 3),
(8, 'https://bv.ac-orleans-tours.fr/iprof/ServletIprof', '03 i-prof', 3),
(9, 'http://weblistes.ac-orleans-tours.fr/wws', '04 Listes de diffusion - serveur académique', 3),
(10, 'http://www.ac-orleans-tours.fr', '05 Portail site académique', 3),
(11, 'http://www.ac-orleans-tours.fr/rectorat/pedagogie/disciplines.htm', '06 Sites disciplinaires académiques', 3),
(12, 'http://mediante.tice.ac-orleans-tours.fr', '07 Pages établissements sur mediante', 3),
(13, 'http://festival.tice.ac-orleans-tours.fr/', '02 Festival TICE', 2),
(14, 'http://webmen.helpline.fr/support.jsp', 'Helpline (accès limité)', 10),
(15, 'http://intraeple.ac-orleans-tours.fr/', '09 Site intranet pour les EPLE de l''académie', 3),
(16, 'http://intraeple.ac-orleans-tours.fr/formDmz.php', '10 demande d''ouverture de DMZ', 3),
(17, 'http://wwwphp.ac-orleans-tours.fr/arfot/', 'Arfot', 3),
(18, 'http://moderato.tice.ac-orleans-tours.fr/plones/tice/nous/les-correspondants-departementaux', 'Correspondants Départementaux', 3),
(19, 'http://www.edulibre.org/', 'Edulibre.org', 3),
(20, 'http://demo.esco-portail.org/netocentre/', 'ENT Site demo', 3),
(21, 'http://aiedu.education.fr/', 'Mise à jour BDD SquidGuard (Liste noire Amon)', 3),
(22, 'http://rencontres.tice.ac-orleans-tours.fr/', 'Rencontres Tice', 2),
(23, 'http://radio.ac-orleans-tours.fr', 'Web Radio TICE', 2),
(24, 'http://phpmyadmin.tice.ac-orleans-tours.fr/phpmyadmin/', '01 phpmyadmin global', 10),
(25, 'http://mission.tice.ac-orleans-tours.fr/ouvertureSites/', '02 Ouverture sites', 10),
(26, 'https://licensing.microsoft.com/eLicense/L1033/Default.asp', 'Microsoft Licensing', 10),
(27, 'https://mails.ac-orleans-tours.fr/horde3/', 'Horde3 - Webmail ', 10),
(28, 'http://www.educnet.education.fr/bd/inter/', 'Base IANTES', 10),
(29, 'http://intranet.in.ac-orleans-tours.fr/arenb/', 'Intranet du rectorat', 10),
(30, 'http://mediante.tice.ac-orleans-tours.fr/_vti_bin/_vti_adm/fpadmcgi.exe?page=webadmin.htm', 'Administration ecl', 10),
(31, 'https://tage.ac-orleans-tours.fr/reunion/', 'Application "Réunion"', 10),
(32, 'http://home.gna.org/oomadness/fr/songwrite/index.html', 'Songwrite - Éditeur de partitions musicales libre', 14),
(33, 'http://www.capeutservir.com/verbes/', 'Conjuguer (Ça peut servir)', 14),
(34, 'http://www.leconjugueur.com/', 'Conjugueur (Figaro)', 14),
(35, 'https://secure.nai.com/us/forms/downloads/upgrades/login.asp', 'McAfee', 10),
(36, 'http://formation.tice.ac-orleans-tours.fr/dotclear/', 'Dotclear', 4),
(37, 'http://formation.tice.ac-orleans-tours.fr/eva/', 'EVA/Spip', 4),
(38, 'http://gibii.tice.ac-orleans-tours.fr/formation/', 'GIBII', 4),
(39, 'http://formation.tice.ac-orleans-tours.fr/go/', 'Groupoffice', 4),
(40, 'http://formation.tice.ac-orleans-tours.fr/grr/', 'GRR', 4),
(41, 'http://formation.tice.ac-orleans-tours.fr/moodle/', 'Moodle', 4),
(42, 'http://formation.tice.ac-orleans-tours.fr/wikini/', 'Wikini', 4),
(43, 'http://formation.tice.ac-orleans-tours.fr/wordpress/', 'Wordpress', 4),
(46, 'http://www.ac-rouen.fr/rectorat/academie_presentation/sigles.php', 'Sigles dans l''EN', 3),
(47, 'http://demo.tice.ac-orleans-tours.fr/dotclear/', 'Dotclear', 5),
(48, 'http://demo.tice.ac-orleans-tours.fr/eva/', 'EVA/Spip', 5),
(49, 'http://demo.tice.ac-orleans-tours.fr/go/', 'Groupoffice', 5),
(50, 'http://demo.tice.ac-orleans-tours.fr/grr/', 'GRR', 5),
(51, 'http://demo.tice.ac-orleans-tours.fr/joomla/', 'Joomla', 5),
(52, 'http://demo.tice.ac-orleans-tours.fr/moodle/', 'Moodle', 5),
(53, 'http://demo.tice.ac-orleans-tours.fr/wikini/', 'Wikini', 5),
(54, 'http://demo.tice.ac-orleans-tours.fr/wordpress/', 'Wordpress', 5),
(55, 'http://www.google.com/support/webmasters/bin/answer.py?answer=61062&ctx=sibling', 'déréfernecement chez Google', 6),
(56, 'http://www.educnet.education.fr/juri/creation1.htm', 'Légamédia (EN)', 6),
(57, 'http://artic.ac-besancon.fr/juridique/', 'Quelques conseils juridiques (Ac Besançon)', 6),
(58, 'http://www.framabook.org/', 'Thunderbird', 7),
(59, 'http://www.framabook.org/ubuntu.html', 'Ubuntu', 7),
(60, 'http://www.etwinning.fr', 'E-Twinning', 8),
(61, 'http://eole.orion.education.fr/diffusion/', 'EOLE - Site de diffusion', 8),
(62, 'http://education.gouv.fr/', 'Site du Ministère de l''EN', 8),
(63, 'http://192.168.128.224', 'bureau 400 : Brother 1470N (Norbert)', 12),
(64, 'http://192.168.128.242', 'bureau 404 : Brother 1470N (Tristan)', 12),
(65, 'http://192.168.128.211', 'bureau 500 : HP LJ 2300N (secrétariat)', 12),
(66, 'http://192.168.128.207', 'bureau 503  : Samsung laser mono (Jürgen)', 12),
(67, 'http://192.168.128.227', 'bureau 503 : Brother 1270N (HS)', 12),
(68, 'http://192.168.128.185', 'bureau 503 : Dell Laser Couleur 5110cn (Jürgen)', 12),
(69, 'http://192.168.128.26', 'bureau 504 : Brother 1470N (Véronique)', 12),
(70, 'http://192.168.128.130', 'bureau 603 : HP LJ4100', 12),
(71, 'http://www.capeutservir.com/', 'Ça peut servir - Quelques bonnes adresses utiles', 13),
(72, 'http://www.cmsmatrix.org/', 'cmsmatrix', 13),
(73, 'http://www.spamihilator.com/download/index.php', 'Antispam - Spamihilator', 9),
(74, 'http://www.webwizguide.info/asp/sample_scripts/RTE_application.asp', 'Applications ASP gratuites', 9),
(76, 'http://www.commentcamarche.net/faq/sujet-11676-utiliser-nlite-pour-refaire-un-cd-bootable-de-windows', 'Création CD Install Windows', 9),
(77, 'http://www.ajaxlaunch.com/ajaxsketch/internals/ajaxsketch-nojscript.html', 'Dessin en ligne (AjaxSketch)', 18),
(78, 'http://www.pspad.com/fr/', 'Editeur gratuit pour développement WEB PSPad', 9),
(79, 'http://freemind.sourceforge.net/wiki/index.php/Main_Page', 'Freemind (page en anglais)', 9),
(80, 'http://www.glpi-project.org/', 'Gestion de parc informatique et suivi de tickets', 9),
(81, 'http://www.inkscape.org/', 'Inkscape - editeur graphiques vectoriels libre', 9),
(82, 'http://italc.sourceforge.net/', 'iTALC - prise de contrôle à distance', 9),
(83, 'http://www.framasoft.net/article1370.html', 'Linux avec Windows', 9),
(84, 'http://www.framasoft.net/article2073.html', 'TightVNC - Prise de contrôle à distance', 9),
(85, 'http://community.ofset.org/wiki/Squeak', 'Squeak', 9),
(86, 'http://bestpractical.com/rt', 'Suivi de tickets (RT)', 9),
(87, 'http://www.google.com/googlespreadsheets/tour1.html', 'Tableur en ligne (Google Spreadsheets)', 18),
(88, 'http://www.ajaxlaunch.com/ajaxwrite/internals/ajaxwrite-nojscript.html', 'Traitement de texte en ligne (AjaxWriter)', 18),
(89, 'http://www.virtualbox.org/', 'VirtualBox', 9),
(90, 'http://zoho.com/', 'ZOHO Applications en ligne - espace collaboratif', 9),
(91, 'http://linuxfr.org/2008/06/27/24272.html', 'CeltX, réalisation MM', 11),
(92, 'http://www.diamondcs.com.au/freeutilities/fileunlocker.php', 'Suppression de verrou de fichier', 11),
(93, 'http://www.dimdim.com/products/what_is_dimdim.html', 'DimDim, Webconférence gratuite', 18),
(94, 'http://mediainfo.sourceforge.net/fr', 'MediaInfo - codecs utilisés, vidéos et audios', 11),
(95, 'http://synergy2.sourceforge.net/', 'Synergie - partage de clavier/souris', 11),
(96, 'http://www.cgsecurity.org/index.html?testdisk.html', 'Testdisk - réparation amorce', 11),
(97, 'http://ccollomb.free.fr/unlocker/', 'Unlocker - suppression fichiers bloqués', 11),
(98, 'http://clonezilla.org/', 'Clonezilla pour faire des images disque', 9),
(99, 'http://go.tice.ac-orleans-tours.fr/groupoffice/', 'GroupOffice', 2),
(100, 'http://192.168.128.245', 'NAS', 10),
(101, 'http://moblin.org', 'Moblin - Linux pour netbooks', 17),
(102, 'http://sourceforge.net/projects/mac4lin/', 'Mac4Lin - Interface Mac pour Linux', 17),
(103, 'http://www.cairo-dock.org', 'Cairo Dock', 17),
(104, 'http://wubuntu-tweak.com', 'Ubuntu Tweak', 17),
(105, 'http://profgeek.fr/cahier-de-textes/', 'Cahier de texte en ligne', 18),
(106, 'http://download.ooo4kids.org/', 'OpenOffice for kids', 18),
(107, 'http://support.euro.dell.com/support/index.aspx?c=fr&l=fr&s=gen&~ck=cr', 'Support DEll', 3),
(108, 'http://support.euro.dell.com/support/topics/topic.aspx/emea/shared/support/dellcare/fr/byphone_prod?c=fr&l=fr&s=gen', 'Coordonnées téléphoniques', 21),
(109, 'http://support.euro.dell.com/', 'Accueil', 21),
(110, 'http://www.redmine.org/', 'Redmine', 9),
(111, 'http://references.modernisation.gouv.fr/rgaa-accessibilite', 'Référentiel Général d''Accessibilité pour les Administrations', 6),
(112, 'http://devlocaux.in.ac-orleans-tours.fr/criatest/', 'Site rectorat rénové et en développement (en intranet)', 10);

-- --------------------------------------------------------

--
-- Structure de la table `favoris_categories`
--

DROP TABLE IF EXISTS `favoris_categories`;
CREATE TABLE IF NOT EXISTS `favoris_categories` (
  `id_categ` int(11) NOT NULL auto_increment,
  `intitule_categ` varchar(60) NOT NULL,
  `id_util` int(11) NOT NULL,
  PRIMARY KEY  (`id_categ`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Contenu de la table `favoris_categories`
--

INSERT INTO `favoris_categories` (`id_categ`, `intitule_categ`, `id_util`) VALUES
(2, '01 Applis collaboratifs et sites de la Mission TICE', 0),
(3, '02 Liens professionnels', 0),
(4, '04 Catalogue - applications formations', 0),
(5, '06 Catalogue - Espaces de démonstration', 0),
(6, '05 Aspects juridiques', 0),
(7, '07 Documentations', 0),
(8, '10 Sites institutionnels', 0),
(9, '08 Outils', 0),
(10, '01 Liens professionnels', 1),
(11, '09 Outils divers', 0),
(12, '02 Gestion imprimantes au CRDP', 1),
(13, '11 Divers et autres', 0),
(14, '20 Outils', 1),
(18, '03 Applis "pédagogiques" en ligne', 0),
(19, 'Mes liens', 9),
(17, '12 Linux', 0),
(21, 'Support Dell', 1);
