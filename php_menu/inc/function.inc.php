<?php
/**
 * fichier de déclaration des fonctions globales
 */
	/**
	 * gere l'affichage des templates
	 *
	 * @param  string $name contient le nom du template a inclure depuis /view
	 * @param  array $arg  tableau facultatif d'argments a fournir a la vue
	 * @return void       realise juste l'inclusion
	 */
function view($name = null, array $arg = null)
{
	if(empty($name))
		return;
		/** inclusion du template */
	if (is_file('view/'.$name.'.tpl.php'))
		include 'view/'.$name.'.tpl.php';
}
