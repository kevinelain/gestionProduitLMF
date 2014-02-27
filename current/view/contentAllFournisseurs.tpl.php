<div class = "container">
	<h1>Les fournisseurs</h1>
	<table class="table table-bordered table-striped">
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
			if(!empty($arg['lesFournisseurs']) and is_array($arg['lesFournisseurs']))
			{
				foreach ($arg['lesFournisseurs'] as $value) {
					?>
					<tr>
						<td>
							<a href="index.php?page=fournisseur&amp;action=unfournisseur&amp;valeur=<?php echo $value->FOU_ID;?>">
								<?php echo $value->FOU_RAISONSOC;?>
							</a> <!-- @todo la redirection n'est pas encore faire pour UN FOURNISSEUR -->
						</td>
						<td><?php echo $value->FOU_SIRET;?></td>
						<td><?php echo $value->FOU_TELEPHONE;?></td>
						<td><?php echo $value->FOU_NUMERORUE;?></td>
						<td><?php echo $value->FOU_NOMRUE;?></td>
						<td><?php echo $value->FOU_COPOS;?></td>
						<td><?php echo $value->FOU_VILLE;?></td>
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