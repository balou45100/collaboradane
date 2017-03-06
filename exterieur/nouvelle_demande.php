<?php
	//Lancement de la session
	session_start();
?>
<html>
<head>
<!--  Script de listes deroulantes liees  avec appel  par AJAX, (evite le rechargement de la page) -->
<script language="Javascript"type="text/JavaScript">
// Requette AJAX
function makeRequest(url,id_niveau,id_ecrire){
	var http_request = false;
		//cr�er une instance (un objet) de la classe d�sir�e fonctionnant sur plusieurs navigateurs
        if (window.XMLHttpRequest) { // Mozilla, Safari,...
            http_request = new XMLHttpRequest();
            if (http_request.overrideMimeType) {
                http_request.overrideMimeType('text/xml');//un appel de fonction suppl�mentaire pour �craser l'en-t�te envoy� par le serveur, juste au cas o� il ne s'agit pas de text/xml, pour certaines versions de navigateurs Mozilla
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
            alert('Abandon :( Impossible de cr�er une instance XMLHTTP');
            return false;
        }
		//alert('HTTP request : '+http_request.status); = 0
        http_request.onreadystatechange = function() { traitementReponse(http_request,id_ecrire); } //affectation fonction appel�e qd on recevra la reponse
		// lancement de la requete
		http_request.open('POST', url, true);
		//changer le type MIME de la requ�te pour envoyer des donn�es avec la m�thode POST ,  !!!! cette ligne doit etre absolument apres http_request.open('POST'....
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
			//chargement des elements re�us dans la liste
			var affich_list=http_request.responseText;
         //alert("Reponse de php: "+affich_list);
				obj = document.getElementById(id_ecrire); 
                obj.innerHTML = affich_list;
		//} 
		//else {
       //         alert('Un probl�me est survenu avec la requ�te.'+http_request.status);
       // }
    }
}
</script>
</head>
<?php
include ("config.php");
include ("../biblio/fct.php");
include ("../biblio/config.php");
include ("../biblio/init.php");
// Connexion a la base de donnees  
	$AccesBase = mysql_connect($host,$Login,$Pass);
	mysql_select_db($DB,$AccesBase);
	$QuestionBase = "SELECT num, nom FROM ext_titre WHERE num_pere = 0 ORDER BY nom ASC" ;
	$result_recherche=mysql_db_query($DB, $QuestionBase) or die (mysql_error());
	$nombre_enr=mysql_num_rows($result_recherche);
?>
<body>
<form name="test1" method="post" action="nouvelle_demande_exec.php"  >
<?php
echo "
Date de cr�ation : <br /><input type='text' name='date' value='".date('Y-m-d')."' readonly><br />
Nom : <br /><input type='text' name='nom' value='".$_SESSION['nom_utilisateur']."' readonly><br />
Pr�nom : <br /><input type='text' name='prenom' value='".$_SESSION['prenom_utilisateur']."' readonly><br />
E-mail : <br /><input type='text' name='mail' value='".$_SESSION['mail_utilisateur']."' readonly><br />
Fonction : <br /><input type='text' name='fonction' value='".$_SESSION['fonction_utilisateur']."' readonly><br />
RNE : <br /><input type='text' name='rne' value='".$_SESSION['rne_utilisateur']."' readonly><br />";
?>
	<div id="id_list1">Titre :<br>
		<select name="niv1" id="id_niv1" onChange="makeRequest('repPhpAjax.php','id_niv1','id_list2')">
			<option value="">Aucun</option>
<?php	
		//echo $_GET['serveur'];
		if (isset($_GET['serveur']) and $_GET['serveur'] !="")
		{
			echo "<option value='Site ".$_GET['nom_doss']." sur ".$_GET['serveur']."' selected>Site ".$_GET['nom_doss']." sur ".$_GET['serveur']."</option>";
		}
			while ($row=mysql_fetch_assoc($result_recherche)){
?>
					<option value="<?php echo $row['num']?>"><?php echo $row['nom']?></option> 
<?php
			}
?>
		</select>
	</div>
	
	
	<div id="id_list2">
	<!-- ici sera charge la reponse mode texte de PHP � la request AJAX -->
	</div>
	<?php
	if (isset($_GET['serveur']) and $_GET['serveur'] !="")
		{
			$value = $_GET['pre'];
		}
		else
		{
		$value = "";
		}
	echo"Description rapide du probl�me : <br />
	<input type='text' name='titre' value='".$value."'><br />";
	?>
	Description : <br />
	<textarea name="description" cols="50" rows="4"></textarea>
<br />
<input type="submit" value="Envoyer">
</form>
</body>
</html>