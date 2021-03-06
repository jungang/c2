<?php
//-------------------------------------------------------------------------------------
//	JibberBook v2.3
//	(c) 2009 Chris Jaure
//	license: MIT License
//	website: http://www.jibberbook.com/
//
//	admin/index.php
//-------------------------------------------------------------------------------------
require_once('inc/secure.php');
require_once('../inc/includes.php');
includes(array('admin/actions/load.php', 'admin/actions/transformxml.php'));

$_SESSION['referer'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
require_once('inc/header.php');
?>

<h2><?php _e('Recent Ham'); ?></h2>
<?php 
loadHam(5);  
?>
<hr />
<h2><?php _e('Recent Spam'); ?></h2>
<?php 
loadSpam(5);  
?>

<?php require_once('inc/footer.php'); ?>