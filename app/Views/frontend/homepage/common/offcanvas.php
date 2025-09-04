<?php $main_nav = get_menu(array('keyword' => 'main-menu','language' => 'vi', 'output' => 'array')); ?>
<?php 
	$cookie  = [];
    if(isset($_COOKIE[AUTH.'member'])) $cookie = json_decode($_COOKIE[AUTH.'member'],TRUE);
 ?>