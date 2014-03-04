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
				WHERE PRO_FOU = FOU_ID
				ORDER BY PRO_DATE DESC';

		$lesProduits = $this->oBdd->query($req);

		return $lesProduits;
	}

	public function getUnProduit($codeProduit){
		$req = 'SELECT *
				FROM PRODUIT, FOURNISSEUR
				WHERE PRO_ID = :codeProduit
					AND PRO_FOU = FOU_ID';

		$leProduit = $this->oBdd->query($req, array('codeProduit'=>$codeProduit), Bdd::SINGLE_RES);

		return $leProduit;
	}

	public function getLesProduitsDeFournisseur($codeFournisseur){

		$req = 'SELECT *
				FROM PRODUIT, FOURNISSEUR
				WHERE FOU_ID = :codeFournisseur
					AND PRO_FOU = FOU_ID';

		$lesProduits = $this->oBdd->query($req, array('codeFournisseur'=>$codeFournisseur));

		return $lesProduits;
	}

	public function creerUnProduit()
	{
		$req = 'SELECT MAX(PRO_ID) + 1 AS MAXID
		     	FROM PRODUIT';
		$iProId = $this->oBdd->query($req, array(), Bdd::SINGLE_RES);

		//echo $iProId->MAXID;
		//die();
		//echo $_POST['fourProduit'];
		//die();

		$req = 'INSERT INTO PRODUIT (
					 `PRO_ID`,
					 `PRO_REF`,
					 `PRO_NOM`,
					 `PRO_PRIX`,
					 `PRO_POIDS`,
					 `PRO_DATE`,
					 `PRO_FOU`
					)
				VALUES (
					 :idProd,
					 :refProd,
					 :nomProd,
					 :prixProd,
					 :poidsProd,
					 :dateProd,
					 :fourProd
					 )';

		$out = $this->oBdd->exec($req, array(
				 'idProd'=>$iProId->MAXID,
				 'refProd'=>$_POST['referenceProduit'],
				 'nomProd'=>$_POST['nomProduit'],
				 'prixProd'=>$_POST['prixProduit'],
				 'poidsProd'=>$_POST['poidsProduit'],
				 'dateProd'=>$_POST['dateProduit'],
				 'fourProd'=>$_POST['fourProduit'],
				));
		return $out;
	}
	
	/**
	 * permet de faire une recherche de produit
	 * @param  [type] $valeur prend la valeur du nom produit,
	 *                        nom du fournisseur etc
	 *                        format recherche date: AAA-MM-JJ
	 * @return [type]         [description]
	 */
	public function searchProduits($valeur)
	{
		$req = "SELECT *
				FROM `PRODUIT`, `FOURNISSEUR`
				WHERE `PRO_FOU` = `FOU_ID`
					AND `PRO_REF` LIKE :valeur
					OR `PRO_NOM` LIKE :valeur
					OR `FOU_RAISONSOC` LIKE :valeur
					OR `PRO_DATE` LIKE :valeur
				ORDER BY PRO_DATE DESC";

		$lesProduits = $this->oBdd->query($req, array('valeur'=>'%'.$valeur.'%'));

		return $lesProduits;

	}
}
