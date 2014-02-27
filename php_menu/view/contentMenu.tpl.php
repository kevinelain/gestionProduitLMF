<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<!-- bouton en format mini -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">B&amp;P</a>
		</div>
		<!-- full menu -->
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<?php
					$menu = $_SESSION['menu']->getCurrentMenu(0);
					echo '<a href="'.$menu['url'].'" class="dropdown-toggle" data-toggle="dropdown">';
					echo $menu['title'].' <b class="caret"></b></a>';
					?>
					<ul class="dropdown-menu">
						<?php
						foreach ($_SESSION['menu']->getListMenu(0) as $title => $url) {
							echo '<li';
							if($_SESSION['menu']->isCurrentMenu(0, $title))
								echo ' class="active"';
							echo ' >';
							echo '<a href="'.$url.'">'.$title.'</a>';
							echo '</li>';
						}

						?>
					</ul>
				</li>

				<?php
				$subMenu1 = $_SESSION['menu']->getListMenu(1);
				// si presence d'un sous menu
				if(!empty($subMenu1))
				{
					?>
					<li class="dropdown">
						<?php
						$menu = $_SESSION['menu']->getCurrentMenu(1);
						echo '<a href="'.$menu['url'].'" class="dropdown-toggle" data-toggle="dropdown">';
						echo $menu['title'].' <b class="caret"></b></a>';
						?>
						<ul class="dropdown-menu">
						<?php
						foreach ($subMenu1 as $title => $url) {
							if(is_array($url))
							{
								echo '<li class="dropdown-header">'.$title.'</li>';
								foreach ($url as $subTitle => $subUrl) {
									echo '<li';
									if($_SESSION['menu']->isCurrentMenu(1, $subTitle))
										echo ' class="active"';
									echo ' >';
									echo '<a href="'.$subUrl.'">'.$subTitle.'</a>';
									echo '</li>';
								}
								echo '<li class="divider"></li>';
							}
							else{
								echo '<li';
								if($_SESSION['menu']->isCurrentMenu(1, $title))
									echo ' class="active"';
								echo ' >';
								echo '<a href="'.$url.'">'.$title.'</a>';
								echo '</li>';
							}
						}

						?>
						</ul>
					</li>
					<?php
				}
				$subMenu2 = $_SESSION['menu']->getListMenu(2);
				// si presence d'un sous menu
				if(!empty($subMenu2))
				{
					?>
					<li class="dropdown">
						<?php
						$menu = $_SESSION['menu']->getCurrentMenu(2);
						echo '<a href="'.$menu['url'].'" class="dropdown-toggle" data-toggle="dropdown">';
						echo $menu['title'].' <b class="caret"></b></a>';
						?>
						<ul class="dropdown-menu">
						<?php
						foreach ($subMenu2 as $title => $url) {
							if(is_array($url))
							{
								echo '<li class="dropdown-header">'.$title.'</li>';
								foreach ($url as $subTitle => $subUrl) {
									echo '<li';
									if($_SESSION['menu']->isCurrentMenu(2, $subTitle))
										echo ' class="active"';
									echo ' >';
									echo '<a href="'.$subUrl.'">'.$subTitle.'</a>';
									echo '</li>';
								}
								echo '<li class="divider"></li>';
							}
							else{
								echo '<li';
								if($_SESSION['menu']->isCurrentMenu(2, $title))
									echo ' class="active"';
								echo ' >';
								echo '<a href="'.$url.'">'.$title.'</a>';
								echo '</li>';
							}
						}

						?>
						</ul>
					</li>
					<?php
				}
				?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="index.php?page=logout">D&eacute;connecter</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a href="index.php?page=logout" title="Alertes">(3)&nbsp;<img class="perso_mini_icon" src="img/glossy_ecommerce_icons/alert.png"></a>
				</li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</div>
