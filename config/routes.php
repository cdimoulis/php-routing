<?php
require_once(dirname(__FILE__).'/../bin/routes.php');

/*****
Configuration variables
******/

/*****
The default route for for the 'controllers' files
Default: "/api/controllers"
******/
// Routes::$controller_route = "/api/controllers";

/*****
The route that will list all routes. Must call showRoutes to turn this
functionality on.
Default: '_routes'
******.
// Routes::$view_routes = '/_routes';


/*****
ROUTES
******/

/*****
EXAMPLES
******/

// Add Resource builds all routes according to the resource name passed
// In example below the controller will be example.php. With the default
// $controller_route the file should be at /api/controllers/example.php
Routes::addResource('example');

// Add Resource has options that can be set
// THIS EXAMPLE NO CONTROLLER OR METHODS. THIS IS SIMPLY TO SHOW ROUTE EXAMPLES
//   actions: array of desired actions: ['new', 'create', 'index', 'show', 'edit', 'update', 'delete']
//   controller: file name of handling php file. will be appended to $controller_route
//              Default controller is {resource}.php
//   controller_route: a specific controller route besides the default
//   resources: creates nested routes. Object Has same options (actions, controlelr, controller_route)
Routes::addResource("parent", [
	"actions" => ["index", "show"],
	"resources" => [
		"child" => [
			"actions" => ["create", "index", "update", "show"]
		]
	]
]);

// Add Route adds only a single route
//   method: request method
//   controller: file where request goes (default would be the route without '/')
//   function: function to call to handle request
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
