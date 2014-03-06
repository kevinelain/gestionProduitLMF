<?php
	/**
	 * class de gestion de donnees en fichier
	 *
	 * Class pour une gestion simplifier de petite BDD noSql
	 * les terme son analogique mais traite
	 * - de dossiers (table)
	 * - et fichiers (entree)
	 *
	 * les entrees sont basee sur le model clef-valeur
	 * avec une contrainte d'unicitee sur la clef
	 * toutes les clefs sont stockee en base64
	 *
	 * @todo  Pensez a changer le CHMOD
	 *
	 * @method insert($table, $name, $data)
	 * @method query($table, $name[, $get_value])
	 * @method select_all($table[, $get_value])
	 * @method delete($table, $name)
	 * @method last_query()
	 * @method is_table($table)
	 * @method create($table)
	 * @method get_table($table)
	 * @method drop($table)
	 *
	 * @global boolean NO_RESULT
	 * @global boolean NO_ERASE
	 * @author Benoit <benoitelie1@gmail.com>
	 */
class Nosql
{

	private $last_query;
	private $path_db;
		/** @var integer le CHMOD des fichiers */
	private $chmod_file = 0666;
		/** @var integer le CHMOD des dossiers */
	private $chmod_dir = 0777;

		/**
		 * constante pour NE PAS chercher la valeur
		 *
		 * Si vous l'utilisez, les methodes query()
		 * et select_all() vous ne vous retournerons
		 * que l'existance de l'entree, via un boolean.
		 *
		 * utilisez en dernier param de query/select_all "Nosql::NO_RESULT"
		 * la methode vous retourneras directement un bool
		 */
	const NO_RESULT = false;

		/**
		 * constante pour NE PAS ecraser les fichier
		 *
		 * Lors d'un Insert(), par defaut si le fichier existe,
		 * les donnees contenue serons perdue et remplace par $data
		 *
		 * utilisez en dernier param de insert "Nosql::NO_ERASE"
		 * la methode ajoutera les donnees a la fin du fichier
		 */
	const NO_ERASE = true;

	///////////////////
	// CONSTRUCTEUR //
	///////////////////

		/**
		 * instancie l'objet de connexion
		 * le path est le dossier racine des tables
		 *
		 * @param string $path
		 */
	public function __construct($path = 'nosql_db')
	{
		$this->last_query = false;
		$this->path_db = $path;
	}

	//////////////
	// REQUETE //
	//////////////

		/**
		 * insertion d'une key/value dans une table
		 *
		 * Par defaut si le fichier existe,
		 * les donnees contenue serons perdue et remplace par $data
		 *
		 * utilisez en dernier param la constante "Nosql::NO_ERASE" (ou TRUE)
		 * la methode ajoutera les donnees a la fin du fichier
		 *
		 * @param  string $table
		 * @param  string $key
		 * @param  string $data
		 * @param  boolean $no_erase
		 * @return int
		 */
	public function insert($table = null, $key = null , $data = null, $no_erase = false)
	{
		if($table != null and $this->is_table($table) and $data !== null and $key != null){
			if($no_erase)
				$ressource = @fopen($this->path_db.'/'.$table.'/'.base64_encode($key), 'a');
			else
				$ressource = @fopen($this->path_db.'/'.$table.'/'.base64_encode($key), 'w');

			if(!$ressource)
				die('ERROR : Le script ne peut ecrire le fichier "'.$this->path_db.'/'.$table.'/'.base64_encode($key).'"');

			$output = fwrite($ressource, $data);
			fclose($ressource);
			chmod($this->path_db.'/'.$table.'/'.base64_encode($key) , $this->chmod_file);

			return $output;
		}

		return false;
	}

		/**
		 * recherche by key dans une table
		 *
		 * Les valeurs ne sont pas renvoye si get_value a false
		 *
		 * @param  string  $table
		 * @param  string  $key
		 * @param  boolean $get_value
		 * @return string
		 */
	public function query($table = null, $key = null, $get_value = true)
	{
		if($table != null and $key != null and $this->is_table($table)){
			if(file_exists($this->path_db.'/'.$table.'/'.base64_encode($key))){
				if($get_value)
					return $this->last_query = file_get_contents($this->path_db.'/'.$table.'/'.base64_encode($key));
				else
					return true;
			}
		}

		return false;
	}

		/**
		 * recherche toutes les key dans une table
		 *
		 * Les valeurs ne sont pas renvoye si get_value a false
		 *
		 * @param  string  $table
		 * @param  boolean $get_value
		 * @return array
		 */
	public function select_all($table = null, $get_value = true)
	{
		$output = false;
		if($table != null and $this->is_table($table)){
			if($dir = opendir($this->path_db.'/'.$table)){
				while($file = readdir($dir)){
					if($file != '.' and $file != '..' and is_file($this->path_db.'/'.$table.'/'.$file)){
						if($get_value)
							$output[base64_decode($file)] = file_get_contents($this->path_db.'/'.$table.'/'.$file);
						else
							$output[base64_decode($file)] = true;
					}
				}
			}
		}

		return $output;
	}

		/**
		 * suppression d'une entree by key
		 *
		 * @param  string $table
		 * @param  string $key
		 * @return boolean
		 */
	public function delete($table=null, $key=null)
	{
		if($table !=null and $this->is_table($table)){
			if($key != null and file_exists($this->path_db.'/'.$table.'/'.base64_encode($key))){
				if(unlink($this->path_db.'/'.$table.'/'.base64_encode($key))){
					clearstatcache();

					return true;
				}
			}
		}

		return false;
	}

		/**
		 * derniere value retournee par query ou FALSE
		 *
		 * @return string
		 */
	public function last_query()
	{
		return $this->last_query;
	}

	////////////
	// TABLE //
	////////////

		/**
		 * verifie si on a bien a faire a une table
		 *
		 * @param  string  $table nom de la table
		 * @return boolean        true si table, false sinon
		 */
	public function is_table($table = null)
	{
		if($table != null)
			return is_dir($this->path_db.'/'.$table);
	}

		/**
		 * creer la table avec recursivite
		 *
		 * @param  string $table nom de la table
		 * @return bool        resultat de l'action
		 */
	public function create($table = null)
	{
		$output = false;

		if($table != null and !($this->is_table($table)) and !preg_match('#[^A-Za-z0-9/_]#', $table)){
			$output = mkdir($this->path_db.'/'.$table, $this->chmod_dir, true);
			chmod($this->path_db.'/'.$table , $this->chmod_dir);
		}

		return $output;
	}

		/**
		 * recherche toutes les sous-tables
		 *
		 * @param  string $table nom de la table
		 * @return array        tableau des tables
		 */
	public function get_table($table = null)
	{
		$output = false;

		if($table != null and $this->is_table($table)){
			if($dir = opendir($this->path_db.'/'.$table)){
				while($file = readdir($dir)){
					if($file != '.' and $file != '..' and is_dir($this->path_db.'/'.$table.'/'.$file))
						$output[] = $file;
				}
			}
		}

		return $output;
	}

		/**
		 * vide la table et la suprime
		 *
		 * @param  string $table nom de la table
		 * @return bool        resultat de l'action
		 */
	public function drop($table = null)
	{
		if($table != null and $this->is_table($table)){
			$no_error = true;

			if(($array = $this->select_all($table)) !== false)
				foreach($array as $value)
					$no_error &= $this->delete($table, $value['key']);
					// And binaire : si un false on reste false

			if($no_error){
				$output = rmdir($this->path_db.'/'.$table);
				clearstatcache();

				return $output;
			}
		}

		return false;
	}
}
