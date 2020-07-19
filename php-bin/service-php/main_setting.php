<?php
	$root_web = $_SERVER['DOCUMENT_ROOT'];
	$root_web_array = explode("/", $root_web);
	if($root_web_array[count($root_web_array) - 1] != 'BeeJee')
		$root_web .= '/BeeJee';

	include($root_web . '/php-bin/service-php/header-css.php');
	include($root_web . '/php-bin/service-php/header-js.php');
    
	/*include('/php-bin/classes/Rights.php');
	if(!Rights::check_access_current_page())
		Rights::redirect_error_page();*/
	
	echo "</head>";
	
	include($root_web . '/php-bin/elements-design/footer-top.php');
	include($root_web . '/php-bin/elements-design/modal-window.php');
	//include($root_web . '/php-bin/elements-design/ispoln-interface.php');*/
?>