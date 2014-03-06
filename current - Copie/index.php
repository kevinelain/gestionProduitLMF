<?php
/**
 * Fichier index, déclare la classe et l'instancie
 *
 * Ce fichier montre comment vous devez mettre en place la class,
 * attention a l'ordre des trois lignes.
 */

//////////////////////////////////
// chargement et initialisation //
//////////////////////////////////
// fonctions pour auto-charger les Class.ctr et les OdbClass.mdl
function load_controller($class)
{
	if(is_file('controller/'.$class .'.ctr.php'))
		require_once('controller/'.$class .'.ctr.php');
}
function load_model($class)
{
	if(is_file('model/'.$class .'.mdl.php'))
		require_once('model/'.$class .'.mdl.php');
}
spl_autoload_register('load_controller');
spl_autoload_register('load_model');



	/** on charge la class de gestion de la BDD */
require_once ('toolSql/Bdd.class.php');
	/** on charge la class de gestion de la BDD en fichier (gestion du 'se souvenir de moi') */
require_once ('toolNosql/Nosql.class.php');

	/** on lance la session qui contiendra la connexion */
session_start();

	/** on cree l'objet de connexion SQL dans $_SESSION['bdd'] */
require_once 'inc/connexion.inc.php';

	// fonction pour afficher les template
require_once 'inc/template.inc.php';

	/** la class de gestion des menus */
require_once ('toolMenu/Menu.class.php');

/**
 * contient un objet utilisateur et ses droits
 * on passe true pour signaler que on est en private :
 * seul le script fait les appels
 *
 * @global User $_SESSION['user']
 */
if(empty($_SESSION['user']))
	$_SESSION['user'] = new User(true);

	// on declare le titre de la page par defaut (html <title>)
$_SESSION['tampon']['html']['title'] = 'Gestion de Produit LMF';
	// on charge les menus de premier niveau dans la class de gestion des menu
$_SESSION['tampon']['menu'][0]['list'] =
	array(
			'Produit'  => 'index.php?page=produit',
			'Fournisseur'   => 'index.php?page=fournisseur',
		);
	// on invoque la class de gestion des menus
	// et on lui donne la variable qui contiendra les differents
	// niveau des menus
$_SESSION['menu'] = new Menu($_SESSION['tampon']['menu']);


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
	case 'fournisseur':
		new Fournisseur();
		break;

	case 'produit':

	default:
		new Produit();
		break;
}

///////////////////////
// on vide le tampon //
///////////////////////
	// on supprime toutes les donnees temporaire utiliser dans la page
$_SESSION['tampon'] = null;

