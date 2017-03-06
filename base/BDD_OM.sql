CREATE TABLE om_lieu (
  idlieu INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  type_2 VARCHAR(10) NULL,
  intitule VARCHAR(100) NULL,
  adresse1 VARCHAR(100) NULL,
  adresse2 VARCHAR(100) NULL,
  cp VARCHAR(15) NULL,
  ville VARCHAR(25) NULL,
  pays VARCHAR(25) NULL,
  tel INTEGER UNSIGNED NULL,
  mel VARCHAR(100) NULL,
  PRIMARY KEY(idlieu)
);

CREATE TABLE personnes_ressources_tice (
  idpersonnes_ressources_tice INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  PRIMARY KEY(idpersonnes_ressources_tice)
);

CREATE TABLE om_salle (
  idsalle INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  om_lieu_idlieu INTEGER UNSIGNED NOT NULL,
  intitule INTEGER UNSIGNED NULL,
  PRIMARY KEY(idsalle),
  INDEX om_salle_FKIndex1(om_lieu_idlieu),
  FOREIGN KEY(om_lieu_idlieu)
    REFERENCES om_lieu(idlieu)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE om_reunion (
  idreunion INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  om_lieu_idlieu INTEGER UNSIGNED NOT NULL,
  intitule VARCHAR(150) NULL,
  date_horaire_debut DATETIME NULL,
  date_horaire_fin DATETIME NULL,
  PRIMARY KEY(idreunion),
  INDEX om_reunion_FKIndex1(om_lieu_idlieu),
  FOREIGN KEY(om_lieu_idlieu)
    REFERENCES om_lieu(idlieu)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE om_ordres_mission (
  RefOM INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  personnes_ressources_tice_idpersonnes_ressources_tice INTEGER UNSIGNED NOT NULL,
  om_reunion_idreunion INTEGER UNSIGNED NOT NULL,
  etat_traite BOOL NULL,
  PRIMARY KEY(RefOM),
  INDEX om_ordres_mission_FKIndex1(om_reunion_idreunion),
  INDEX om_ordres_mission_FKIndex2(personnes_ressources_tice_idpersonnes_ressources_tice),
  FOREIGN KEY(om_reunion_idreunion)
    REFERENCES om_reunion(idreunion)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION,
  FOREIGN KEY(personnes_ressources_tice_idpersonnes_ressources_tice)
    REFERENCES personnes_ressources_tice(idpersonnes_ressources_tice)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE om_suivi_om (
  id_suivi_om INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  om_ordres_mission_RefOM INTEGER UNSIGNED NOT NULL,
  RefUlysse_om VARCHAR(10) NULL,
  etat_om ENUM('C','P','A','V','R') NULL,
  date_om DATE NULL,
  motif_om VARCHAR(255) NULL,
  PRIMARY KEY(id_suivi_om),
  INDEX om_suivi_om_FKIndex1(om_ordres_mission_RefOM),
  FOREIGN KEY(om_ordres_mission_RefOM)
    REFERENCES om_ordres_mission(RefOM)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE om_etat_frais (
  RefEF INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  om_ordres_mission_RefOM INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(RefEF),
  INDEX om_etat_frais_FKIndex1(om_ordres_mission_RefOM),
  FOREIGN KEY(om_ordres_mission_RefOM)
    REFERENCES om_ordres_mission(RefOM)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE om_relance (
  id_relance INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  om_ordres_mission_RefOM INTEGER UNSIGNED NOT NULL,
  date_relance DATE NULL,
  PRIMARY KEY(id_relance),
  INDEX om_relance_FKIndex1(om_ordres_mission_RefOM),
  FOREIGN KEY(om_ordres_mission_RefOM)
    REFERENCES om_ordres_mission(RefOM)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);

CREATE TABLE om_suivi_ef (
  id_suivi_ef INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  om_etat_frais_RefEF INTEGER UNSIGNED NOT NULL,
  RefUlysse_ef VARCHAR(10) NULL,
  etat_ef ENUM('V','R') NULL,
  date_ef DATE NULL,
  motif_ef VARCHAR(255) NULL,
  PRIMARY KEY(id_suivi_ef),
  INDEX om_suivi_ef_FKIndex1(om_etat_frais_RefEF),
  FOREIGN KEY(om_etat_frais_RefEF)
    REFERENCES om_etat_frais(RefEF)
      ON DELETE NO ACTION
      ON UPDATE NO ACTION
);


