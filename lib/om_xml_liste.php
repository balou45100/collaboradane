<?php
	session_start();
	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
include("rechercheliste.php");
?>
<HTML><HEAD>

<body bgcolor="#FFB301" text="#000000">
<title> Formulaire réunion </title>
<p><center><strong><u> Formulaire de saisies d'une réunion </u></strong></center></p>

<SCRIPT language="JavaScript">
   var i=0;
var nblist=<?php echo $nblist;?>; // Nombre de listes dépendantes
// Mise à jour des listes via XMLHttpRequest
function liste(f,q) {
   
   chp=""; // concatener les options
   for(i=0;i<q;i++){
      sel=f.elements["list"+i];
      ind=sel.selectedIndex;
      chp=chp+sel.options[ind].value+"/";
   }
   var l1 = f.elements["list"+(q-1)]; // La liste père
   var l2 = f.elements["list"+q]; // La liste à mettre à jour
   var index = l1.selectedIndex; // Index de la liste
// Remise à zéro des listes suivantes
   for(i=q;i<=nblist;i++) f.elements["list"+i].options.length = 0;
// Si une option est sélectionnée, alors, il faut y aller ;)
   if(index > 0) { 
   var xhr_object = null;

   if(window.XMLHttpRequest) // Si Firefox
      xhr_object = new XMLHttpRequest();
   else if(window.ActiveXObject) // Si Internet Explorer
      xhr_object = new ActiveXObject("Microsoft.XMLHTTP");
   else { // XMLHttpRequest non supporté par le navigateur
      alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
      return;
   }
// On passe en GET le numéro du select à mettre à jour
   xhr_object.open("POST", "rechercheliste.php?q="+q, true);

   xhr_object.onreadystatechange = function() {
   if(xhr_object.readyState == 4)
      eval(xhr_object.responseText);
   }
   xhr_object.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
// Les données sont préparées dans data avec :
// - champ  : contient la value de l'option sélectionnée
// - form   : contient le nom du formulaire
// - select : contient le nom du select (les appeler tous listX où x va de 0 à n)
   var data = "champ="+chp+"&form="+f.name+"&select=list"+q;
   xhr_object.send(data);
   }
}
</SCRIPT>
<STYLE TYPE="text/css">
   td,select,input { font:normal 8pt Verdana }
</STYLE>
</HEAD><BODY>
<?php
$list0 = "";
$list1 = "";
?>

<!-- ########### Listes déroulantes ########### -->

<center>
<br>
<br>
<br>
<p><center>Ajouter un établissement: </center></p>
<br>
<table><tr><td><fieldset>
<legend>Sélectionnez&nbsp;:</legend>
<table><form action="xml_liste2.php" name="frm" id="frm" method="POST">
<tr>
   <td align="right">Ville&nbsp;:</td>
   <td><select style="width:200px" name="list0" id="list0" onchange="liste(this.form,1)">
   <option value="">== Choisir ==</option>
   <?php echo $liste_dpt;?>
   <option value="*">== Tout ==</option>
   </select></td>
</tr><tr>
   <td align="right">Etablissement&nbsp;:</td>
   <td><select style="width:200px" name="list1" id="list1" >
   </select></td>
</tr>
<tr>
<td>Indiquez une salle:</td><td><input type="text" name="numsalle" size="29,5"></td>
</tr>
<tr>
   <td ><input type="submit" value="Ajouter" /></td><td><input type="button" value="Retour" onclick="history.go(-1)"/></td></tr>
	  </form></table>
</fieldset></td></tr></table>
</center>


<center>

</center>

</BODY></HTML> 
