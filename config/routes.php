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

// All routes according to defaults
Routes::addResource('example');

// Only particular actions also nested resource
// NO CONTROLLER OR METHODS. THIS IS SIMPLY TO SHOW ROUTE EXAMPLES
// View '/_routes' uri (or $view_routes route if changed from default)
Routes::addResource("parent", [
	"actions" => ["index", "show"],
	"resources" => [
		"child" => [
			"actions" => ["create", "index", "update", "show"]
		]
	]
]);

// Route points to function that returns view
Routes::addRoute('/my_example', [
	'method' => 'GET',
	'controller' => 'example',
	'function' => 'example_view'
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
