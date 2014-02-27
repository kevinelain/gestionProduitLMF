<?php
/**
 * fichier de declaration de la class Menu
 */
	/**
	 * class de gestion de menu multis-niveaux
	 *
	 * @author Benoit <benoitelie1@gmail.com>
	 */
class Menu
{
		/** @var array pointeur avec le contenu du menu */
	private $menu;

	////////////////////
	// CONSTRUCTEUR  //
	////////////////////

		/**
		 * construit le menus avec un pointeur vers les nom/url
		 *
		 * @param array $menu contient par référence un array des menus
		 */
	public function __construct( &$menu)
	{
			// save des variable si on en passe au constructeur
		if(!empty($menu))
			$this->menu = &$menu;
	}

		/**
		 * variable a sauver a la fin du chargement de page
		 *
		 * @return array
		 */
	public function __sleep()
	{
		return array();
	}


	//////////////
	// PRIVATE //
	//////////////


	/////////////
	// PUBLIC //
	/////////////

		/**
		 * retourne la liste des menus pour le niveau demandé
		 *
		 * @param  integer $level le niveau de menu demandé [0-x]
		 * @return array         le tableau des menus du niveau
		 */
	public function getListMenu($level=0)
	{
		if(isset($this->menu[$level]['list']) and is_array($this->menu[$level]['list']))
			return $this->menu[$level]['list'];
		else
			return array();
	}
		/**
		 * retourne l'url/nom du menu actuel pour le niveau demandé
		 * @param  integer $level le niveau de menu demandé [0-x]
		 * @return array         tableau avec 'url' et 'title' du menu
		 */
	public function getCurrentMenu($level=0)
	{
		if(isset($this->menu[$level]['current'])
			and is_array($this->menu[$level]['list'])
			and array_key_exists($this->menu[$level]['current'], $this->menu[$level]['list'])
			)
		{
			return array(
				'url' => $this->menu[$level]['list'][ $this->menu[$level]['current'] ],
				'title' => $this->menu[$level]['current'],
				);
		}
		else
			return array('url' => '','title' => '');
	}
		/**
		 * test si pour le niveau demandé le title est le menu actuel
		 * @param  integer $level niveau du menu a tester
		 * @param  string  $title titre du menu a tester
		 * @return boolean        true si le menu passé est le menus actuel
		 */
	public function isCurrentMenu($level=0, $title=null)
	{
		if(
			$title != null
			and isset($this->menu[$level]['current'])
			and $this->menu[$level]['current'] == $title
			)
			return true;
		else
			return false;
	}


}
