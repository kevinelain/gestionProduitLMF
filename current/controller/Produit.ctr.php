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
		$this->odbProduit = new OdbProduit();
		$this->odbFournisseur = new OdbFournisseur();

			// le titre de la page par defaut (html <title>)
		$_SESSION['tampon']['html']['title'] = 'Tous les produits';
			// le menu actuel dans la list des menu
		$_SESSION['tampon']['menu'][0]['current'] = 'Produit';

			//les sous menu
		//$_SESSION['tampon']['menu'][1]['current'] = 'Afficher les produits';
		
		//$_SESSION['tampon']['menu'][1]['current'] = 'trhjtj';

			//test
		$_SESSION['tampon']['menu'][1]['list'] = 
			array('Afficher tous les produits'=>'index.php?page=produit&amp;action=lesproduits',
				  'Ajouter un produit'=>'index.php?page=produit&amp;action=ajouterunproduit',
				  'Rechercher un produit'=>'index.php?page=produit&amp;action=rechercherunproduit',
				  'Un produit'=>'index.php?page=produit&amp;action=unproduit',
				  'Modifier un produit'=>'index.php?page=produit&amp;action=modifierunproduit',
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
			case 'unproduit':
				$this->afficherUnProduit();
				break;

			case 'ajouterunproduit':
				$this->ajouterUnProduit();
				break;

			case 'modifierunproduit':
				$this->modifierUnProduit();
				break;

			case 'rechercherunproduit':
				$this->rechercherUnProduit();
				break;

			case 'supprimerunproduit':
				$this->supprimerUnProduit();
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

		$_SESSION['tampon']['html']['title'] = 'Tous les produits';  //ce qui s'affiche dans le title html lorsqu'on clique sur "Tous les produits"
		$_SESSION['tampon']['title'] = 'Tous les produits';

		$_SESSION['tampon']['menu'][1]['current'] = 'Afficher tous les produits';
		//$_SESSION['tampon']['menu'][1]['url'] = 'index.php?page=produit&amp;action=lesproduits';

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

	protected function afficherUnProduit()
	{
			// si on a bien a faire a un produit valide
		if (
				!empty($_GET['valeur'])
				and $this->odbProduit->estType($_GET['valeur']))
		{
			$unProduit = $this->odbProduit->getUnProduit($_GET['valeur']);

			$_SESSION['tampon']['html']['title'] = $unProduit->PRO_NOM;

			$_SESSION['tampon']['menu'][1]['current'] = 'Un produit';

			/**
			 * Load des vues
			 */
			view('htmlHeader');
			view('contentMenu');
			view('contentOneProduit', array('unProduit'=>$unProduit));
			view('htmlFooter');
		}
		elseif(!empty($_GET['valeur']))
		{
			$_SESSION['tampon']['html']['title'] = 'Produit - ERREUR';
			$_SESSION['tampon']['menu'][1]['current'] = 'Un produit';
			$_SESSION['tampon']['error'][] = 'Le produit ne semble pas exister...';

				/**
				 * Load des vues
				 */
			view('htmlHeader');
			view('contentMenu');
			view('contentError');
			view('htmlFooter');
		}
		else
			$this->rechercherUnProduit();
	}

	protected function ajouterUnProduit()
	{
		/**
		 * si l'envoi est effectué depuis la page d'ajout produit, on enregistre le produit dans la BDD
		 */
		if(isset($_POST['sbmtMkProduit']))
		{
			$unNouveauProduit = $this->odbProduit->creerUnProduit();

			//si tout ok alors
			if ($unNouveauProduit)
			{
				$_SESSION['tampon']['success'][] =
					'Enregistrement du nouveau produit r&eacute;ussi';
					// on redirige vers la page d'affiche des produits
				header('Location:index.php?page=produit&action=lesproduits');
				die; // on stop le chargement de la page
			}
			else // sinon on charge une erreur
				$_SESSION['tampon']['error'][] = 'Erreur durant l&apos;enregistrement du nouveau produit';

		}

		$lesProduits = $this->odbProduit->getLesProduits();
		$lesFournisseurs = $this->odbFournisseur->getLesFournisseurs();

		$_SESSION['tampon']['html']['title'] = 'Ajouter un produit';
		$_SESSION['tampon']['title'] = 'Ajouter un produit';

		$_SESSION['tampon']['menu'][1]['current'] = 'Ajouter un produit';
		//$_SESSION['tampon']['menu'][1]['url'] = 'index.php?page=produit&amp;action=ajouterunproduit';

		/**
		 * load des vues
		 */
		view('htmlHeader');
		view('contentMenu');
		view('creerProduit', array(
			'lesProduits'=>$lesProduits,
			'lesFournisseurs'=>$lesFournisseurs,
			));
		view('htmlFooter');

	}

	protected function rechercherUnProduit()
	{
		if(isset($_GET['valeur']) and $_GET['valeur'] !== '')
			$lesProduits = $this->odbProduit->searchProduits($_GET['valeur']);
		else
			$lesProduits = $this->odbProduit->getLesProduits();

		$_SESSION['tampon']['html']['title'] = 'Rechercher un produit';
		$_SESSION['tampon']['title'] = 'Rechercher un produit';

		$_SESSION['tampon']['menu'][1]['current'] = 'Rechercher un produit';

		if (empty($lesProduits))
			$_SESSION['tampon']['error'][] = 'Pas de produit...';

			/**
			 * Load des vues
			 */
		view('htmlHeader');
		view('contentMenu');
		view('contentSearchProduit');
		view('contentAllProduits', array('lesProduits'=>$lesProduits));
		view('htmlFooter');
	}

	protected function modifierUnProduit()
	{

			/**
			 * Si le produit existe, on peut lancer le module
			 * sinon on passe directement a une erreur
			 */
		if(
			isset($_GET['valeur'])
			and $this->odbProduit->estType($_GET['valeur'])
			)
		{
				/** @var array stock les erreurs de la modification du produit */
			$has_error = array();

				/**
				 * Si on a un envois de fomulaire sur la demande de modification de produit
				 */
			if (!empty($_POST))
			{
					// on lance la modif
				$outModifProduit = $this->odbProduit->modifierUnProduit();
					/** si on a un nombre de ligne >0 et donc TRUE */
				if ($outModifProduit)
				{
					$_SESSION['tampon']['success'][] =
						'Modification du produit No '.$_GET['valeur'].' r&eacute;ussie !';
						// on redirige vers la page d'affiche d'un produit
					header('Location:index.php?page=produit&action=unproduit&valeur='.$_GET['valeur']);
					die; // on stop le chargement de la page
				}
				else // sinon on charge une erreur
					$_SESSION['tampon']['error'][] = 'Erreur avec la modification du produit No '.$_GET['valeur'];
			
			}

				/**
				 * partie principal de la modif produit, on va chercher les infos du produit
				 */

			$leProduit = $this->odbProduit->getUnProduit($_GET['valeur']);
			$lesFournisseurs = $this->odbFournisseur->getLesFournisseurs();


			$_SESSION['tampon']['html']['title'] = 'Modifier un produit';
			$_SESSION['tampon']['menu'][1]['current'] = 'Modifier un produit';

				/** en cas de retour vide sur une des valeurs */
			if (empty($lesFournisseurs))
				$_SESSION['tampon']['error'][] = 'Aucun fournisseur dans la base !';

				/**
				 * Load des vues
				 */
			view('htmlHeader');
			view('contentMenu');
			view('contentModifierUnProduit', array(
					'lesFournisseurs'=>$lesFournisseurs,
					'leProduit'=>$leProduit,
					));
			view('htmlFooter');
		}
		else //si pas de produit préséléctionnés mais clique direct dans menu, alors on affiche simplement tous les produits
		{

			$lesProduits = $this->odbProduit->getLesProduits();

			$_SESSION['tampon']['html']['title'] = 'Tous les produits';
			$_SESSION['tampon']['title'] = 'Tous les produits';

			$_SESSION['tampon']['menu'][1]['current'] = 'Afficher tous les produits';

			if (empty($lesProduits))
				$_SESSION['tampon']['error'][] = 'Pas de produits';
				/**
				 * Load des vues
				 */
			view('htmlHeader');
			view('contentMenu');
			view('contentAllProduits', array('lesProduits'=>$lesProduits));
			view('htmlFooter');
		}
	}

	protected function supprimerUnProduit()
	{

		/**
			 * Si le produit existe, on peut lancer le module
			 * sinon on passe directement a une erreur
			 */
		if(
			isset($_GET['valeur'])
			and $this->odbProduit->estType($_GET['valeur'])
			)
		{

			echo "eoifzioefoiejf";
				// on lance la modif
			$outSupprimerProduit = $this->odbProduit->supprimerUnProduit($_GET['valeur']);
				/** si on a un nombre de ligne >0 et donc TRUE */
			if ($outSupprimerProduit)
			{
				$_SESSION['tampon']['success'][] =
					'Suppression du produit r&eacute;ussie !';
					// on redirige vers la page de tous les produits
				header('Location:index.php?page=produit&action=lesproduits');
				die; // on stop le chargement de la page
			}
			else // sinon on charge une erreur
				$_SESSION['tampon']['error'][] = 'Erreur avec la modification du produit';

		}
		else
		{

			$_SESSION['tampon']['html']['title'] = 'Supprimer produit - ERREUR';
			$_SESSION['tampon']['sous_menu']['curent']['url'] = 'index.php?page=produit&amp;action=supprimerunproduit';
			$_SESSION['tampon']['sous_menu']['curent']['title'] = 'Supprimer un produit';

			$_SESSION['tampon']['error'][] = 'Le produit ne semble pas exister...';

				/**
				 * Load des vues
				 */
			view('htmlHeader');
			view('contentMenu');
			view('contentError');
			view('htmlFooter');
		}


	}

}
