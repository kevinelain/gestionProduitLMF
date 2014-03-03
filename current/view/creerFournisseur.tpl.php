<div class="container">
	<form class="form-add" role="form" action="index.php?page=fournisseur&amp;action=ajouterunfournisseur" method="POST" >
		<h1 class="form-add-heading">Ajouter un fournisseur</h1>

		<div class="form-group">
			<label for="raisonSocFou">Raison sociale</label>
			<input type="text" class="form-control"  id="raisonSocFou" name="raisonSocFou" placeholder="Raison sociale">

			<label for="siretFou">Num&eacute;ro Siret</label>
			<input type="text" class="form-control"  id="siretFou" name="siretFou" placeholder="Num&eacute;ro Siret">

			<label for="telephoneFou">T&eacute;l&eacute;phone</label>
			<input type="text" class="form-control"  id="telephoneFou" name="telephoneFou" placeholder="T&eacute;l&eacute;phone">

			<label for="numeroRueFou">Num&eacute;ro de rue</label>
			<input type="text" class="form-control"  id="numeroRueFou" name="numeroRueFou" placeholder="Num&eacute;ro de rue">

			<label for="nomRueFou">Nom de la rue</label>
			<input type="text" class="form-control"  id="nomRueFou" name="nomRueFou" placeholder="Nom de la rue">

			<label for="coposFou">Code postal</label>
			<input type="text" class="form-control"  id="coposFou" name="coposFou" placeholder="Code postal">

			<label for="villeFou">Ville</label>
			<input type="text" class="form-control"  id="villeFou" name="villeFou" placeholder="Ville">

			</br>

			<center>
				<button type="submit" class="btn btn-lg btn-primary btn-block" name="sbmtMkFournisseur">Ajouter le fournisseur</button>
			</center>
		</div>
	</form>
</div>
