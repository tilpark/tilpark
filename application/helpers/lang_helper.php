<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_lang($value)
{
	
	$lang['you can undo this operation.'] = 'bu işlemi geri alabilirsiniz.';
	
	
	if(!isset($lang[$value]))
	{
		$lang[$value] = $value;
	}
	
	return $lang[$value];
}

function lang($value)
{
	echo get_lang($value);
}

?>