<?php

	/****************************************************************************************************************
	*	Cette classe a été téléchargé légalement pour être utilisée dans le projet.									*
	*	C'est une classe technique qui s'occuppe de la connexion et des requêtes liées à la base de données MySQL	*
	*	Des commentaires ont été ajoutés pour plus de compréhension.												*
	****************************************************************************************************************/
	
class Mysql
{
	// Attributs privés
    private $sql_serveur; 	// serveur
    private $sql_user;		// utilisateur
    private $sql_passe;		// mot de passe
    private $sql_bdd;		// base de données sur laquelle l'objet travaille
    private $connexion_sql;	// identifiant de la connexion MySQL
    private $base;			// base reconnue (booleen)
    private $requete;		// tableau de résultat de requêtes, permet d'avoir plusieurs requêtes au sein d'un même objet
    //private $result;

	// Constructeur
    public function __construct($serveur, $utilisateur, $mdp, $bdd)
    {
        $this->sql_serveur=$serveur;
        $this->sql_user=$utilisateur;
        $this->sql_passe=$mdp;
        $this->requete=array();
        $this->sql_bdd=$bdd;
        $this->connexion_sql=NULL;
    }
	
	// Connexion à la base
    public function connect($db)
    {
        if($db)
        {
            $this->sql_bdd=$db;
        }

        if (!$this->connexion_sql=mysql_connect($this->sql_serveur,$this->sql_user,$this->sql_passe) OR !$this->base=mysql_selectdb($this->sql_bdd))
        {
            // $this->erreur('Connexion impossible à la base de données (ou sélection impossible). Appuyez sur la touche F5 de votre clavier et contactez-moi SVP.');
        }

    }
	
	// Méthode pour éxécuter la requête entrée en paramètre ($i correspondant à l'indice dans le tableau)
    public function requete($requete,$i)
    {
        if(!$this->requete[$i]=@mysql_query($requete))
        {
            $this->erreur('Impossible d\'effectuer la requête '.$i.' .');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
	
	// Récupérer la ligne de la requête se trouvant à l'indice $i dans le tableau de résultat de requêtes.
    public function fetch_row($i)
    {
        return @mysql_fetch_row($this->requete[$i]);
    }
	
	// Récupérer le nombre de lignes de la requête se trouvant à l'indice $i dans le tableau de résultat de requêtes.
    public function nbre_lignes($i)
    {
        return @mysql_num_rows($this->requete[$i]);
    }
	
	// Déconnexion
    public function deconnect()
    {
        $this->connexion_sql=@mysql_close($this->connexion_sql);
    }
	
	// Afficher l'erreur.
    private function erreur($erreur)
    {
        echo '<p>Erreur : ',$erreur,'</p>';
    }
}
?> 
