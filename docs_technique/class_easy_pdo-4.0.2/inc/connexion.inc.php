<?php
	/**
	 * instanciation de la connexion BDD dans une variable de session
	 *
	 * @todo  /!\ changez ici par vos informations de connexion /!\
	 *
	 * Par defaut, si null ou false dans le "Bdd()" :
	 * 		$host       = 'localhost';
	 * 		$db_name    = 'test';
	 * 		$user       = 'root';
	 * 		$mdp        = '';
	 * 		$production = false;
	 *
	 * @param string $host l'host a utiliser (localhost par defaut)
	 * @param string $db_name nom de la base de donnee
	 * @param string $user utilisateur de la BDD
	 * @param string $mdp mot de passe de l'utilisateur
	 * @param bool $production (des)active les messages d'erreurs
	 */

if (empty($_SESSION['bdd']))
	$_SESSION['bdd'] = new Bdd(null, null, 'root', '', false);