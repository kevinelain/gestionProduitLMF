<?php
/**
 * fichier de déclaration de la class controller Produit
 */
	/**
	 * class de gestion des produits
	 *
	 * charger d'appeller les methodes adaptée suivant la demande de l'utilisateur
	 */
class Produit
{
		/** @var OdbProduit model de gestion Produit en Bdd */
	private $odbProduit;
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
		$this->odbProduit = new OdbProduit();

			// le titre de la page par defaut (html <title>)
		$_SESSION['tampon']['html']['title'] = 'Produit';
			// le menu actuel dans la list des menu
		$_SESSION['tampon']['menu'][0]['current'] = 'Produit';

			//les sous menu
		$_SESSION['tampon']['menu'][1]['current'] = 'Afficher les produits';


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
			case 'unproduit':
				$this->afficherUnProduit();
				break;

			case 'lesproduits';

			default:
				$this->afficherLesProduits();
				break;
		}

	}

	/**
	 * affiche tous les produits
	 * @return void 
	 */
	protected function afficherLesProduits()
	{
		$lesProduits = $this->odbProduit->getLesProduits();

		$_SESSION['tampon']['html']['title'] = 'Tous les produits';
		$_SESSION['tampon'][1]['curent'] = 'Les produits';

		if (empty($lesProduits))
			$_SESSION['tampon']['error'][] = 'Pas de produits';


		/**
		 * load des vues
		 */

		view('htmlHeader');
		view('contentMenu');
		view('contentAllProduits', array('lesProduits'=>$lesProduits));
		view('htmlFooter');
	}

}
