SELECT DISTINCT util.id_util, taches.id_tache FROM `taches`, taches_util,util WHERE ((taches.id_util_creation=1 OR taches.id_util_traitant = 1) OR (taches_util.id_tache=1 AND taches_util.id_tache = taches.id_tache)) AND util.id_util = 1