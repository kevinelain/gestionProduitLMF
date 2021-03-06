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
					FROM PRODUITS_FOURNISSEUR
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
				PRODUITS_FOURNISSEUR';

		$lesFournisseurs = $this->oBdd->query($req);

		return $lesFournisseurs;
	}

	public function getUnFournisseur($codeFournisseur){
		$req = 'SELECT *
				FROM PRODUITS_FOURNISSEUR
				WHERE FOU_ID = :codeFournisseur';

		$leFournisseur = $this->oBdd->query($req, array('codeFournisseur'=>$codeFournisseur), Bdd::SINGLE_RES);

		return $leFournisseur;
	}

	public function creerUnFournisseur()
	{
		$req = 'SELECT MAX(FOU_ID) + 1 AS MAXID
		     	FROM PRODUITS_FOURNISSEUR';
		$iFouId = $this->oBdd->query($req, array(), Bdd::SINGLE_RES);

		//echo $iFouId->MAXID;
		//die();

		$req = 'INSERT INTO PRODUITS_FOURNISSEUR (
					 `FOU_ID`,
					 `FOU_RAISONSOC`,
					 `FOU_SIRET`,
					 `FOU_TELEPHONE`,
					 `FOU_NUMERORUE`,
					 `FOU_NOMRUE`,
					 `FOU_COPOS`,
					 `FOU_VILLE`
					)
				VALUES (
					 :idFou,
					 :raisonSocFou,
					 :siretFou,
					 :telephoneFou,
					 :numeroRueFou,
					 :nomRueFou,
					 :coposFou,
					 :villeFou
					 )';

		$out = $this->oBdd->exec($req, array(
				 'idFou'=>$iFouId->MAXID,
				 'raisonSocFou'=>$_POST['raisonSocFou'],
				 'siretFou'=>$_POST['siretFou'],
				 'telephoneFou'=>$_POST['telephoneFou'],
				 'numeroRueFou'=>$_POST['numeroRueFou'],
				 'nomRueFou'=>$_POST['nomRueFou'],
				 'coposFou'=>$_POST['coposFou'],
				 'villeFou'=>$_POST['villeFou'],
				));
		return $out;
	}

	/**
	 * permet de faire une recherche de fournisseur
	 * @param  [type] $valeur prend la valeur du nom fournisseur,
	 *                        nom du fournisseur, siret...
	 * @return [type]         [description]
	 */
	public function searchFournisseurs($valeur)
	{
		$req = "SELECT *
				FROM `PRODUITS_FOURNISSEUR`
				WHERE `FOU_RAISONSOC` LIKE :valeur
					OR `FOU_SIRET` LIKE :valeur
					OR `FOU_VILLE` LIKE :valeur
					OR `FOU_TELEPHONE` LIKE :valeur";

		$lesFournisseurs = $this->oBdd->query($req, array('valeur'=>'%'.$valeur.'%'));

		return $lesFournisseurs;

	}
}
