<br>
<br>
 <p><center>Veuillez compléter le formulaire suivant en remplissant tout les champs: </center></p>
<br>

<center>
<form method="post" >

<table border=1 cellpading=10 bgcolor="#01C4FF">
<tr><td colspan=3 align center bgcolor="#014DFF"><p><center><b>Informations sur le lieu</b></center></p></td></tr>
<tr><td colspan=3 align center bgcolor="#72F301"><p><center>Enregistrement d'un nouveau lieu</center></p></td></tr>
<tr><td><p>Indiquez le nom du lieu:</p></td><td><input type="text" name="nomlieu" size="50"></td></tr>
<tr><td><p>Indiquez le numéro de salle:</p></td><td><input type="text" name="numsalle" size="50"></td></tr>
<tr><td><p>Indiquez l'adresse du lieu:<br>Adresse secondaire:</p></td><td><input type="text" name="adresse1" size="50"><br><input type="text" name="adresse2" size="50"></td></tr>
<tr><td><p>Indiquez le code postal:</p></td><td><input type="text" name="codepostal" size="50" maxlength="5"></td></tr>
<tr><td><p>Indiquez la ville:</p></td><td><input type="text" name="ville" size="50"></td></tr>
<tr><td><p>Indiquez le pays:</p></td><td><input type="text" name="pays" size="50"></td></tr>
<tr><td><p>Indiquez le numéro de téléphone:</p></td><td><input type="text" name="telephone" size="50" maxlength="12"></td></tr>
<tr><td><p>Indiquez le mail:</p></td><td><input type="text" name="mail" size="50"></td></tr>


<tr>
   <td colspan=3 align right bgcolor="#014DFF">
     <center>
     <input type="submit" name="envoyer" value="Envoyer"/>
     <input type="hidden" name="Suivant2" value="Suivant2"/>
     <?php
	  	echo "<input type=\"hidden\" name=\"typelieu\" value=\"$typelieu\"/>";
     ?>
     </center>
   </td>
</tr>

</table>
</form>
</center>


<!--//////##############################################################################################################//////-->


<?php
if(isset($_POST["envoyer"]))
{

//debut des attributs


@$nomlieu=$_POST["nomlieu"];
@$numsalle=$_POST["numsalle"];
@$adresse1=$_POST["adresse1"];
@$adresse2=$_POST["adresse2"];
@$codepostal=$_POST["codepostal"];
@$ville=$_POST["ville"];
@$pays=$_POST["pays"];
@$telephone=$_POST["telephone"];
@$mail=$_POST["mail"];

//fin des attributs

//debut des requetes
   
 //$requete4="INSERT INTO `collaboratice`.`om_lieu` (`idlieu`, `type_2`, `intitule_lieu`, `adresse1`, `adresse2`, `cp`, `ville`, `pays`, `tel`, `mel`) VALUES ('', '', '$nomlieu', '$adresse1', '$adresse2', '$codepostal', '$ville', '$pays', '$telephone', '$mail');";
 $requete4 = "INSERT INTO `collaboratice`.`repertoire` (`No_societe`, `societe`, `adresse`, `cp`, `ville`, `tel_standard`, `fax`, `internet`, `email`, `remarques`, `a_traiter`, `a_faire_quand_date`, `a_faire_quand_heure`, `a_faire`, `urgent`, `editeur`, `fabricants`, `entreprise_de_service`, `presse_specialisee`, `nb_pb`, `part_fgmm`, `part_salon`, `emetteur`, `statut`, `pays`, `mel_service_client`, `mel_sav`, `mel_service_technique`, `login`, `mot_passe`, `adresse2`, `contacte`) VALUES ('' , '$nomlieu', '$adresse1', '$codepostal', '$ville', '$telephone', NULL , NULL , '$mail', NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , NULL , '0', '0', '0', '', 'public', '$pays', NULL , NULL , NULL , NULL , NULL , '$adresse2', '0');";

 $result4 = mysql_query($requete4,$connexion);
 
 $requete_inter="SELECT MAX(No_societe) AS max FROM repertoire;";
 $result_inter=mysql_query($requete_inter,$connexion);
 $ligne_inter=mysql_fetch_assoc($result_inter);
 
 $idlieu=$ligne_inter["max"];
 
 $requete3 = "INSERT INTO `collaboratice`.`om_salle` (`idsalle`, `idRNE`, `idNo_societe`, `intitule_salle`) VALUES ('', '', '$idlieu', '$numsalle');";
 $result3 = mysql_query($requete3, $connexion);
 
 //fin des requetes

 if($result3 && $result4)
 {
    echo "ça marche !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!";
 }
}   
?>
