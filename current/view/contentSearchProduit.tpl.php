<div class="container">
	<form class="form-search" role="form" action="index.php" method="GET" >
		<h1 class="form-search-heading">Rechercher un produit</h1>
		<input type="hidden" name="page" class="form-control" value="produit" required >
		<input type="hidden" name="action" class="form-control" value="rechercherunproduit" required >
		<input type="search" name="valeur" class="form-control" placeholder="Nom produit, fournisseur, date format AAAA-MM-JJ..." autofocus <?php
			if(isset($_GET['valeur']) and $_GET['valeur'] !== '')
				echo 'value="'.$_GET['valeur'].'" ';
			?>>
		</br>	
        <center><button type="submit" class="btn btn-lg btn-primary btn-block" >Rechercher</button></center>
	</form>
</div>