<?php

function getMicrotime() {
	$start_time = microtime();
	$start_array = explode(" ", $start_time);
	return $start_array[1] + $start_array[0];
}

$start_time = getMicrotime();
if(!session_id()) {
	session_start();
}

require_once 'config.php';
require_once 'core/Core.php';

$app = new Application('index', 'layout_default');
$app->run(isset($_GET['action']) ? $_GET['action'] : 'index');

printf("<!-- %f -->", getMicrotime() - $start_time);

?>