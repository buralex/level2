<?php

define('ROOT', str_replace("\\","/", __DIR__));
require_once ROOT . '/autoload.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$pathParts = explode('/', $path);

//print_r($pathParts);


//$ctrl = isset($_GET['ctrl']) ? $_GET['ctrl'] : 'Images';
//$act = isset($_GET['act']) ? $_GET['act'] : 'All';
//$actAdd = isset($_GET['actAdd']) ? $_GET['actAdd'] : '';

$ctrl = !empty($pathParts[1]) ? ucfirst($pathParts[1]) : 'Images';
$act = !empty($pathParts[2]) ? ucfirst($pathParts[2]) : 'All';
$param = !empty($pathParts[3]) ? $pathParts[3] : '';

try {
	$controllerClassName = $ctrl . 'Controller';
	$controller = new $controllerClassName;
	$method = 'action' . $act;
	$controller->$method($param);

} catch (CustomException $e) {
	$view = new View();
	$view->error = $e->getMessage();
	$view->display('error.php');
}

