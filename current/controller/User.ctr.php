<?php
/**
 * gestion des utilisateurs et de leurs droit d'accee
 */
class User
{
	private $id;
	private $name;

		/** @var odbUser model de gestion Bdd */
	private $odbUser;

	public function __construct($private = false)
	{
			/**
			 * On regarde si le user est connecte,
			 * si non, on lui affiche le formulaire de coo,
			 * et on termine le script
			 */
		if (!$private and !($_SESSION['user']->estUser())) {
			$_SESSION['user']->displayForm();
			die;
		}

		// si il est connecte
		// on instancie les model (lien avec la BDD)
		$this->odbUser = new OdbUser();

		// // page actuelle
		// $_SESSION['tampon']['menu']['title'] = 'Utilisateur';
		// $_SESSION['tampon']['menu']['url'] = 'index.php?page=user&amp;action=adduser';
		// // liste des sous menus
		// $_SESSION['tampon']['sous_menu']['list'] =
		// 	array(
		// 			array('url'=>'index.php?page=user&amp;action=adduser',
		// 				'title'=>'Ajouter Utilisateur'),
		// 			array('url'=>'index.php?page=user&amp;action=unuser',
		// 				'title'=>'Un Utilisateur'),
		// 			array('url'=>'index.php?page=user&amp;action=rechercheruser' ,
		// 				'title'=>'Rechercher utilisateur'),
		// 		);

		// if (empty($_GET['action']))
		// 	$_GET['action'] = null;

		// /**
		//  * Switch de gestion des actions de User
		//  *
		//  * @param string $_GET['action'] contient l'action demmandee
		//  */
		// switch ($_GET['action']) {
		// 	case 'rechercheruser':
		// 		$this->rechercherUneUtilisateur();
		// 		break;
		// 	case 'unuser':
		// 		$this->afficherUnUtilisateur();
		// 		break;

		// 	case 'adduser':

		// 	default:
		// 		$this->afficherLesStations();
		// 		break;
		// }
	}

	public function __sleep()
	{
		return array('id', 'name');
	}

	public function __wakeup()
	{
		$this->odbUser = new OdbUser();
	}

	////////////////////////////////
	// Methodes public du compte  //
	////////////////////////////////

		/**
		 * check si est un user
		 * @return bool true si on peut le connecter
		 */
	public function estUser()
	{
		if(!empty($_GET['page']) and $_GET['page'] == 'logout')
			$this->logout();

		if(!empty($this->id))
			return true;
		elseif ($this->login())
			return true;

		return false;
	}
		/**
		 * affiche le formulaire de login
		 * @return [type] [description]
		 */
	public function displayForm()
	{
		view('htmlHeader');
		if(!empty($_SESSION['tampon']['error']))
			view('contentError');
		view('contentLogin');
		view('htmlFooter');
	}
	

	/////////////////////////////////////////////
	// Methodes public de gestion des comptes  //
	/////////////////////////////////////////////

		/**
		 * @todo a faire
		 * @return [type] [description]
		 */
	public function rechercherUnUtilisateur()
	{
		// TODO
		return false;
	}
	public function afficherUnUtilisateur()
	{
		// TODO
		return false;
	}
	public function afficherLesUtilissateurs()
	{
		// TODO
		return false;
	}

	//////////////////////
	// Methodes privee //
	//////////////////////

		/**
		 * va verifier si le mdp/id passe est bien prensent en bdd
		 *
		 * hash est une metode pour obtenir une emprunte unique
		 * ca nous evite de garder en clair les mdp, comme ca en
		 * cas de piratage, les mdp ne sont pas retrouvable simplement
		 *
		 * @return bool vrai si compte existe avec ce mdp/id, false sinon
		 */
	private function login()
	{
			// si on envois un name et un mdp, alors on va faire les verif en bdd
		if(!empty($_POST['name']) and isset($_POST['mdp']))
		{
			if($this->odbUser->checkHashUser($_POST['name'],
				hash('sha512',
					$_POST['name'].$_POST['mdp'].$_POST['name'])))
			{
				$user = $this->odbUser->getUser($_POST['name']);

				$this->id = $user->Use_Num;
				$this->name = $user->Use_Nom;

				if(!empty($_POST['remember_me']))
				{
						/** @var string un jeton qui servira de mot de passe (seed)*/
					$seed = bin2hex(openssl_random_pseudo_bytes(256));
						/** @var string le token cree avec la seed et le pseudo */
					$token = hash('sha512', $_POST['name'].$seed.$_POST['name']);

					if($this->odbUser->saveToken($_POST['name'], $token))
					{
							// un cookie qui contient le name pour 3 mois
						setcookie('name', $_POST['name'], time()+7776000);
							// un cookie qui contient la seed pour 3 mois
						setcookie('remember_me', $seed, time()+7776000);
					}
				}
				header('Location:'.$_SERVER['PHP_SELF']);
				return true;
			}
			elseif ($this->odbUser->estUser($_POST['name']))
				$_SESSION['tampon']['error'][] = 'Erreur sur le mot de passe.';
			else
				$_SESSION['tampon']['error'][] = 'Erreur sur l\'identifiant.';
		}
			/** Si on a un cookie pour se souvenir de l'utilisateur */
		elseif(!empty($_COOKIE['remember_me']) and isset($_COOKIE['name']))
		{
			$hash = hash('sha512', $_COOKIE['name'].$_COOKIE['remember_me'].$_COOKIE['name']);

			if($trueHash = $this->odbUser->getToken($_COOKIE['name']))
				if(strcmp($hash, $trueHash) === 0)
					return true;
		}

		return false;
	}

		/**
		 * permet au user de se deconnecter
		 * @return void
		 */
	private function logout()
	{
			/** on detruit le cookie */
		if(isset($_COOKIE['remember_me']))
			setcookie('remember_me', '', time()-1);
			/** on supprime le ficher de stockage du token */
		if(isset($_COOKIE['name'])){
			$this->odbUser->forgetToken($_COOKIE['name']);
			setcookie('name', '', time()-1);
		}

		$this->id = null;
		$this->name = null;
	}
}
