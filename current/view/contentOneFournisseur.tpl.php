<div class="container">
	<h1>Informations Fournisseur</h1>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Raison Sociale</th>
				<th>Num&eacute;ro Siret</th>
				<th>T&eacute;l&eacute;phone</th>
				<th>Num&eacute;ro rue</th>
				<th>Nom de la rue</th>
				<th>Code Postal</th>
				<th>Ville</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if(!empty($arg['unFournisseur']))
			{
				?>
				<tr>
					<td>
						<a href="index.php?page=fournisseur&amp;action=unfournisseur&amp;valeur=<?php echo $arg['unFournisseur']->FOU_ID;?>">
							<?php echo $arg['unFournisseur']->FOU_RAISONSOC;?>
						</a>
					</td>
					<td><?php echo $arg['unFournisseur']->FOU_SIRET;?></td>
					<td><?php echo $arg['unFournisseur']->FOU_TELEPHONE;?></td>
					<td><?php echo $arg['unFournisseur']->FOU_NUMERORUE;?></td>
					<td><?php echo $arg['unFournisseur']->FOU_NOMRUE;?></td>
					<td><?php echo $arg['unFournisseur']->FOU_COPOS;?></td>
					<td><?php echo $arg['unFournisseur']->FOU_VILLE;?></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	<h2>Produits associ&eacute;s</h2>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th>R&eacute;f&eacute;rence</th>
				<th>Nom</th>
				<th>Prix</th>
				<th>Poids</th>
				<th>Date d'entr&eacute;e</th>
				<th>Fournisseur</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if(!empty($arg['lesProduits']) and is_array($arg['lesProduits']))
			{
				foreach ($arg['lesProduits'] as $value) {
				?>
					<tr>
						<td>
							<a href="index.php?page=produit&amp;action=unproduit&amp;valeur=<?php echo $value->PRO_ID;?>">
								<?php echo $value->PRO_REF;?>
							</a> <!-- la redirection n'est pas encore faire pour UN PRODUIT -->
						</td>
						<td><?php echo $value->PRO_NOM;?></td>
						<td><?php echo $value->PRO_PRIX;?> €</td>
						<td><?php echo $value->PRO_POIDS;?> Kg</td>
						<td><?php echo $value->PRO_DATE;?></td>
						<td>
							<a href="index.php?page=fournisseur&amp;action=unfournisseur&amp;valeur=<?php echo $value->FOU_ID;?>">
								<?php echo $value->FOU_RAISONSOC;?>
							</a> <!-- la redirection n'est pas encore faire pour UN FOURNISSEUR -->
						</td>
					</tr>
				<?php
				}
			}
			?>
		</tbody>
	</table>
		<?php
		if(!empty($_SESSION['tampon']['error']) and is_array($_SESSION['tampon']['error']))
		{
			?>
			<div class="has-error">
				<div class="input-group-addon">
					<?php
					foreach ($_SESSION['tampon']['error'] as $value) {
						echo $value .'<br />';
					}
					?>
				</div>
			</div>
			<?php
			$_SESSION['tampon']['error'] = null;
		}
		?>
</div><!-- /.container -->
