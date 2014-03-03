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
		$_SESSION['tampon']['menu'][1]['list'] =
			array('Afficher tous les fournisseurs'=>'index.php?page=fournisseur&amp;action=lesfournisseurs',
				  'Ajouter un fournisseur'=>'index.php?page=fournisseur&amp;action=ajouterunfournisseur',
				  );


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

			case 'ajouterunfournisseur':
				$this->ajouterUnFournisseur();
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
		$_SESSION['tampon']['title'] = 'Tous les fournisseurs';

		$_SESSION['tampon']['menu'][1]['current'] = 'Afficher tous les fournisseurs';

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

	protected function ajouterUnFournisseur()
	{
		/**
		 * si l'envoi est effectué depuis la page d'ajout fournisseur, on enregistre le fournisseur dans la BDD
		 */
		if(isset($_POST['sbmtMkFournisseur']))
		{
			$unNouveauFournisseur = $this->odbFournisseur->creerUnFournisseur();

			//si tout ok alors
			if ($unNouveauFournisseur)
			{
				$_SESSION['tampon']['success'][] =
					'Enregistrement du nouveau fournisseur r&eacute;ussi';
					// on redirige vers la page d'affiche des fournisseurs
				header('Location:index.php?page=fournisseur&action=lesfournisseurs');
				die; // on stop le chargement de la page
			}
			else // sinon on charge une erreur
				$_SESSION['tampon']['error'][] = 'Erreur durant l&apos;enregistrement du nouveau fournisseur';

		}

		$lesFournisseurs = $this->odbFournisseur->getLesFournisseurs();

		$_SESSION['tampon']['html']['title'] = 'Ajouter un fournisseur';
		$_SESSION['tampon']['title'] = 'Ajouter un fournisseur';

		$_SESSION['tampon']['menu'][1]['current'] = 'Ajouter un fournisseur';
		//$_SESSION['tampon']['menu'][1]['url'] = 'index.php?page=fournisseur&amp;action=ajouterunproduit';

		/**
		 * load des vues
		 */
		view('htmlHeader');
		view('contentMenu');
		view('creerFournisseur', array(
			'lesFournisseurs'=>$lesFournisseurs,
			));
		view('htmlFooter');

	}

}
