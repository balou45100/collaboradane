<html>
<head>
<!--  Script de listes deroulantes liees  avec appel  par AJAX, (evite le rechargement de la page) -->
<script language="Javascript"type="text/JavaScript">
// Requette AJAX
function makeRequest(url,id_niveau,id_ecrire){
	var http_request = false;
		//créer une instance (un objet) de la classe désirée fonctionnant sur plusieurs navigateurs
        if (window.XMLHttpRequest) { // Mozilla, Safari,...
            http_request = new XMLHttpRequest();
            if (http_request.overrideMimeType) {
                http_request.overrideMimeType('text/xml');//un appel de fonction supplémentaire pour écraser l'en-tête envoyé par le serveur, juste au cas où il ne s'agit pas de text/xml, pour certaines versions de navigateurs Mozilla
            }
        } else if (window.ActiveXObject) { // IE
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
            }
        }

        if (!http_request) {
            alert('Abandon :( Impossible de créer une instance XMLHTTP');
            return false;
        }
		//alert('HTTP request : '+http_request.status); = 0
        http_request.onreadystatechange = function() { traitementReponse(http_request,id_ecrire); } //affectation fonction appelée qd on recevra la reponse
		// lancement de la requete
		http_request.open('POST', url, true);
		//changer le type MIME de la requête pour envoyer des données avec la méthode POST ,  !!!! cette ligne doit etre absolument apres http_request.open('POST'....
		http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		obj=document.getElementById(id_niveau);
		data="val_sel="+obj.value;
        http_request.send(data);
}

function traitementReponse(http_request,id_ecrire) {
	var affich="";
	if (http_request.readyState == 4) {
		//if (http_request.status == 200) {
					// cas avec reponse de PHP en mode texte:
			//chargement des elements reçus dans la liste
			var affich_list=http_request.responseText;
         //alert("Reponse de php: "+affich_list);
				obj = document.getElementById(id_ecrire); 
                obj.innerHTML = affich_list;
		//} 
		//else {
       //         alert('Un problème est survenu avec la requête.'+http_request.status);
       // }
    }
}
</script>
</head>
<?php
include ("config.php");
// Connexion a la base de donnees  
	$AccesBase = mysql_connect($host,$Login,$Pass);
	mysql_select_db($DB,$AccesBase);
	$QuestionBase = "SELECT num, nom FROM ext_titre WHERE num_pere = 0 ORDER BY nom ASC" ;
	$result_recherche=mysql_db_query($DB, $QuestionBase) or die (mysql_error());
	$nombre_enr=mysql_num_rows($result_recherche);
?>
<body>
<form name="test1" method="post" action="liste_liees.php"  >
<?php
echo "
Date de création : <input type='text' name='date' value='".date('Y-m-d')."' readonly><br />
Nom : <input type='text' name='nom' value='".$_SESSION['nom_utilisateur']."' readonly><br />
Prénom : <input type='text' name='prenom' value='".$_SESSION['prenom_utilisateur']."' readonly><br />
E-mail : <input type='text' name='mail' value='".$_SESSION['mail_utilisateur']."' readonly><br />
Fonction : <input type='text' name='fonction' value='".$_SESSION['fonction_utilisateur']."' readonly><br />
RNE : <input type='text' name='etablissement' value='".$_SESSION['rne_utilisateur']."' readonly><br />";
?>
	<div id="id_list1">Titre :<br>
		<select name="niv1" id="id_niv1" onChange="makeRequest('repPhpAjax.php','id_niv1','id_list2')">
			<option>Aucun</option>
<?php
			while ($row=mysql_fetch_assoc($result_recherche)){
?>
					<option value="<?php echo $row['num']?>"><?php echo $row['nom']?></option> 
<?php
			}
?>
		</select> 
		<br><br>
	</div>
	
	
	<div id="id_list2">
	<!-- ici sera charge la reponse mode texte de PHP à la request AJAX -->
	</div>
</form>
</body>
</html>