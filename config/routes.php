<?php
require_once(dirname(__FILE__).'/../router/Routes.php');

Routes::$base_route = "api/controllers";

/*****
EXAMPLES
******/

Routes::addResource('example');

// Routes::addResource("people", [
// 	"actions" => ["create", "index", "update", "show"]//,
// 	"resources" => [
// 		"cars" => [
// 			"actions" => ["create", "index", "update", "show"]
// 		]
// 	]
// ]);

// Routes::addRoute('/owners/:owners_id/cars', [
// 	'method' => 'POST',
// 	'controller' => 'owners',
// 	'function' => 'createCar'
// ]);

/*****
END EXAMPLES
******/

?>
