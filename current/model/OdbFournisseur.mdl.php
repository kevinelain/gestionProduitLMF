<?php
class odbFournisseur{

	private $oBdd;

	public function __construct()
	{
		$this->oBdd = $_SESSION['bdd'];
	}

	public function estType($id)
	{
		if(!empty($id))
		{
			$req = 'SELECT COUNT(*) AS nb
					FROM FOURNISSEUR
					WHERE FOU_ID = :id';

			$data = $this->oBdd->query($req , array('id'=>$id), Bdd::SINGLE_RES);

			return (bool) $data->nb;
		}

		return false;
	}

	public function getLesFournisseurs()
	{
		$req = 'SELECT *
				FROM
				FOURNISSEUR';

		$lesFournisseurs = $this->oBdd->query($req);

		return $lesFournisseurs;
	}
}
