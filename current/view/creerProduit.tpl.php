<div class="container">
	<form class="form-add" role="form" action="index.php?page=intervention&amp;action=creerbonintervention" method="POST" >
		<h1 class="form-add-heading">Cr&eacute;er un bon d'intervention</h1>

		<div class="form-group">
			<?php
			if(!empty($arg['laDemandeInterNum']))
			{ ?>
				<label for="code_demande">Demande concern&eacute;e</label>
				<select class="form-control" id="code_demande" name="code_demande" disabled>
					<?php
					echo '<option selected >'.$arg['laDemandeInterNum'].'</option>';
					?>
				</select>
				<?php
			}
			?>
			<label for="vel_num">V&eacute;lo concern&eacute;</label>
			<select class="form-control" id="vel_num" name="vel_num"
				<?php
				if(!empty($arg['laDemandeInterNum']))
					echo ' disabled';
				?>
				>
				<?php
				if(
					!empty($arg['lesVelos'])
					and is_array($arg['lesVelos'])
					)
				{
					foreach ($arg['lesVelos'] as $unVelo)
					{
						echo '<option';
						if ($unVelo->Vel_Num == $arg['leVeloNum'])
							echo ' selected ';
						echo '>'.$unVelo->Vel_Num.'</option>';
					}
				}
				?>
			</select>

			<label for="cpteRendu">Compte rendu</label>
			<input type="text" class="form-control"  id="cpteRendu" name="cpteRendu" placeholder="Motif du probleme">

			<label for="dateDebut">Date de d&eacute;but de l'intervention</label>
			<input type="date" class="form-control"  id="dateDebut" name="dateDebut" placeholder="Date de debut">

			<label for="dateFin">Date de fin de l'intervention</label>
			<input type="date" class="form-control"  id="dateFin" name="dateFin" placeholder="Date de fin">

			<div class="checkbox">
				<label for="vel_reparable">
				<input type="checkbox" id="vel_reparable" name="veloReparable">
				V&eacute;lo NON r&eacute;parable
				</label>
			</div>

			<div class="checkbox">
				<label for="vel_surPlace">
				<input type="checkbox" id="vel_surPlace" name="surPlace" checked="checked">
				R&eacute;parable sur place
				</label>
			</div>



        	<button type="submit" class="btn btn-lg btn-primary btn-block" name="sbmtMkBon">Ajouter le bon</button>
		</div>
	</form>
</div>
