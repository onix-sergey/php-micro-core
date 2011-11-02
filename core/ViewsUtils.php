<?php

/**
 * Update param in get url.
 * @param unknown_type $name
 * @param unknown_type $value
 */
function setGETParam($name, $value) {	
	if (isset($_GET[$name])) {			
		return preg_replace('/' . $name . '=\d{0,}/', $name . '=' . $value, $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
	} else {
		return $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] . '&' . $name .'=' . $value;
	}
}

/**
 * Redirect.
 * @param unknown_type $url
 */
function redirect($url) {
	header("Location: $url");
}

/**
 * Build sort url.
 * @param string $label
 * @param string $action
 * @param string $sort
 */
function getSortUrl($label, $action, $sort) {
	
	// Sort type.
	if (isset($_GET['sort']) && $_GET['sort'] == $sort && isset($_GET['sort_type']) && $_GET['sort_type'] == 'desc') { 
		$sort_type = 'asc'; 
	} else { 
		$sort_type = 'desc'; 
	}
	
	// Sort arrow.
	$sort_arrow = "";
	if (isset($_GET['sort']) && $_GET['sort'] == $sort) { 
		if (isset($_GET['sort_type']) && $_GET['sort_type'] == 'desc') { 
			$sort_arrow = ' &uarr;'; 
		} else { 
			$sort_arrow = ' &darr;'; 
		}
	} 
	return '<a href="index.php?action=' . $action . '&sort=' . $sort . '&sort_type=' . $sort_type . '">' . $label . '</a>' . $sort_arrow;
}

function clearhtml($string) {
	$string = str_replace(array("\n", "\t"), "", $string);
	
	if(mb_detect_encoding($string) != "UTF-8"){
		$string = mb_convert_encoding($string, "UTF-8");
	}
	$string = addslashes($string);
	$string = htmlentities($string, ENT_QUOTES, "UTF-8");
	return $string;
}
?>