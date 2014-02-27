<div class="container">
	<form class="form-add" role="form" action="index.php?page=produit&amp;action=ajouterunproduit" method="POST" >
		<h1 class="form-add-heading">Ajouter un produit</h1>

		<div class="form-group">
			<label for="referenceProduit">R&eacute;f&eacute;rence</label>
			<input type="text" class="form-control"  id="referenceProduit" name="referenceProduit" placeholder="R&eacute;f&eacute;rence produit">

			<label for="nomProduit">Nom</label>
			<input type="text" class="form-control"  id="nomProduit" name="nomProduit" placeholder="Nom">

			<label for="prixProduit">Prix</label>
			<input type="number" step="any" class="form-control"  id="prixProduit" name="prixProduit" placeholder="Prix">

			<label for="poidsProduit">Poids</label>
			<input type="number" step="any" class="form-control"  id="poidsProduit" name="poidsProduit" placeholder="Poids">

			<label for="dateProduit">Date d'entr&eacute;e</label>
			<input type="date" class="form-control"  id="dateProduit" name="dateProduit" placeholder="Date">

			<label for="fourProduit">Fournisseur</label>
			<select class="form-control" id="fourProduit" name="fourProduit">
				<?php
				if(
					!empty($arg['lesFournisseurs'])
					and is_array($arg['lesFournisseurs'])
					)
				{
					foreach ($arg['lesFournisseurs'] as $unFournisseur)
					{
						echo '<option value = ';
						echo $unFournisseur->FOU_ID;
						echo '>'.$unFournisseur->FOU_RAISONSOC.'</option>';
					}
				}
				?>
			</select>
			</br>

			<center>
				<button type="submit" class="btn btn-lg btn-primary btn-block" name="sbmtMkProduit">Ajouter le produit</button>
			</center>
		</div>
	</form>
</div>
