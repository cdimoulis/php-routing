<?php
require_once(dirname(__FILE__).'/../bin/routes.php');

/*****
Configuration variables
******/

// The default route for for the 'controllers' files
// Defauot: "api/controllers"
// Routes::$controller_route = "api/controllers";

// The route that will list all routes. Must call showRoutes to turn this
// functionality on.
// Default: '_routes'
Routes::$view_routes = '/_routes';

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

Routes::addRoute('/people', [
	'method' => 'GET',
	'controller' => 'example',
	'function' => 'chicken'
]);

/*****
END EXAMPLES
******/

// Calling show routes will add a page using the value inRoutes::$view_routes.
// This page will list all the routes and associated info
// It is recommended to add logic to determine if this should be turned on.
// i.e only call if in developement, not production.
Routes::showRoutes();

?>
