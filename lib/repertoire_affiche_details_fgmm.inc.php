<?php
    include("../biblio/init.php");
    /*
    $query = "SELECT * FROM repertoire WHERE No_societe = '".$id_societe."';";
				 $result_consult = mysql_query($query);
				 $num_rows = mysql_num_rows($result_consult);
         if (mysql_num_rows($result_consult))
         {
		        $ligne=mysql_fetch_object($result_consult);
		        $id_societe=$ligne->No_societe;
    
    */
    $query_partenaire_fgmm = "SELECT * FROM fgmm_part_financiere_partenaires,fgmm_hist_particip_partenaires,fgmm_suivi_partenaires WHERE fgmm_part_financiere_partenaires.id_societe = '".$id_societe."' AND fgmm_hist_particip_partenaires.id_societe = '".$id_societe."' AND fgmm_suivi_partenaires.id_societe = '".$id_societe."';";
		$result_partenaire_fgmm = mysql_query($query_partenaire_fgmm);
		if(!$result_partenaire_fgmm)
		{
			echo "<br>Pas de participation financière enregistré pour cette société";
		}
		$num_rows_partenaire_fgmm = mysql_num_rows($result_partenaire_fgmm);
		if (mysql_num_rows($result_partenaire_fgmm))
		{
			$ligne=mysql_fetch_object($result_partenaire_fgmm);
			$participation_1995=$ligne->participation_1995;
			$participation_1996=$ligne->participation_1996;
			$participation_1997=$ligne->participation_1997;
			$participation_1998=$ligne->participation_1998;
			$participation_1999=$ligne->participation_1999;
			$participation_2000=$ligne->participation_2000;
			$participation_2001=$ligne->participation_2001;
			$participation_2002=$ligne->participation_2002;
			$participation_2003=$ligne->participation_2003;
			$participation_2004=$ligne->participation_2004;
			$participation_2005=$ligne->participation_2005;
			$participation_2006=$ligne->participation_2006;
			$participation_2007=$ligne->participation_2007;
			$participation_2008=$ligne->participation_2008;
			$participation_2009=$ligne->participation_2009;
			$participation_2010=$ligne->participation_2010;
			$participation_2011=$ligne->participation_2011;
			$participation_2012=$ligne->participation_2012;
			$participation_2013=$ligne->participation_2013;
			$participation_2014=$ligne->participation_2014;
			$montant95=$ligne->montant95;
			$montant96=$ligne->montant96;
			$montant97=$ligne->montant97;
			$montant98=$ligne->montant98;
			$montant99=$ligne->montant99;
			$montant00=$ligne->montant00;
			$montant01=$ligne->montant01;
			$montant02=$ligne->montant02;
			$montant03=$ligne->montant03;
			$montant04=$ligne->montant04;
			$montant05=$ligne->montant05;
			$montant06=$ligne->montant06;
			$montant07=$ligne->montant07;
			$montant08=$ligne->montant08;
			$montant09=$ligne->montant09;
			$montant10=$ligne->montant10;
			$montant11=$ligne->montant11;
			$montant12=$ligne->montant12;
			$montant13=$ligne->montant13;
			$montant14=$ligne->montant14;
			$dossier_concours_envoye=$ligne->dossier_concours_envoye;
			$dossier_salon_envoye=$ligne->dossier_salon_envoye;
			$participation_concours=$ligne->participation_concours;
			$participation_salon=$ligne->participation_salon;
			$interesse_pour_concours=$ligne->interesse_pour_concours;
			$interesse_pour_salon=$ligne->interesse_pour_salon;
			$refus_concours=$ligne->refus_concours;
			$refus_salon=$ligne->refus_salon;
			$concours_suivant=$ligne->concours_suivant;
			$logo_sur_affiche=$ligne->logo_sur_affiche;
			$lien_logo=$ligne->lien_logo;
			$a_traiter = $ligne->a_traiter;
			$affiche_page_partenaires_fgmm = $ligne->affiche_page_partenaires_fgmm;
		
    //echo "<BR>montant95 : $montant95 - montant96 : $montant96 - montant97 : $montant97";  
		echo "<FORM ACTION = \"repertoire_consult_fiche.php\" METHOD = \"GET\">";
					  
    echo "<BR>
    <TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
      <CAPTION><b>Détails du suivi</b></CAPTION>
      <tr CLASS = \"new\">
        <td>";
          $checked=Testpourcocher($a_traiter);
          echo "A traiter&nbsp;<input type=\"checkbox\" name=\"a_traiter_fgmm\" value=\"1\" $checked></TD>";
          echo "<TD>Partenariat :&nbsp;";
          $checked=Testpourcocher($dossier_concours_envoye);
          echo "Dossier&nbsp;<input type=\"checkbox\" name=\"dossier_concours_envoye\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($interesse_pour_concours);
          echo "intéressé&nbsp;<input type=\"checkbox\" name=\"interesse_pour_concours\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_concours);
          echo "participe&nbsp;<input type=\"checkbox\" name=\"participation_concours\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($refus_concours);
          echo "refus&nbsp;<input type=\"checkbox\" name=\"refus_concours\" value=\"1\" $checked>&nbsp;&nbsp;&nbsp;
        </td>
        <td>
          Salon :&nbsp;";
          $checked=Testpourcocher($dossier_salon_envoye);
          echo "Dossier&nbsp;<input type=\"checkbox\" name=\"dossier_salon_envoye\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($interesse_pour_salon);
          echo "intéressé&nbsp;<input type=\"checkbox\" name=\"interesse_pour_salon\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_salon);
          echo "participe&nbsp;<input type=\"checkbox\" name=\"participation_salon\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($refus_salon);
          echo "refus&nbsp;<input type=\"checkbox\" name=\"refus_salon\" value=\"1\" $checked>
        </td>
      </tr>
    </table>
    <TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
      <tr CLASS = \"new\">
        <td colspan =\"3\">";
          $checked=Testpourcocher($logo_sur_affiche);
          echo "logo sur affiche&nbsp;<input type=\"checkbox\" name=\"logo_sur_affiche\" value=\"1\" $checked>&nbsp;&nbsp;
          lien du logo&nbsp;:&nbsp;<input type=\"text\" value = \"$lien_logo\" name=\"lien_logo\" size=\"30\">
        </TD>
				<td width =\"20%\">afficher dans la page partenaire&nbsp;:&nbsp;
				<td width = \"35%\">";
					$checked=Testpourcocher($affiche_page_partenaires_fgmm);
					echo "<input type=\"checkbox\" name=\"affiche_page_partenaires_fgmm\" value=\"1\" $checked>&nbsp;&nbsp;
				</td>
      </TR>
    </table>
    <TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">
      <tr CLASS = \"new\">
        <td colspan =\"3\">Participations GANTASE :";
          $checked=Testpourcocher($participation_1995);
          echo "1995&nbsp;<input type=\"checkbox\" name=\"participation_1995\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_1996);
          echo "1996&nbsp;<input type=\"checkbox\" name=\"participation_1996\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_1997);
          echo "1997&nbsp;<input type=\"checkbox\" name=\"participation_1997\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_1998);
          echo "1998&nbsp;<input type=\"checkbox\" name=\"participation_1998\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_1999);
          echo "1999&nbsp;<input type=\"checkbox\" name=\"participation_1999\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_2000);
          echo "2000&nbsp;<input type=\"checkbox\" name=\"participation_2000\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_2001);
          echo "2001&nbsp;<input type=\"checkbox\" name=\"participation_2001\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_2002);
          echo "2002&nbsp;<input type=\"checkbox\" name=\"participation_2002\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_2003);
          echo "2003&nbsp;<input type=\"checkbox\" name=\"participation_2003\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_2004);
          echo "2004&nbsp;<input type=\"checkbox\" name=\"participation_2004\" value=\"1\" $checked>&nbsp;
        </td>
      </tr>
      <tr CLASS = \"new\">
        <td colspan =\"3\">Participations au Festival des Génies du Multimédia :&nbsp;";
          $checked=Testpourcocher($participation_2005);
          echo "2005&nbsp;<input type=\"checkbox\" name=\"participation_2005\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_2006);
          echo "2006&nbsp;<input type=\"checkbox\" name=\"participation_2006\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_2007);
          echo "2007&nbsp;<input type=\"checkbox\" name=\"participation_2007\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_2008);
          echo "2008&nbsp;<input type=\"checkbox\" name=\"participation_2008\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_2009);
          echo "2009&nbsp;<input type=\"checkbox\" name=\"participation_2009\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_2010);
          echo "2010&nbsp;<input type=\"checkbox\" name=\"participation_2010\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_2011);
          echo "2011&nbsp;<input type=\"checkbox\" name=\"participation_2011\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_2012);
          echo "2012&nbsp;<input type=\"checkbox\" name=\"participation_2012\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_2013);
          echo "2013&nbsp;<input type=\"checkbox\" name=\"participation_2013\" value=\"1\" $checked>&nbsp;";
          $checked=Testpourcocher($participation_2014);
          echo "2014&nbsp;<input type=\"checkbox\" name=\"participation_2014\" value=\"1\" $checked>&nbsp;
        </td>
      </tr>
      <tr CLASS = \"new\">";
        $checked=Testpourcocher($concours_suivant);
          echo "<td colspan =\"3\">à retenir pour manifestation suivante&nbsp;<input type=\"checkbox\" name=\"concours_suivant\" value=\"1\" $checked></td>
      </tr>
    </table>";
    if ($autorisation_genies == "1")
    {
      echo "
        <TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">	
          <TR>
            <TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications du suivi\"></TD>
			    </TR>
		    </TABLE>";
		}
    echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
		<INPUT TYPE = \"hidden\" VALUE = \"enreg_suivi\" NAME = \"action\">
		<INPUT TYPE = \"hidden\" VALUE = \"".$id_societe."\" NAME = \"id_societe\">
    <BR>
    <TABLE BORDER=\"0\" width = \"95%\" ALIGN=\"CENTER\" BGCOLOR = \"#48D1CC\">
    <CAPTION><b>Participation financière</b></CAPTION>
      <tr>
        <td width=\"9%\" align=\"center\">1995</td>
        <td width=\"9%\" align=\"center\">1996</td>
        <td width=\"9%\" align=\"center\">1997</td>
        <td width=\"9%\" align=\"center\">1998</td>
        <td width=\"9%\" align=\"center\">1999</td>
        <td width=\"9%\" align=\"center\">2000</td>
        <td width=\"9%\" align=\"center\">2001</td>
        <td width=\"9%\" align=\"center\">2002</td>
        <td width=\"9%\" align=\"center\">2003</td>
        <td width=\"9%\" align=\"center\">2004</td>
        <td width=\"10%\" align=\"center\">2005</td>
      </tr>
      <tr CLASS = \"new\">";
        if ($autorisation_genies == "1")
        {
          $nombre_a_afficher = Formatage_Nombre($montant95,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant95\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant96,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant96\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant97,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant97\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant98,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant98\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant99,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant99\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant00,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant00\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant01,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant01\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant02,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant02\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant03,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant03\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant04,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant04\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant05,$monnaie_utilise);
          echo "<td width=\"10%\" align=\"center\"><input type=\"text\" name=\"montant05\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
        }
        else
        {
          $nombre_a_afficher = Formatage_Nombre($montant95,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant96,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant97,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant98,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant99,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant00,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant01,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant02,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant03,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant04,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant05,$monnaie_utilise);
          echo "<td width=\"10%\" align=\"center\">$nombre_a_afficher</td>";
        }
        echo "</tr>
      <tr>
        
        <td width=\"9%\" align=\"center\">2006</td>
        <td width=\"9%\" align=\"center\">2007</td>
        <td width=\"9%\" align=\"center\">2008</td>
        <td width=\"9%\" align=\"center\">2009</td>
        <td width=\"9%\" align=\"center\">2010</td>
        <td width=\"9%\" align=\"center\">2011</td>
        <td width=\"9%\" align=\"center\">2012</td>
        <td width=\"9%\" align=\"center\">2013</td>
        <td width=\"9%\" align=\"center\">2014</td>
        
        <td colspan = \"2\" width=\"19%\" align=\"center\">TOTAL</td>
      </tr>
      <tr CLASS = \"new\">";
        if ($autorisation_genies == "1")
        {
          $nombre_a_afficher = Formatage_Nombre($montant06,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant06\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant07,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant07\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant08,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant08\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant09,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant09\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant10,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant10\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant11,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant11\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant12,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant12\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant13,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant13\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
          $nombre_a_afficher = Formatage_Nombre($montant14,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\"><input type=\"text\" name=\"montant14\" value=\"$nombre_a_afficher\" size=\"6\"></td>";
        }
        else
        {
          $nombre_a_afficher = Formatage_Nombre($montant06,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant07,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant08,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant09,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant10,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant11,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant12,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant13,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
          $nombre_a_afficher = Formatage_Nombre($montant14,$monnaie_utilise);
          echo "<td width=\"9%\" align=\"center\">$nombre_a_afficher</td>";
        }
        $total = $montant95+$montant96+$montant97+$montant98+$montant99+$montant00+$montant01+$montant02+$montant03+$montant04+$montant05+$montant06+$montant07+$montant08+$montant09+$montant10+$montant11+$montant12+$montant13+$montant14;
        $nombre_a_afficher = Formatage_Nombre($total,$monnaie_utilise);
        echo "<td colspan = \"2\" width=\"19%\" align=\"center\">$nombre_a_afficher</td>";
      echo "</tr>
    </table>";
    if ($autorisation_genies == "1")
    {
      echo "
        <TABLE width=\"95%\" BORDER = \"1\" BGCOLOR = \"#48D1CC\">	
          <TR>
            <TD align=\"center\"><INPUT TYPE = \"submit\" VALUE = \"Valider les modifications du suivi\"></TD>
			    </TR>
		    </TABLE>";
		}
    echo "<INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
		<INPUT TYPE = \"hidden\" VALUE = \"enreg_suivi\" NAME = \"action\">
			<INPUT TYPE = \"hidden\" VALUE = \"$part_rt2008\" NAME = \"part_rt2008\">
		<INPUT TYPE = \"hidden\" VALUE = \"".$id_societe."\" NAME = \"id_societe\">
    <BR>
  </FORM>";
    
    $total_lots = 0;
    }
    
    if ($affiche_message_lot == "O")
    {
      echo "<h2>$message_a_afficher</h2>";
    }
    //echo "<br> annee : $annee_en_cours";
    //Récupération des lots de la société
    $query_lots = "SELECT DISTINCT * FROM fgmm_lot WHERE donnateur = $id_societe AND annee = $annee_en_cours ORDER BY lot ASC;";
		$results_lots = mysql_query($query_lots);
		$num_results_lots = mysql_num_rows($results_lots);
		if ($num_results_lots == 0)
		{
		  echo "<FONT COLOR = \"#808080\"><B>Pas de lots trouvés pour cette société</B></FONT>
            <BR><A HREF = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_societe=".$id_societe."&amp;action=ajout_lot\" target = \"body\"><FONT COLOR = \"#000000\"><b>Ajouter un lot<b></A><BR></FONT>";
		}
		else
		{
      echo "  
        <TABLE BORDER=\"0\"  width = \"95%\" ALIGN=\"CENTER\" BGCOLOR = \"#48D1CC\">
            <CAPTION>
              <b>Lots</b>";
              if ($autorisation_genies == "1")
              {
                echo "<BR><A HREF = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_societe=".$id_societe."&amp;action=ajout_lot\" target = \"body\"><FONT COLOR = \"#000000\"><b>Ajouter un lot<b></FONT></A><BR>";
              }
            echo "</CAPTION>
          <tr>
            <td width=\"7%\" align=\"center\">Id</td>
            <td width=\"20%\" align=\"center\">Lot</td>
            <td width=\"10%\" align=\"center\">Valeur</td>
            <td width=\"15%\" align=\"center\">niveau</td>
            <td width=\"5%\" align=\"center\">PS fid.</td>
            <td width=\"5%\" align=\"center\">PS 3proj.</td>
            <td width=\"5%\" align=\"center\">Prix part.</td>
            <td width=\"5%\" align=\"center\">attribué</td>
            <td width=\"5%\" align=\"center\">promis</td>
            <td width=\"5%\" align=\"center\">reçu</td>
            <td width=\"5%\" align=\"center\">matériel</td>";
            if ($autorisation_genies == "1")
            {
              echo "<td width=\8%\" align=\"center\">Actions</td>
                    <td width=\"5%\" align=\"center\">Valider</td>
                </tr>";
		        }
          //Affichage des lots
          $res_lots = mysql_fetch_row($results_lots);
          $total_lots = $total_lots + $res_lots[4];
          for($i = 0; $i < $num_results_lots; ++$i)
					{
					   echo "<FORM ACTION = \"repertoire_consult_fiche.php\" METHOD = \"GET\">";
             echo "<tr CLASS = \"new\">
              <td width=\"7%\" align=\"center\">".$res_lots[0]."</td>
              <td width=\"20%\">".$res_lots[2]."</td>";
              $nombre_a_afficher = Formatage_Nombre($res_lots[4],$monnaie_utilise);
              echo "<td width=\"10%\" align=\"center\">$nombre_a_afficher</td>";
              //echo "<br>promis : $res_lots[5]";
              echo "<td width=\"15%\" align=\"center\">".$res_lots[9]."</td>";
              
              echo "<td width=\"5%\" align=\"center\">"; 
              if ($res_lots[10] == "1")
						  {
                echo "X";
						  }
						  echo "</TD>";
              
              /*
              $checked=Testpourcocher($res_lots[10]);
              echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"ps_fid\" value=\"1\" $checked></td>";
              */
              echo "<td width=\"5%\" align=\"center\">";
              if ($res_lots[11] == "1")
						  {
                echo "X";
						  }
						  echo "</TD>";
              /*
              $checked=Testpourcocher($res_lots[11]);
              echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"ps_3p\" value=\"1\" $checked></td>";
              */
              echo "<td width=\"5%\" align=\"center\">";
              if ($res_lots[12] == "1")
						  {
                echo "X";
						  }
						  echo "</TD>";
              /*
              $checked=Testpourcocher($res_lots[12]);
              echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"p_part\" value=\"1\" $checked></td>";
              */
              echo "<td width=\"5%\" align=\"center\">";
              if ($res_lots[7] <> "0")
						  {
                echo "X";
						  }
						  echo "</TD>";
              if ($autorisation_genies == "1")
              {
                $checked=Testpourcocher($res_lots[5]);
                echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"promis\" value=\"1\" $checked></td>";
                $checked=Testpourcocher($res_lots[6]);
                echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"recu\" value=\"1\" $checked></td>";
                $checked=Testpourcocher($res_lots[8]);
                echo "<td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"materiel\" value=\"1\" $checked></td>";
                echo "<TD width=\"8%\" BGCOLOR = \"#48D1CC\">
                    <A HREF = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_lot=".$res_lots[0]."&amp;id_societe=".$id_societe."&amp;action=modif_lot\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/modifier.png\" ALT = \"modifier\" title=\"Modifier le lot\" border=\"0\"></A>
                    <A HREF = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_lot=".$res_lots[0]."&amp;id_societe=".$id_societe."&amp;action=copie_lot\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/copier.png\" ALT = \"copier\" title=\"Copier le lot\" border=\"0\"></A>
                    <A HREF = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_lot=".$res_lots[0]."&amp;action=suppression_lot\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/supprimer.png\" ALT = \"copier\" title=\"Supprimer le lot\" border=\"0\"></A>
                </TD>
                <TD width=\"5%\" BGCOLOR = \"#48D1CC\" align = \"center\">
                  <INPUT border=0 src = \"$chemin_theme_images/valider.png\" ALT = \"Valider\" title=\"Valider l'enregistrement\" border=\"0\" type=image Value=submit align=\"middle\"> 
                  <!--A HREF = \"repertoire_consult_fiche.php?CHGMT=O&amp;id_lot=".$res_lots[0]."&amp;id_societe=".$id_societe."&amp;promis=".$res_lots[5]."&amp;recu=".$res_lots[6]."&amp;materiel=".$res_lots[8]."&amp;action=enreg_modif_lot\" target = \"body\"><img height=\"$hauteur_icone_action\" width=\"$largeur_icone_action\" src = \"$chemin_theme_images/valider.png\" ALT = \"Valider\" title=\"Valider l'enregistrement\" border=\"0\"></A-->
                </TD>";
              }
              else
              {
                if ($res_lots[5] <> "0")
						    {
                  echo "<td width=\"5%\" align=\"center\">X</TD>";
						    }
						    else
						    {
                  echo "<td width=\"5%\" align=\"center\">&nbsp;</TD>";
                }
						    
						    if ($res_lots[6] <> "0")
						    {
                  echo "<td width=\"5%\" align=\"center\">X</TD>";
						    }
						    else
						    {
                  echo "<td width=\"5%\" align=\"center\">&nbsp;</TD>";
                }
						    
						    if ($res_lots[8] <> "0")
						    {
                  echo "<td width=\"5%\" align=\"center\">X</TD>";
						    }
						    else
						    {
                  echo "<td width=\"5%\" align=\"center\">&nbsp;</TD>";
                }
						    
              }
            echo "</tr>
            <INPUT TYPE = \"hidden\" VALUE = \"O\" NAME = \"CHGMT\">
		        <INPUT TYPE = \"hidden\" VALUE = \"enreg_modif_lot\" NAME = \"action\">
		        <INPUT TYPE = \"hidden\" VALUE = \"".$id_societe."\" NAME = \"id_societe\">
		        <INPUT TYPE = \"hidden\" VALUE = \"".$res_lots[0]."\" NAME = \"id_lot\">
          </FORM>";
          
            $res_lots = mysql_fetch_row($results_lots);
            $total_lots = $total_lots + $res_lots[4];
         }
         $nombre_a_afficher = Formatage_Nombre($total_lots,$monnaie_utilise);
         echo "<tr>
            <td align = \"center\" colspan=\"13\"><b>Nombre total de lots : $num_results_lots&nbsp;&nbsp;&nbsp;Valeur totale des lots&nbsp;:&nbsp;$nombre_a_afficher</b></td>
            </td>
          </tr>
        </table>
        ";
      
    
    }

?>
