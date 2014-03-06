<div class="container">
	<h1>Informations Produit</h1>
	<table class="table table-bordered">
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
			if(!empty($arg['unProduit']))
			{
			?>
				<tr>
					<td><?php echo $arg['unProduit']->PRO_REF;?></td>
					<td><?php echo $arg['unProduit']->PRO_NOM;?></td>
					<td><?php echo $arg['unProduit']->PRO_PRIX;?> €</td>
					<td><?php echo $arg['unProduit']->PRO_POIDS;?> Kg</td>
					<td><?php echo $arg['unProduit']->PRO_DATE;?></td>
					<td>
						<a href="index.php?page=fournisseur&amp;action=unfournisseur&amp;valeur=<?php echo $arg['unProduit']->PRO_FOU;?>">
							<?php echo $arg['unProduit']->FOU_RAISONSOC;?>
						</a>
					</td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
	<form class="form-add" role="form" action="index.php" method="GET" >

		<input type="hidden" name="page" class="form-control" value="produit" required >
		<input type="hidden" name="action" class="form-control" value="modifierunproduit" required >
		<input type="hidden" name="valeur" class="form-control" <?php
			if(!empty($arg['unProduit']))
				echo 'value="'.$arg['unProduit']->PRO_ID.'" ';
			?> required >
        <center><button type="submit" class="btn btn-lg btn-primary btn-block" >Modifier</button></center>
	</form>
	<br />
</div><!-- /.container -->
