<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	//on fixe les variables pour les champs de sélection des dates à la date d'aujourd'hui
	/*
	$aujourdhui_jour = date('d');
	$aujourdhui_jour = $aujourdhui_jour+7;
	//Il faut vérifier que la date reste valable à travers une fonction
	$aujourdhui_mois = date('m');
	$aujourdhui_annee = date('Y');
	*/
	//echo "<br />nbr_jours_decallage_pour_rappel : $nbr_jours_decallage_pour_rappel";
	//On regarde que la date à afficher pour le rappel a le bon format
	$date_rappel = verif_date_rappel ($nbr_jours_decallage_pour_rappel);
	//echo "<br />date_rappel : $date_rappel";

	//Transformation de la date de création extraite pour l'affichage
	$date_rappel_a_afficher = strtotime($date_rappel);
	$aujourdhui_jour = date('d',$date_rappel_a_afficher);
	$aujourdhui_mois = date('m',$date_rappel_a_afficher);
	$aujourdhui_annee = date('Y',$date_rappel_a_afficher);
	/*
	echo "<br />jour : $aujourdhui_jour";
	echo "<br />mois : $aujourdhui_mois";
	echo "<br />année : $aujourdhui_annee";
	*/

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Collaboratice</title>
<link rel="stylesheet" type="text/css" href="../biblio/view.css" media="all">
<script type="text/javascript" src="view.js"></script>
<script type="text/javascript" src="calendar.js"></script>
</head>
<body id="main_body" >
<?php
	echo "<img id=\"top\" src = \"$chemin_theme_images/top1.png\" alt=\"\">
	<div id=\"form_container\">

		<h1><a>Ajouter une t&acirc;che</a></h1>
		<form id=\"form_257678\" class=\"appnitro\" action=\"taches_gestion.php\" method=\"get\">

		<!--form id=\"form_257678\" class=\"appnitro\"  method=\"post\" action=\"test.php\"-->
		<!--div class=\"form_description\"-->
		<div>
			<h2>Ajouter une t&acirc;che</h2>
			<!--p>Saisir les dates</p-->
		</div>

	<table border = \"1\" align = \"center\">
		<colgroup>
			<col width=\"30%\">
			<col width=\"30%\">
			<col width=\"40%\">
		</colgroup>
		<tr>
			<td align = \"right\">Desription de la t&acirc;che&nbsp;:&nbsp;</td>
			<td colspan = \"2\"><textarea rows=\"3\" name=\"description_tache\" cols=\"60\"></textarea></td>
		</tr>
		<tr>
			<td rowspan= \"2\" align = \"right\">&Eacute;ch&eacute;ance&nbsp;:&nbsp;</td>
			<td align = \"right\"><label class=\"description\" for=\"element_1\">&agrave; partir du&nbsp;:&nbsp;</label></td>
			<td>
				<span>
					<input id=\"element_1_2\" name=\"element_1_2\" class=\"element text\" size=\"2\" maxlength=\"2\" value=\"\" type=\"text\"> /
					<!--label for=\"element_1_2\">DD</label-->
				</span>
				<span>
					<input id=\"element_1_1\" name=\"element_1_1\" class=\"element text\" size=\"2\" maxlength=\"2\" value=\"\" type=\"text\"> /
					<!--label for=\"element_1_1\">MM</label-->
				</span>
				<span>
					<input id=\"element_1_3\" name=\"element_1_3\" class=\"element text\" size=\"4\" maxlength=\"4\" value=\"\" type=\"text\">
					<!--label for=\"element_1_3\">YYYY</label-->
				</span>

				<span id=\"calendar_1\">
					<img id=\"cal_img_1\" class=\"datepicker\" src = \"$chemin_theme_images/calendar.gif\" alt=\"Choisir une date\">
				</span>
				<script type=\"text/javascript\">
					Calendar.setup(
					{
						inputField	 : \"element_1_3\",
						baseField    : \"element_1\",
						displayArea  : \"calendar_1\",
						button		 : \"cal_img_1\",
						ifFormat	 : \"%B %e, %Y\",
						onSelect	 : selectDate
					});
				</script>
			</td>
		</tr>
		<tr>
			<td align = \"right\">rappel le&nbsp;:&nbsp;</td>

		</tr>
	</table>
			<ul >

					<li id=\"li_1\" >
		<!--label class=\"description\" for=\"element_1\">Date 1</label>
		<span>
			<input id=\"element_1_2\" name=\"element_1_2\" class=\"element text\" size=\"2\" maxlength=\"2\" value=\"\" type=\"text\"> /
			<label for=\"element_1_2\">DD</label>
		</span>
		<span>
			<input id=\"element_1_1\" name=\"element_1_1\" class=\"element text\" size=\"2\" maxlength=\"2\" value=\"\" type=\"text\"> /
			<label for=\"element_1_1\">MM</label>
		</span>
		<span>
	 		<input id=\"element_1_3\" name=\"element_1_3\" class=\"element text\" size=\"4\" maxlength=\"4\" value=\"\" type=\"text\">
			<label for=\"element_1_3\">YYYY</label>
		</span>

		<span id=\"calendar_1\">
			<img id=\"cal_img_1\" class=\"datepicker\" src = \"$chemin_theme_images/calendar.gif\" alt=\"Choisir une date\"\">
		</span>
		<script type=\"text/javascript\">
			Calendar.setup({
			inputField	 : \"element_1_3\",
			baseField    : \"element_1\",
			displayArea  : \"calendar_1\",
			button		 : \"cal_img_1\",
			ifFormat	 : \"%B %e, %Y\",
			onSelect	 : selectDate
			});
		</script-->

		</li>		<li id=\"li_2\" >
		<label class=\"description\" for=\"element_2\">Date 2</label>
		<span>
			<input id=\"element_2_2\" name=\"element_2_2\" class=\"element text\" size=\"2\" maxlength=\"2\" value=\"\" type=\"text\"> /
			<label for=\"element_2_2\">DD</label>
		</span>
		<span>
			<input id=\"element_2_1\" name=\"element_2_1\" class=\"element text\" size=\"2\" maxlength=\"2\" value=\"\" type=\"text\"> /
			<label for=\"element_2_1\">MM</label>
		</span>
		<span>
	 		<input id=\"element_2_3\" name=\"element_2_3\" class=\"element text\" size=\"4\" maxlength=\"4\" value=\"\" type=\"text\">
			<label for=\"element_2_3\">YYYY</label>
		</span>

		<span id=\"calendar_2\">
			<img id=\"cal_img_2\" class=\"datepicker\" src = \"$chemin_theme_images/calendar.gif\" alt=\"Choisir une date\">
		</span>
		<script type=\"text/javascript\">
			Calendar.setup({
			inputField	 : \"element_2_3\",
			baseField    : \"element_2\",
			displayArea  : \"calendar_2\",
			button		 : \"cal_img_2\",
			ifFormat	 : \"%B %e, %Y\",
			onSelect	 : selectDate
			});
		</script>

		</li>		<li id=\"li_3\" >
		<label class=\"description\" for=\"element_3\">Date 3</label>
		<span>
			<input id=\"element_3_2\" name=\"element_3_2\" class=\"element text\" size=\"2\" maxlength=\"2\" value=\"\" type=\"text\"> /
			<label for=\"element_3_2\">DD</label>
		</span>
		<span>
			<input id=\"element_3_1\" name=\"element_3_1\" class=\"element text\" size=\"2\" maxlength=\"2\" value=\"\" type=\"text\"> /
			<label for=\"element_3_1\">MM</label>
		</span>
		<span>
	 		<input id=\"element_3_3\" name=\"element_3_3\" class=\"element text\" size=\"4\" maxlength=\"4\" value=\"\" type=\"text\">
			<label for=\"element_3_3\">YYYY</label>
		</span>

		<span id=\"calendar_3\">
			<img id=\"cal_img_3\" class=\"datepicker\" src = \"$chemin_theme_images/calendar.gif\" alt=\"Choisir une date\">
		</span>
		<script type=\"text/javascript\">
			Calendar.setup({
			inputField	 : \"element_3_3\",
			baseField    : \"element_3\",
			displayArea  : \"calendar_3\",
			button		 : \"cal_img_3\",
			ifFormat	 : \"%B %e, %Y\",
			onSelect	 : selectDate
			});
		</script>

		</li>		<li id=\"li_4\" >
		<label class=\"description\" for=\"element_4\">Date 4</label>
		<span>
			<input id=\"element_4_2\" name=\"element_4_2\" class=\"element text\" size=\"2\" maxlength=\"2\" value=\"\" type=\"text\"> /
			<label for=\"element_4_2\">DD</label>
		</span>
		<span>
			<input id=\"element_4_1\" name=\"element_4_1\" class=\"element text\" size=\"2\" maxlength=\"2\" value=\"\" type=\"text\"> /
			<label for=\"element_4_1\">MM</label>
		</span>
		<span>
	 		<input id=\"element_4_3\" name=\"element_4_3\" class=\"element text\" size=\"4\" maxlength=\"4\" value=\"\" type=\"text\">
			<label for=\"element_4_3\">YYYY</label>
		</span>

		<span id=\"calendar_4\">
			<img id=\"cal_img_4\" class=\"datepicker\" src = \"$chemin_theme_images/calendar.gif\" alt=\"Choisir une date\">
		</span>
		<script type=\"text/javascript\">
			Calendar.setup({
			inputField	 : \"element_4_3\",
			baseField    : \"element_4\",
			displayArea  : \"calendar_4\",
			button		 : \"cal_img_4\",
			ifFormat	 : \"%B %e, %Y\",
			onSelect	 : selectDate
			});
		</script>

		</li>

					<li class=\"buttons\">
			    <input type=\"hidden\" name=\"form_id\" value=\"257678\" />

				<input id=\"saveForm\" class=\"button_text\" type=\"submit\" name=\"submit\" value=\"Valider\" />
		</li>
			</ul>
		</form>
		<div id=\"footer\">
			Generated by <a href=\"http://www.phpform.org\">pForm</a>
		</div>
	</div>
	<img id=\"bottom\" src = \"$chemin_theme_images/bottom.png\" alt=\"\">
	</body>";
?>
</html>
