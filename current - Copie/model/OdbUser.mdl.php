<?php
class OdbUser{

	private $oNosql;
	private $oBdd;

	public function __construct()
	{
		$this->oBdd = $_SESSION['bdd'];
		$this->oNosql = $_SESSION['nosql'];
	}

	public function estUser($nom)
	{
		if(!empty($nom))
		{
			$req = 'SELECT COUNT(*) AS nb
					FROM USER
					WHERE Use_Nom = :nom';

			$data = $this->oBdd->query($req , array('nom'=>$nom), Bdd::SINGLE_RES);

			return (bool) $data->nb;
		}

		return false;
	}

	public function getUser($nom)
	{
		if(!empty($nom))
		{
			$req = 'SELECT *
					FROM USER
					WHERE Use_Nom = :nom';

			$data = $this->oBdd->query($req , array('nom'=>$nom), Bdd::SINGLE_RES);

			return $data;
		}

		return false;
	}

	/**
	 * verifie que le mot de passe est bon
	 *
	 * prend un hash du mot de passe,
	 * le nom de l'utilisateur,
	 * et cherche une entree qui valides les deux
	 *
	 * @param  string $nom  le nom du user
	 * @param  string $hash le hash du mdp user
	 * @return bool       valide ou non l'existance
	 */
	public function checkHashUser($nom, $hash)
	{
		if(!empty($nom) and !empty($hash))
		{
			$req = 'SELECT COUNT(*) AS nb
					FROM USER
					WHERE Use_Nom = :nom
						AND Use_Hash = :hash';

			$data = $this->oBdd->query($req , array('nom'=>$nom, 'hash'=>$hash), Bdd::SINGLE_RES);

			return (bool) $data->nb;
		}

		return false;
	}
	public function saveToken($name, $token)
	{
		if($name !== null and !empty($token))
		{
			if (!$this->oNosql->is_table('remember_me'))
				if(!$this->oNosql->create('remember_me'))
					return false;

			$this->oNosql->delete('remember_me', $name);

			return $this->oNosql->insert('remember_me', $name, $token);
		}

		return false ;
	}
	public function forgetToken($name)
	{
		if($name !== null)
			return $this->oNosql->delete('remember_me', $name);

		return false ;
	}
	public function getToken($name)
	{
		if($name !== null)
			return $this->oNosql->query('remember_me', $name);

		return false ;
	}
}
