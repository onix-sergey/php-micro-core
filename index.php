<?php

function pr($obj) {
	echo '<pre>';
	var_dump($obj);	
	echo '</pre>';
}

function getMicrotime() {
	$start_time = microtime();
	$start_array = explode(" ", $start_time);
	return $start_array[1] + $start_array[0];
}

$start_time = getMicrotime();
if(!session_id()) {
	session_start();
}
if(!isset($_SESSION['auth_state'])){
	$_SESSION['auth_state'] = 0;
	$_SESSION['auth_token'] = null;
	$_SESSION['auth_secret'] = null;
	$_SESSION['userdata'] = null;
	$_SESSION['access_token'] = null;
	$_SESSION['access_token_secret'] = null;
}

require_once 'config.php';
require_once 'classes/Core.php';

$app = new Application();
$app->run(isset($_GET['action']) ? $_GET['action'] : 'main');

printf("<!-- %f -->", getMicrotime() - $start_time);

?>