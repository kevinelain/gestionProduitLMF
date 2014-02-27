<?php
/**
 * fichier d'index général
 *
 * il initialise les différentes parties
 * et instancie le module demandé
 */

//////////////////////////////////
// chargement et initialisation //
//////////////////////////////////

	/**
	 * fonctions pour auto-charger les Class.ctr (controller)
	 *
	 * En cas d'appelle a une class, cette fonction va chercher
	 * d'elle meme la declaration de la class
	 *
	 * @param  string $class nom de la class a charger
	 * @return void        inclusion de la class
	 */
function load_controller($class)
{
	if(is_file('controller/'.$class .'.ctr.php'))
		require_once('controller/'.$class .'.ctr.php');
}
	/**
	 * fonctions pour auto-charger les OdbClass.mdl (model)
	 *
	 * En cas d'appelle a une class, cette fonction va chercher
	 * d'elle meme la declaration de la class
	 *
	 * @param  string $class nom de la class a charger
	 * @return void        inclusion de la class
	 */
function load_model($class)
{
	if(is_file('model/'.$class .'.mdl.php'))
		require_once('model/'.$class .'.mdl.php');
}
/** on signale a php l'existance de la fonction d'autoload des controleur */
spl_autoload_register('load_controller');
/** on signale a php l'existance de la fonction d'autoload des model */
spl_autoload_register('load_model');

	/** on charge la class de gestion de la BDD MySql */
require_once ('toolSql/Bdd.class.php');
	/** on charge la class de gestion de la BDD en fichier (gestion du 'se souvenir de moi') */
require_once ('toolNosql/Nosql.class.php');

	/** la class de gestion des menus */
require_once ('toolMenu/Menu.class.php');

	/** class de gestion des droit des utilisateur */
require_once 'controller/User.ctr.php';
	// on lance la session
session_start();

	/** fonction pour afficher les template via 'view()' */
require_once 'inc/function.inc.php';

	/**
	 * instanciation des object de connexion
	 *
	 * - on cree l'objet de connexion SQL dans $_SESSION['bdd']
	 * - et celui de NoSql dans $_SESSION['nosql']
	 */
require_once 'inc/connexion.inc.php';

	// on declare le titre de la page par defaut (html <title>)
$_SESSION['tampon']['html']['title'] = 'Connectez-vous';
	// on charge les menus de premier niveau dans la class de gestion des menu
$_SESSION['tampon']['menu'][0]['list'] =
	array(
			'Vendre'  => 'index.php?page=vendre',
			'Stock'   => 'index.php?page=stock',
			'Gestion' => 'index.php?page=gestion',
		);
	// on invoque la class de gestion des menus
	// et on lui donne la variable qui contiendra les differents
	// niveau des menus
$_SESSION['menu'] = new Menu($_SESSION['tampon']['menu']);

	// si on a pas encore invoquer la class de gestion des droit
if(empty($_SESSION['user']))
	$_SESSION['user'] = new User(true);

//////////////////////////
// Fin d'initialisation //
//////////////////////////

///////////////////////////////////////////////
// Controleur prncipale de gestion des pages //
///////////////////////////////////////////////

// on evite les error de variable inexistante
if (!isset($_GET['page']))
	$_GET['page'] = null;

	/**
	 * switch principale
	 *
	 * doit gerer les URL demandee pour lancer une instance
	 * du controleur correspondent a la demande
	 *
	 * @param string $_GET['page'] contient la page demandee
	 * @return void realise juste l'instanciation
	 */
switch ($_GET['page']) {
	case 'gestion':
		new Gestion();
		break;

	case 'stock':
		new Stock();
		break;


	case 'vendre':

	default:
		new Vendre();
		break;
}

///////////////////////
// on vide le tampon //
///////////////////////
	// on supprime toutes les donnees temporaire utiliser dans la page
$_SESSION['tampon'] = null;
