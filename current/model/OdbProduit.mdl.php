<?php
class odbProduit{

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
					FROM PRODUIT
					WHERE PRO_ID = :id';

			$data = $this->oBdd->query($req , array('id'=>$id), Bdd::SINGLE_RES);

			return (bool) $data->nb;
		}

		return false;
	}

	public function getLesProduits()
	{
		$req = 'SELECT *
				FROM
				PRODUIT, FOURNISSEUR
				WHERE PRO_FOU = FOU_ID';

		$lesProduits = $this->oBdd->query($req);

		return $lesProduits;
	}
}
