<?php
/**
 * fichier de déclaration de la class controller Fournisseur
 */
	/**
	 * class de gestion des fournisseurs
	 *
	 * charger d'appeller les methodes adaptée suivant la demande de l'utilisateur
	 */
class Fournisseur
{
		/** @var OdbFournisseur model de gestion Fournisseur en Bdd */
	private $odbFournisseur;
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
		$this->odbFournisseur = new OdbFournisseur();

			// le titre de la page par defaut (html <title>)
		$_SESSION['tampon']['html']['title'] = 'Fournisseur';
			// le menu actuel dans la list des menu
		$_SESSION['tampon']['menu'][0]['current'] = 'Fournisseur';

			//les sous menu
		$_SESSION['tampon']['menu'][1]['current'] = 'Afficher les fournisseurs';


			// on evite les erreurs en cas de non action
		if (empty($_GET['action']))
			$_GET['action'] = null;

			/**
			 * Switch de gestion des actions de Intervention
			 * se charge d'appeller la methode pour l'action requise
			 *
			 * @param string $_GET['action'] contient l'action demmandee
			 */
		switch ($_GET['action']) {
			case 'unfournisseur':
				$this->afficherUnFournisseur();
				break;

			case 'lesfournisseurs';

			default:
				$this->afficherLesFournisseurs();
				break;
		}

	}

	/**
	 * affiche tous les fournisseurs
	 * @return void 
	 */
	protected function afficherLesFournisseurs()
	{
		$lesFournisseurs = $this->odbFournisseur->getLesFournisseurs();

		$_SESSION['tampon']['html']['title'] = 'Tous les fournisseurs';
		$_SESSION['tampon']['menu'][1]['curent'] = 'Les fournisseurs';

		if (empty($lesFournisseurs))
			$_SESSION['tampon']['error'][] = 'Pas de fournisseurs';


		/**
		 * load des vues
		 */

		view('htmlHeader');
		view('contentMenu');
		view('contentAllFournisseurs', array('lesFournisseurs'=>$lesFournisseurs));
		view('htmlFooter');
	}

}
