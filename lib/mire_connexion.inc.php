<?php
	echo "<span class = \"titre\"></span>";
	echo "<span class = \"intitule-champ-identifiant\"></span>";
	echo "<input class = \"champ-identifiant\" type=\"text\" name=\"login\" maxlength=\"30\" size=\"11\" border = \"1\" autofocus>";
	echo "<span class = \"intitule-champ-mdp\"></span>";
	echo "<input class = \"champ-mdp\" type=\"password\" name=\"password\" maxlength=\"30\" size=\"11\">";
	echo "<input class = \"bouton-valid1\" type = \"submit\" VALUE = \"Se connecter\" NAME = \"validation_formulaire\">";
	echo "<span class = \"intitule-champ-oubli-mdp\"></span>";
	echo "<input class = \"bouton-valid2\" type=\"submit\" name=\"validation_formulaire\" value = \"Cliquer ici\">";
	echo "<span class = \"version\">Version&nbsp;:&nbsp;$version - $version_date</span>";
	//echo "<span class = \"nom_espace\">$nom_espace_collaboratif</span>";
?>
