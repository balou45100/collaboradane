<map version="0.9.0">
<!--To view this file, download free mind mapping software Freeplane from http://freeplane.sourceforge.net -->
<node TEXT="Publipostage dans CollaboraTICE" ID="ID_1918264241" CREATED="1274478085203" MODIFIED="1274510043156">
<hook NAME="MapStyle" max_node_width="600"/>
<node TEXT="fonctionalit&#xe9;s" POSITION="right" ID="ID_533252006" CREATED="1274508215437" MODIFIED="1274964263078" HGAP="31" VSHIFT="-8">
<node TEXT="listes des destinataires" ID="ID_1951741276" CREATED="1274508531843" MODIFIED="1274509324828">
<node TEXT="cr&#xe9;ation" ID="ID_1116676629" CREATED="1274508547843" MODIFIED="1274508552500">
<node TEXT="r&#xe9;pertoires Collaboratice" ID="ID_100814319" CREATED="1274508684531" MODIFIED="1274508803953">
<node TEXT="s&#xe9;lections multiples" ID="ID_1076041413" CREATED="1274478371890" MODIFIED="1274509498750">
<richcontent TYPE="NOTE">
<html>
  <head>
    
  </head>
  <body>
    <p>
      plusdieurs fonctions, plisieurs ann&#233;es, plusieurs types d'&#233;tablissements, les partenaires des Rencontres TICE &#224; traiter, ...
    </p>
  </body>
</html></richcontent>
<node TEXT="personnes ressources" ID="ID_1534342055" CREATED="1274508724187" MODIFIED="1274508731796"/>
<node TEXT="ECL" ID="ID_1258602600" CREATED="1274508733921" MODIFIED="1274508749265"/>
<node TEXT="sci&#xe9;t&#xe9;s" ID="ID_529178047" CREATED="1274508753140" MODIFIED="1274508757546"/>
<node TEXT="contacts (publics)" ID="ID_623058197" CREATED="1274508776484" MODIFIED="1274866813632"/>
</node>
</node>
<node TEXT="import CSV" ID="ID_1686302319" CREATED="1274508611031" MODIFIED="1274508620046"/>
<node TEXT="manuelle" ID="ID_29121427" CREATED="1274509047640" MODIFIED="1274509383062"/>
</node>
<node TEXT="modification" ID="ID_1713199974" CREATED="1274508554656" MODIFIED="1274508560609">
<node TEXT="ajout de destinataires" ID="ID_569376940" CREATED="1274509121343" MODIFIED="1274509179312"/>
<node TEXT="exclusion de destinaires" ID="ID_954929685" CREATED="1274509152531" MODIFIED="1274509165609"/>
<node TEXT="suppression de destinataires" ID="ID_559983002" CREATED="1274509245250" MODIFIED="1274509256312"/>
</node>
<node TEXT="suppreession" ID="ID_227913717" CREATED="1274508563031" MODIFIED="1274508569453"/>
<node TEXT="sauvegarde" ID="ID_1442537162" CREATED="1274508599453" MODIFIED="1274508608250"/>
<node TEXT="exportation ??" ID="ID_695815862" CREATED="1274509541953" MODIFIED="1274509550359"/>
<node TEXT="Lien avec les etablissement" ID="ID_1650302212" CREATED="1275599815837" MODIFIED="1275599872833">
<icon BUILTIN="idea"/>
<node TEXT="Select codeetab from pers ress where mail in (liste des mails)" ID="ID_1844775386" CREATED="1275599825750" MODIFIED="1275599860836"/>
<node TEXT="condition : quand on selectionne pers ressource" ID="ID_797837369" CREATED="1275599988841" MODIFIED="1275600007906">
<node TEXT="session =&gt; etab = oui" ID="ID_1783326402" CREATED="1275600012841" MODIFIED="1275600027211"/>
</node>
</node>
</node>
<node TEXT="message" ID="ID_1753636033" CREATED="1274508386125" MODIFIED="1274946913789" HGAP="33" VSHIFT="1">
<node TEXT="saisie avec FCKeditor" ID="ID_539711025" CREATED="1274478283921" MODIFIED="1274946907819" HGAP="23" VSHIFT="6"/>
<node TEXT="utilisation de champs &quot;variables&quot;" ID="ID_367263224" CREATED="1274478261125" MODIFIED="1274946905844" VSHIFT="15">
<node TEXT="$corps = str_replace(&quot;*nom*&quot;,$nom,$corps);" ID="ID_1426152986" CREATED="1274950879474" MODIFIED="1275030813136"/>
<node TEXT="mette civilite dans contact" ID="ID_1714152960" CREATED="1275600341955" MODIFIED="1275600353672" COLOR="#ff0000">
<font NAME="Liberation Sans" SIZE="12"/>
<icon BUILTIN="yes"/>
</node>
</node>
<node TEXT="joindre des pi&#xe8;ces" ID="ID_362704683" CREATED="1274508201625" MODIFIED="1274946902884" VSHIFT="15">
<node TEXT="pi&#xe8;ces diff&#xe9;rentes par destinataire" ID="ID_697352748" CREATED="1274772025500" MODIFIED="1274787154652" HGAP="28"/>
</node>
</node>
<node TEXT="test avant envoi d&#xe9;finitif" ID="ID_286100624" CREATED="1274478505281" MODIFIED="1274946891516" HGAP="50" VSHIFT="36">
<node TEXT="Se renseigner temporisation en PHP" ID="ID_45422572" CREATED="1274866509585" MODIFIED="1274946897699" HGAP="49" VSHIFT="2">
<node TEXT="Fonction sleep()" ID="ID_814820496" CREATED="1274946869970" MODIFIED="1274946877048"/>
</node>
</node>
<node TEXT="Pouvoir choisir l&apos;adresse de r&#xe9;ponse" ID="ID_904936839" CREATED="1274858632301" MODIFIED="1274946893829" HGAP="30" VSHIFT="44"/>
</node>
<node TEXT="organisation" POSITION="left" ID="ID_1366238839" CREATED="1274511214343" MODIFIED="1274511218453">
<node TEXT="BDD" ID="ID_1843589448" CREATED="1274508285109" MODIFIED="1274508295937">
<node TEXT="pr&#xe9;fixe &quot;pp_&quot;" ID="ID_228205720" CREATED="1274508311796" MODIFIED="1274509850671">
<richcontent TYPE="NOTE">
<html>
  <head>
    
  </head>
  <body>
    <p>
      ex : pp_listes
    </p>
  </body>
</html></richcontent>
</node>
<node TEXT="structure de tables ouverte" ID="ID_1115679744" CREATED="1274509749312" MODIFIED="1274509832328">
<richcontent TYPE="NOTE">
<html>
  <head>
    
  </head>
  <body>
    <p>
      &#233;viter de la redondance
    </p>
    <p>
      travailler avec des tables de &quot;liaison&quot;
    </p>
  </body>
</html></richcontent>
</node>
<node TEXT="contraintes de nommage" ID="ID_1869369746" CREATED="1274509937593" MODIFIED="1274509947906">
<node TEXT="pas de majuscules pour les noms des tables et champs" ID="ID_1202491879" CREATED="1274509879640" MODIFIED="1274509904812"/>
<node TEXT="pas d&apos;espaces dans les noms de tables et des champs" ID="ID_860830970" CREATED="1274509907968" MODIFIED="1274509930812"/>
<node TEXT="remplacer les espaces par des &quot;_&quot;" ID="ID_1436759772" CREATED="1274509963671" MODIFIED="1274509976390"/>
<node TEXT="pas de caract&#xe8;re accentu&#xe9;s" ID="ID_1994017234" CREATED="1274509978968" MODIFIED="1274509990609"/>
</node>
</node>
<node TEXT="scripts" ID="ID_1062513469" CREATED="1274508298453" MODIFIED="1274508304562">
<node TEXT="pr&#xe9;fixe &quot;pp_&quot; pour les noms" ID="ID_1250483080" CREATED="1274508311796" MODIFIED="1274510576406">
<richcontent TYPE="NOTE">
<html>
  <head>
    
  </head>
  <body>
    <p>
      ex : pp_cration_listes.php
    </p>
  </body>
</html></richcontent>
</node>
<node TEXT="indentation du code" ID="ID_689581187" CREATED="1274509613750" MODIFIED="1274509622140"/>
<node TEXT="ajout de commentaires" ID="ID_496188202" CREATED="1274509625234" MODIFIED="1274510545906"/>
<node TEXT="utilisation de CSS" ID="ID_934321897" CREATED="1274509657546" MODIFIED="1274509693750">
<richcontent TYPE="NOTE">
<html>
  <head>
    
  </head>
  <body>
    <p>
      pas de balises de formatage
    </p>
  </body>
</html></richcontent>
</node>
<node TEXT="pas de caract&#xe8;res sp&#xe9;ciaux dans le textes" ID="ID_1025365339" CREATED="1274510304593" MODIFIED="1274510609468">
<richcontent TYPE="NOTE">
<html>
  <head>
    
  </head>
  <body>
    <p>
      ex : &#233; = &amp;eacute; ....
    </p>
  </body>
</html></richcontent>
</node>
<node TEXT="utiliser des fonctions" ID="ID_1054047990" CREATED="1274509710828" MODIFIED="1274510646453"/>
<node TEXT="utiliser des &quot;biblioth&#xe8;ques&quot;" ID="ID_576351103" CREATED="1274510659281" MODIFIED="1274510674625"/>
<node TEXT="contraintes de nommage" ID="ID_1120651590" CREATED="1274509937593" MODIFIED="1274509947906">
<node TEXT="Variables" ID="ID_435008244" CREATED="1274510198250" MODIFIED="1274510204015">
<node TEXT="pas de majuscules" ID="ID_1710466793" CREATED="1274510287843" MODIFIED="1274510295328"/>
<node TEXT="possible d&apos;introduire des &quot;_&quot; pour augmenter la lisibilit&#xe9;" ID="ID_557309200" CREATED="1274509907968" MODIFIED="1274773545881"/>
</node>
<node TEXT="Constantes" ID="ID_1181217593" CREATED="1274510208515" MODIFIED="1274510214875">
<node TEXT="en majuscules" ID="ID_1505170595" CREATED="1274510174953" MODIFIED="1274510716140"/>
</node>
<node TEXT="balises" ID="ID_1942442525" CREATED="1274510218687" MODIFIED="1274510221859">
<node TEXT="en minuscules" ID="ID_599710791" CREATED="1274510724218" MODIFIED="1274510730625"/>
<node TEXT="pr&#xe9;f&#xe9;rer les balises XML" ID="ID_493456004" CREATED="1274510733671" MODIFIED="1274510763140">
<richcontent TYPE="NOTE">
<html>
  <head>
    
  </head>
  <body>
    <p>
      ex &lt;br /&gt;
    </p>
  </body>
</html></richcontent>
</node>
</node>
</node>
<node TEXT="pr&#xe9;f&#xe9;rer la methode POST pour la transmission des variables" ID="ID_312820009" CREATED="1274510353312" MODIFIED="1274510383031"/>
</node>
<node TEXT="outils" ID="ID_832043510" CREATED="1274511304906" MODIFIED="1274511308421">
<node TEXT="&#xe9;diteur de scripts" ID="ID_594141072" CREATED="1274511351359" MODIFIED="1274511362234"/>
<node TEXT="Wampserver" ID="ID_1565136794" CREATED="1274511310453" MODIFIED="1274511319281"/>
<node TEXT="FileZilla" ID="ID_900182092" CREATED="1274511325781" MODIFIED="1274511334875"/>
</node>
</node>
<node TEXT="forme" POSITION="left" ID="ID_1440157484" CREATED="1274511235953" MODIFIED="1274511240906">
<node TEXT="ergonomie" ID="ID_1808825700" CREATED="1274510839875" MODIFIED="1274510845421">
<node TEXT="penser &#xe0; l&apos;utilisateur final" ID="ID_537535471" CREATED="1274510851453" MODIFIED="1274510864984"/>
<node TEXT="interfaces coh&#xe9;rents pour les diff&#xe9;rentes fonctionnalit&#xe9;s" ID="ID_1201015111" CREATED="1274510867656" MODIFIED="1274510942828"/>
<node TEXT="respecter l&quot;ergonomie g&#xe9;n&#xe9;rale de CollaboraTICE" ID="ID_109543166" CREATED="1274510955687" MODIFIED="1274510981000">
<node TEXT="affichage des donn&#xe9;es" ID="ID_1998923771" CREATED="1274510984390" MODIFIED="1274510998781"/>
<node TEXT="type de bouton de navigation" ID="ID_249164743" CREATED="1274511002015" MODIFIED="1274780156062"/>
<node TEXT="s&#xe9;lecteur des crit&#xe8;res" ID="ID_1655439413" CREATED="1274511014546" MODIFIED="1274511023953"/>
<node TEXT="&#xe9;viter d&apos;ouvrir de fen&#xea;tres suppl&#xe9;mentaires" ID="ID_1974683536" CREATED="1274511041109" MODIFIED="1274511070031"/>
</node>
</node>
<node TEXT="esth&#xe9;tique" ID="ID_266685578" CREATED="1274511093937" MODIFIED="1274511100437">
<node TEXT="utiliser la CSS principale" ID="ID_383391409" CREATED="1274511103062" MODIFIED="1274511139359">
<richcontent TYPE="NOTE">
<html>
  <head>
    
  </head>
  <body>
    <p>
      &#233;vebtuellement l'am&#233;liore ou abonder
    </p>
  </body>
</html></richcontent>
</node>
<node TEXT="choix d&apos;ic&#xf4;nes suppl&#xe9;mentaires" ID="ID_1616547728" CREATED="1274511142484" MODIFIED="1274511157046"/>
</node>
</node>
<node TEXT="&#xe0; rajouter" POSITION="right" ID="ID_1289282374" CREATED="1276847730093" MODIFIED="1276860539803" HGAP="31" VSHIFT="44">
<node TEXT="ameliorer sauvegarde" ID="ID_332199917" CREATED="1276847735029" MODIFIED="1276862461641">
<richcontent TYPE="NOTE">
<html>
  <head>
    
  </head>
  <body>
    <p>
      fait
    </p>
  </body>
</html>
</richcontent>
</node>
<node TEXT="preciser nature des champs" ID="ID_863398797" CREATED="1276847748953" MODIFIED="1276862642959">
<richcontent TYPE="NOTE">
<html>
  <head>
    
  </head>
  <body>
    <p>
      fait
    </p>
  </body>
</html>
</richcontent>
</node>
<node TEXT="Seulement si clic sur lien etablissemeny" ID="ID_86556901" CREATED="1276848018388" MODIFIED="1276863819819">
<richcontent TYPE="NOTE">
<html>
  <head>
    
  </head>
  <body>
    <p>
      fait
    </p>
  </body>
</html>
</richcontent>
</node>
<node TEXT="Lien de retour" ID="ID_1904006589" CREATED="1276848029925" MODIFIED="1276863813727">
<richcontent TYPE="NOTE">
<html>
  <head>
    
  </head>
  <body>
    <p>
      fait
    </p>
  </body>
</html>
</richcontent>
</node>
<node TEXT="effacer les variables sessions" ID="ID_837932996" CREATED="1276848043910" MODIFIED="1276848052679"/>
<node TEXT="gerer accent et apostrophe" ID="ID_1526920378" CREATED="1276848969898" MODIFIED="1276862911671">
<richcontent TYPE="NOTE">
<html>
  <head>
    
  </head>
  <body>
    <p>
      fait
    </p>
  </body>
</html>
</richcontent>
</node>
</node>
</node>
</map>
