<?php
session_start();

		@mysql_close();
		@mysql_connect("localhost","bright91","ecoFemuLep");
		$select_base=@mysql_selectdb("sites");
		if(isset($_POST['val_sel']) AND $_POST['val_sel']!="")
		{
			$rne=$_POST['val_sel'];
		}
		else
		{
			$rne=$rne_utilisateur;
		}
		
		$requete = "select nom_dossier, url, nom_serveur, si.id_site, prenom, nom, email from site si, serveurs se, webmestre W, webmestre_site WS  where si.serveur = se.id_serveur and rne like '".$rne."' and WS.id_webmestre = W.id_webmestre  and si.id_site = WS.id_site  order by nom_dossier";
		$resultat = mysql_query($requete);
		//echo $requete;
		//echo "val_sel :".$_POST['val_sel'];
		echo"<table border = '1' width = '80%'>";
			while ($ligne=mysql_fetch_array($resultat))
			{	//echo $requete."<br />";
				//echo "test liste_site.php";
				//bidon();
				$requete1 = "select * from webmestre W, webmestre_site WS where email like '".$_SESSION['mail_utilisateur']."' and WS.id_site=".$ligne['id_site']." and WS.id_webmestre = W.id_webmestre";
				//echo "Webmestre : ".$requete1."<br />";
				$resultat1 = mysql_query($requete1);
						if (mysql_num_rows($resultat1)>0)
						{
						$_SESSION['niveau'] = 2;
						}
						else
						{
						$_SESSION['niveau'] = 1;
						}
						//$ligne=mysql_fetch_array($resultat);
						//echo "Webmestre : ".$ligne[0].$ligne[1].$ligne[2].$ligne[3]." <br />";
				$requete1 = "select * from responsable R, responsable_site RS where email like '".$_SESSION['mail_utilisateur']."' and RS.id_site=".$ligne['id_site']." and RS.id_responsable = R.id_responsable";
				//echo "Responsable : ".$requete1."<br />";
				$resultat1 = mysql_query($requete1);
					if (mysql_num_rows($resultat1) > 0)
					{
					$_SESSION['niveau'] = 3;
					}
					else
					{
						if($_SESSION['niveau'] == 2)
						{
							$_SESSION['niveau'] = 2;
						}
						else
						{
							$_SESSION['niveau'] = 1;
						}
					}
					//$ligne=mysql_fetch_array($resultat);
					//echo "Responsable :".$ligne[0].$ligne[1].$ligne[2].$ligne[3]." <br />";
				//if(verif_nom_serveur($ligne[2]))
				//{
				$lien = str_replace('<nom_site>', $ligne[0], $ligne[1]);
				echo"<tr>
				<td width='40%'> 
				<a href = 'http://".$lien."'>".$ligne[0]."</a>
				</td>
				<td>
				<a href='mailto:".$ligne[6]."'>".$ligne[4]." ".$ligne[5]."
				</td>";
			
				if ($_SESSION['niveau'] > 1)
				{
					echo"<td>
					<a href = 'nouvelle_demande.php?serveur=".$ligne[2]."&nom_doss=".$ligne[0]."'>?</a>
					</td>
					<td>
					<a href = 'nouvelle_demande.php?serveur=".$ligne[2]."&nom_doss=".$ligne[0]."&pre=Mdp%20Perdu'>R-MDP</a>
					</td>";
				}
				if ($_SESSION['niveau'] == 3)
				{
					echo"
					<td>
					<a href = 'nouvelle_demande.php?serveur=".$ligne[2]."&nom_doss=".$ligne[0]."&pre=Suppression%20Site'>X</a>
					</td>
					<td>
					<a href = 'nouvelle_demande.php?serveur=".$ligne[2]."&nom_doss=".$ligne[0]."&pre=Changer%20Mdp'>C-MDP</a>
					</td>
					<td>
					<a href = 'nouvelle_demande.php?serveur=".$ligne[2]."&nom_doss=".$ligne[0]."&pre=Demande%20Formation'>Formation</a>
					</td>";
					//echo"<td>
					//* Historique
					//</td>";
				}
				echo"</tr>";
			}
		//	}
			echo"</table>";
			?>