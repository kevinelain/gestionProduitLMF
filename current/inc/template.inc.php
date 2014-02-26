<?php
function view($name = null, array $arg = null)
{
	if(empty($name))
		return;
	// inclusion du template
	include 'view/'.$name.'.tpl.php';
}
