<div class="container">
	<form class="form-add" role="form" action="index.php?page=produit&amp;action=modifierunproduit<?php
				if (!empty($arg['leProduit']))
					echo '&amp;valeur='.$arg['leProduit']->PRO_ID;
			?>" method="POST" >
		<h1 class="form-add-heading">Modifier un produit</h1>
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
					$_SESSION['tampon']['error'] = null;
					?>
				</div>
			</div>
			<?php
		}
		?>

		<div class="form-group">
			<input class="form-control" id="pro_code" type="hidden" name="codeProduit" value="<?php
				if (!empty($arg['leProduit']))
					echo $arg['leProduit']->PRO_ID;
			?>">
		</div>

		<div class="form-group">
			<label for="pro_ref">R&eacute;f&eacute;rence produit</label>
			<input class="form-control" id="pro_ref" type="text" name="referenceProduit" <?php
				if (!empty($arg['leProduit']))
					echo 'value="'.$arg['leProduit']->PRO_REF.'"';
			?> >
		</div>

		<div class="form-group">
			<label for="pro_nom">Nom</label>
			<input class="form-control" id="pro_nom" type="text" name="nomProduit" <?php
				if (!empty($arg['leProduit']))
					echo 'value="'.$arg['leProduit']->PRO_NOM.'"';
			?> >
		</div>

		<div class="form-group">
			<label for="pro_prix">Prix</label>
			<input type="number" step="any" class="form-control" id="pro_prix" name="prixProduit" <?php
				if (!empty($arg['leProduit']))
					echo 'value="'.$arg['leProduit']->PRO_PRIX.'"';
			?> >
		</div>

		<div class="form-group">
			<label for="pro_poids">Poids</label>
			<input type="number" step="any" class="form-control" id="pro_poids" name="poidsProduit" <?php
				if (!empty($arg['leProduit']))
					echo 'value="'.$arg['leProduit']->PRO_POIDS.'"';
			?> >
		</div>

		<div class="form-group">
			<label for="pro_date">Date entr&eacute;e</label>
			<input type ="date" class="form-control" id="pro_date" name="dateProduit" <?php
				if (!empty($arg['leProduit']))
					echo 'value="'.$arg['leProduit']->PRO_DATE.'"';
			?> >
		</div>

		<div class="form-group">
			<label for="pro_fou">Fournisseur du produit</label>
			<select class="form-control" id="pro_fou" name="fournisseurProduit" >
				<?php
				if(
					!empty($arg['lesFournisseurs'])
					and is_array($arg['lesFournisseurs'])
					and !empty($arg['leProduit'])
					)
				{
					foreach ($arg['lesFournisseurs'] as $value)
					{
						echo '<option value="'.$value->FOU_ID.'"';
						if ($value->FOU_ID == $arg['leProduit']->PRO_FOU)
							echo ' selected ';
						echo '>'.$value->FOU_RAISONSOC.'</option>';
					}
				}
				?>
			</select>
		</div>

        <center><button type="submit" class="btn btn-lg btn-primary btn-block" >Modifier</button></center>
	</form>
</div>
