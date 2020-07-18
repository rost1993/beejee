<?php
	/*$path = $_SERVER['DOCUMENT_ROOT'];
	$arr_path = explode("/", $path);
	if($arr_path[count($arr_path) - 1] != 'papillon')
		$path .= '/papillon';*/
	
	
	echo password_hash('123', PASSWORD_BCRYPT);

	include('php-bin/service-php/main_setting.php');
?>

<!DOCTYPE HTML>
<html>
<body>
	<?php //include($path . '/php-bin/elements-design/footer-IC.php'); ?>
</body>
</html>