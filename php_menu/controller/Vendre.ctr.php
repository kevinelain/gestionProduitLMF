<?php
/**
 * fichier de déclaration de la class controller Vendre
 */
	/**
	 * class de gestion des ventes
	 *
	 * charger d'appeller les methodes adaptée suivant la demande de l'utilisateur
	 */
class Vendre
{
		/** @var OdbVelo model de gestion Velo en Bdd */
	// private $odbVelo;
		/**
		 * constructeur de la class
		 *
		 * Verifie les droit avant de lancer un switch,
		 * les sous controlleur serons alors instancié
		 */
	public function __construct()
	{
			/**
			 * On regarde si le user est connecte,
			 * si non, on lui affiche le formulaire de connexion,
			 * et on termine le script
			 */
		if ( !$_SESSION['user']->estUser() ) {
			$_SESSION['user']->displayForm();
			die;
		}

			// si il est connecte
			// on instancie les model (lien avec la BDD)
		// $this->odbVelo = new OdbVelo();

			// le titre de la page par defaut (html <title>)
		$_SESSION['tampon']['html']['title'] = 'Vendre';
			// le menu actuel dans la list des menu
		$_SESSION['tampon']['menu'][0]['current'] = 'Vendre';

			// on evite les erreurs en cas de pas d'action
		if (empty($_GET['action']))
			$_GET['action'] = null;

			/**
			 * Switch de gestion des actions de Intervention
			 * se charge d'appeller la methode pour l'action requise
			 *
			 * @param string $_GET['action'] contient l'action demmandee
			 */
		switch ($_GET['action']) {

			default:
				$this->afficherForm();
				break;
		}
	}

		/**
		 * affiche le formulaire d'ajout
		 *
		 * @return void inclus juste les vues
		 */
	protected function afficherForm()
	{
		$lesVelos = null;

			/** si valeur, on lance l'enregistrement */
		if(!empty($_POST))
			$lesVelos = $this->_enregistrer();

				/**
				 * Load des vues
				 */
			view('htmlHeader');
			view('contentMenu');
			view('contentVendre');
			view('htmlFooter');
	}

		/**
		 * affiche un velo
		 * @return void
		 */
	protected function _enregistrer()
	{
			// si on a bien a faire a une station valide
		if (
				!empty($_POST['sbm'])
			)
		{
			$unVelo = $this->odbVelo->getUnVelo($_GET['valeur']);

			$_SESSION['tampon']['html']['title'] = 'V&eacute;lo - '.$unVelo->Vel_Num;
			$_SESSION['tampon']['menu'][1]['current'] = 'Un v&eacute;lo';

			if (!empty($_SESSION['tampon']['success']))
				view('contentSuccess');

		}
	}
}
