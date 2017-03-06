<?php
	//Lancement de la session
	session_start();

	if(!isset($_SESSION['id_util']))
	{
		echo "<br /><br /><br /><br /><center><b>$message_non_connecte1</b></center>";
		echo "<br /><br /><center><A target=\"_top\" HREF=\"../index.php\" class = \"bouton\">$message_non_connecte2</a></center>";
		exit;
	}
	header('Content-Type: text/html;charset=UTF-8');
?>
<!DOCTYPE HTML>
<?php
	//$theme = $_SESSION['theme'];
	$theme = $_SESSION['chemin_theme']."collaboratice_principal.css";
	$chemin_theme_images = $_SESSION['chemin_theme']."images";
echo"
<html>
<head>
	<title>CollaboraTICE</title>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
	<link href=\"$theme\" rel=\"stylesheet\" type=\"text/css\" />";
?>
<style>
.divCal {position:absolute;border:1px red dashed;background:#ffffff;}
.divCal a{text-decoration:none; width:100%;}
.divCal table {font-size:12px;font-family:Tahoma;text-align:center;margin:0px;width:140px;}
.divCal td {margin : 0px;border:1px solid #E5E0E1;}
.divCal .zoneTitre {font-size:12px;font-family:Tahoma;text-align:center;margin:0px;background:pink;}
.divCal .zoneNav {font-size:10px;font-family:Tahoma;text-align:center;margin:0px;cursor:pointer;}
.divCal .zoneMois {font-family:Tahoma;width:70px;margin:0px;}
.divCal .zoneAnnee {font-size:10px;font-weight:bold;text-align:right;margin:0px;width:100%;}
.divCal .nSemaine {font-family:Tahoma;width:30px;margin:0px;color:green;}
.divCal div{ margin : 0px;}

.divCal .tdx {color:#F0F0F0;} /*par defaut*/
.divCal .tdx .enWeekend {background:#C0C0C0;}
.divCal .tdx .enFeriee {background:#C0C0C0;}
.divCal .tdx .enMois {color:black;font-weight:bold;}
.divCal .tdx .aujourdhui {border:2px solid red;}

.divCal .tdxNow {color:black;font-weight:bold;} 
.divCal .tdxNow:hover {background:pink;} 

.divCal .tdx:hover {background:pink;}
.divCal .tdx:hover .enWeekend {background:pink;}
.divCal .tdx:hover .enMois {color:black;font-weight:bold;background:pink;} /*pour firefox */
</style>

<script language="javascript">
/****************
* script MICRO-CAL par Amroune Selim (amrounix@gmail.com)
*toutes copies, diffusions,modifications ou améliorations sont autorisées
****************/
/*--cette partie du script peut être copié dans un fichier .js --*/
/*variable globale*/
var pDefaut = {"mois" : new Array("Janvier","F&eacute;vrier","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","D&eacute;cembre"),
"jour" : new Array("Di","Lu","Ma","Me","Je","Ve","Sa"),"jLib" : new Array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi"),
"titre" : "calendrier","aujourdhui" : "aujourd'hui",
"debutSemaine" : 1, /*debut de la semaine 0=dim,1=lun,...*/
"jPause" : {6:true,0:true},/*jour de pause de la semaine (samedi & dimanche)*/
"jFeriee": {"1-1":"jour an","1-5":"fête du travail","8-5":"armistice","14-7":"fête nationale","15-8":"ascencion","1-11":"armistice","11-11":"toussain","25-12":"noel"} ,
"moisMoins" : "-","moisPlus" : "+", /*naviagation par mois*/ "anneeMoins" : "<","anneePlus" : ">", /*naviagation par annee*/
"format" : "%j-%m-%a" /*format de sortie : %j = jour, %m = mois, %a =année*/ }
var tempo = new Array(); /*gestion de la fermeture des calendriers quand on perd le focus*/

function nbJ(dateX) /*Retourne le nombre de jour depuis le 1er janvier (pr le num de semaine)*/
{
   var j_mois=[0,31,59,90,120,151,181,212,243,273,304,334];
   mm=dateX.getMonth();aa=dateX.getFullYear();nb=j_mois[mm]+dateX.getDate()-1 ; 
   if ((aa%4==0 && aa %100!=0 || aa%400==0) && mm>1) nb++; /*test bissextile*/
   return nb;
}

function gCal(src,srcId,mm,yy) /*génère le calendrier*/
{
   if (tempo!=null&&tempo[srcId]!=null) 
   {
      clearTimeout(tempo[srcId]);
      document.getElementById(src).focus();
   }
   if (mm<0) {mm+=12;yy--;} 
      else if (mm>11) {mm-=12;yy++;}
   dnow=new Date();
   param=document.getElementById(srcId).parametre;
   htm="<table cellpadding=0 cellspacing=0 border>";
   /*titre*/
   if (param["titre"]!= null ) 
      {htm+="<tr><td colspan='8' class='zoneTitre' >"+param["titre"]+"</td></tr>";}
   /*entete*/
   htm+="<tr><td colspan='8'><table border width='100%' cellpadding=0 cellspacing=0 ><tr>";
   htm+="<td class='zoneNav' onclick=\"gCal('"+src+"','"+srcId+"',"+mm+","+(yy-1)+")\">"+param["anneeMoins"]+"</td>";
   htm+="<td class='zoneNav' onclick=\"gCal('"+src+"','"+srcId+"',"+(mm-1)+","+yy+")\">"+param["moisMoins"]+"</td>";
   htm+="<td class='zoneMois'>"+param["mois"][mm]+"</td>";
   htm+="<td class='zoneNav' onclick=\"gCal('"+src+"','"+srcId+"',"+(mm+1)+","+yy+")\" >"+param["moisPlus"]+"</td>";
   htm+="<td class='zoneNav' onclick=\"gCal('"+src+"','"+srcId+"',"+mm+","+(yy+1)+")\">"+param["anneePlus"]+"</td>";
   htm+="</tr></table></td></tr>";
   /*jour*/
   htm+="<tr><td></td>";
   pJs = param["debutSemaine"];
   pJm = new Date(yy,mm,1).getDay(); /*jour du 1ere du mois*/
   pjT = 1-pJm+pJs;
   pjT-=(pjT>1)?7:0;
   dateX = new Date(yy,mm,pjT);
   for (j=0;j<7;j++) 
      {htm+="<td>"+param["jour"][(j+pJs)%7]+"</td>";} 
   htm+="</tr>";
   avantFinMois=true;idx=0;idxM=parseInt(nbJ(new Date(yy,mm,1))/7+1,10);
   while(avantFinMois)
   {
      htm+=(idx%7==0)?"<tr><td class='nSemaine' >"+idxM+"</td>":"";
      htm+="<td><a class='tdx' href='#' onclick=\"javascript:choix("+dateX.getFullYear()+","+dateX.getMonth()+","+dateX.getDate()+",'"+srcId+"','"+src+"')\"   >"+subDiv(param,idx,dateX,mm,aa,0)+"</a></td>";
      idx++;
      if (idx%7==0)
         {htm+="</tr>"; idxM++;}
         dateX= new Date(dateX.getFullYear(),dateX.getMonth(),dateX.getDate()+1);
      if (idx>7&&idx%7==0&&dateX.getMonth()!=mm) 
         {avantFinMois=false;}
   }
   /*annee*/htm+="<tr><td colspan='6'><a class='tdxNow' href='#' onclick=\"javascript:choix("+dnow.getFullYear()+","+dnow.getMonth()+","+dnow.getDate()+",'"+srcId+"','"+src+"')\"   >"+param["aujourdhui"]+"</a></td><td colspan='2'  class='zoneAnnee'>"+yy+"</td></tr>";
   htm+="</table>";
   document.getElementById(srcId).innerHTML=htm;
}
function addZero(val) { return ((val<10)?"0":"")+val;}
function choix(aa,mm,jj,srcId,src)
{
var datePos=new Date(aa,mm,jj);var jour = datePos.getDay(); 
param=document.getElementById(srcId).parametre;
var dateAffiche = param["format"].replace("%j",addZero(datePos.getDate())).replace("%k",datePos.getDate()).replace("%d",param["jLib"][jour]);
dateAffiche = dateAffiche.replace("%m",addZero(datePos.getMonth()+1)).replace("%n",datePos.getMonth()+1).replace("%p",param["mois"][datePos.getMonth()]);
dateAffiche = dateAffiche.replace("%a",datePos.getFullYear()).replace("%y",datePos.getYear());
document.getElementById(src).value = dateAffiche; 
}

function subDiv(param,idx,dateX,mm,aa,code)
{
   pJs = param["debutSemaine"];
   dnow=new Date();
   switch(code)
   {
      case 0 : return (param["jPause"][(idx+pJs)%7]==true) ? "<div class='enWeekEnd' >"+subDiv(param,idx,dateX,mm,aa,1)+"</div>" : subDiv(param,idx,dateX,mm,aa,1) ; break;
      case 1 : return (param["jFeriee"][dateX.getDate()+"-"+(dateX.getMonth()+1)]!=null) ? ("<div class=\"enFeriee\" title=\""+param["jFeriee"][dateX.getDate()+"-"+(dateX.getMonth()+1)]+"\"  >"+subDiv(param,idx,dateX,mm,aa,2)+"</div>") : subDiv(param,idx,dateX,mm,aa,2) ; break;
      case 2 : return (dateX.getMonth()==mm) ? "<div class='enMois' >"+subDiv(param,idx,dateX,mm,aa,3)+"</div>" : subDiv(param,idx,dateX,mm,aa,3) ; break;
      case 3 : return (dateX.getMonth()==dnow.getMonth()&&dateX.getFullYear()==dnow.getFullYear()&&dateX.getDate()==dnow.getDate()) ? "<div class='aujourdhui' >"+subDiv(param,idx,dateX,mm,aa,4)+"</div>" : subDiv(param,idx,dateX,mm,aa,4) ; break;
      case 4 : return dateX.getDate() ; break;
   }
}

function visuCal(src,paramX)
{
   srcId = src.id+"_cal";
   if (document.getElementById(srcId)==null)
   {
      param={}
      for (e in pDefaut)
      {trouve=false;
       if (paramX!=null) 
         for (i in paramX) { if (e==i) {param[e]=paramX[e];trouve=true;} }
      if (!trouve) param[e]=pDefaut[e];
      }
      dnow= new Date();
      div = document.createElement('div');
      div.setAttribute('id',srcId);
      div.style.position = 'absolute';   
      div.style.top = src.offsetTop + src.offsetHeight + 'px';
      div.style.left = src.offsetLeft + 'px'; /*this.deltaG = 0;  */
      div.className = 'divCal'; 
      div.parametre = param;
      document.body.appendChild(div);
      gCal(src.id,srcId,dnow.getMonth(),dnow.getFullYear(),param);
   } else
   {
      document.getElementById(src.id+"_cal").style.display='inline';
   }
}

function masqueCal(src)
{
 tempo[src.id+"_cal"]=window.setTimeout("document.getElementById('"+src.id+"_cal').style.display='none'",500);
}
/******fin de la partie du script qui peut être copiée dans un fichier.js ******/
</script>

<script language="javascript">
/* Test une date (JJ/MM/AAAA) si elle est correct...spécial killer */
function testTypeDate(src)    
{
   tst=false;
   try
   {rc=src.split("/");nd=new Date(rc[2],(rc[1]-1),rc[0]);
   tst=(rc[2]>1800&&rc[2]<2200&&rc[2]==nd.getFullYear()&&rc[1]==(nd.getMonth()+1)&&rc[0]==nd.getDate());
   } catch(e) {}
   return tst?'black':'red';
}
/* création d'un paramétrage spécifique pour le changement de langue ou de propriété */
paramGB={"mois" : new Array("January","February","March","April","May","June","July","August","September","October","November","December"),
"jour" : new Array("Su","Mo","Tu","We","Th","Fr","Sa"), "jLib" : new Array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"), 
"jFeriee" : {"26-5":"memorial Day","29-5":"JFK Birthday","14-6":"Flag Day","15-6":"Father's Day","1-9":"Labor Day","11-9":"Patriot Day","13-10":"Columbus Day","31-10":"Halloween", "2-11" : "Daylight Saving Time Ends" , "4-11" : "Election Day", "11-11" : "Veteran's Day" , "27-11" : "Thanksgiving" , "24-12" : "Christmas Eve" , "25-12" : "Christmas"},
"debutSemaine" : 0, "format": "%a-%m-%j" , "titre" : "start","aujourdhui" : "now"}
paramLib={"titre": "date par libellé","format" : "%d, %k %p %a"}
</script>
<?php
echo"
</head>
<body class = \"menu-boutons\">";
?>

<div align=left>
<table>
<a href = "om_affichage_reunion.php" target = "body" class=\"bouton\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om_Reunion.png" border="0" width=40 height=40%></img>Réunion</a>
&nbsp;
<?php
	include ("../biblio/init.php");

	echo'
	&nbsp;&nbsp;<form action="om_affichage_reunion.php" target="body" method="post">';
	//echo "&nbsp;Intitul&eacute; Réunion : <input type="text" name="search"/>";

	$requete_intitule_reunion="SELECT DISTINCT intitule_reunion FROM om_reunion ORDER BY intitule_reunion";
	
	$result_intitule_reunion=mysql_query($requete_intitule_reunion);
	$num_rows = mysql_num_rows($result_intitule_reunion);
	echo "Intitul&eacute; R&eacute;union&nbsp;:&nbsp;<select size=\"1\" name=\"search\">";
	if (mysql_num_rows($result_intitule_reunion))
	{
  
		echo "<option selected value=\"T\">Tous</option>";
		while ($ligne=mysql_fetch_object($result_intitule_reunion))
		{
			$intitule_reunion=$ligne->intitule_reunion;
			echo "<option value=\"$intitule_reunion\">$intitule_reunion</option>";
		}
	}
	echo "</select>"; 

	echo '&nbsp;&nbsp;Etat :
	<select name="etat">
	<option value="">Tout</option>
	<option value="0">non traité</option>
	<option value="1">traité</option>
	</select>&nbsp;&nbsp;&nbsp;
	<input type="submit" name="validRecherche" value="Rechercher" />
	</form>';

	/*
	echo'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<form method="post" target="body" action="om_affichage_reunion.php">
	&nbsp;&nbsp;Date de début : <input type="text" maxlength="10" name="date" id="dateDebut" onfocus="visuCal(this);" onblur="masqueCal(this);" onkeyup="this.style.color=testTypeDate(this.value)">&nbsp;&nbsp;&nbsp;
	<input type="submit" name="validDate" value="Recherche sur la date" />
	</form>
	';
	*/
?>
<BR />
<a href = "om_affichage_om.php" target = "body" class=\"bouton\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/om_om.png" border="0" width=40 height=40%></img>OM</a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
	echo'
	&nbsp;&nbsp;<form action="om_affichage_om.php" target="body" method="post">';
	echo'&nbsp;Personnes : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="searchpers"/>&nbsp;
	&nbsp;&nbsp;Etat :
	<select name="etat">
	<option value="">Tout</option>
	<option value="0">non traité</option>
	<option value="1">traité</option>
	</select>&nbsp;&nbsp;&nbsp;

	<select name="etat_om">
	<option value="">Tout</option>
	<option value="C">Convoqué</option>
	<option value="P">Présent</option>
	<option value="A">Absent</option>
	<option value="V">Validé</option>
	<option value="R">Refusé</option>
	</select>&nbsp;&nbsp;&nbsp;
	<input type="submit" name="validRecherche_om" value="Rechercher" />
	</form>';

?>
</table>
</div>	
</body>
</html>

