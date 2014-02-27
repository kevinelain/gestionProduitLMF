<div class = "container">
	<h1>Les produits</h1>
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
						<td><?php echo $value->PRO_NOM;?></td>
						<td><?php echo $value->PRO_POIDS;?></td>
						<td><?php echo $value->PRO_DATE;?></td>
						<td>
							<a href="index.php?page=fournisseur&amp;action=unfournisseur&amp;valeur=<?php echo $value->FOU_ID;?>">
								<?php echo $value->FOU_NOM;?>
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
</div>