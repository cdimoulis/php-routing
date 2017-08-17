# php-routing
Adding controller routing to

#### File Requirements
You must keep the folders:
* /bin
* /config
And file
* init.php

### Configuration
Configuration is done in the /config directory.

##### Router
/config/router.php is where routing options are set. The options to set are:
* `Router::$full_routing`: Determines whether all requsted routes should exist in the /config/route.php file. If true a 404 will be given when no match with the routes. If false then requests will be allowed to proceed per usual PHP behavior.


##### Routes
/config/routes.php is there routes options and routes are built. Configuration options are:
* `Routes::$controller_route`: The default route for the 'controller' files that will handle requests. Default: `/api/controllers`
* `Routes::$view_routes`: The route which will show all routes built in /config/route.php. Must call `Routes::showRoutes` to turn functionality on. Default: `/_routes`

** Building Routes **
See /config/routes.php for examples. There are two functions for building routes:
* `Routes::addResource(resource_name, options)`:
  * `resource_name`: The name of the resource
  * `options`: Optional key => value array. Provides ability to alter defaults and add nesting
    * `actions`: array of desired actions: ['new', 'create', 'index', 'show', 'edit', 'update', 'delete']
    * `controller`: file name of handling php file. will be appended to $controller_route. Default controller is {resource}.php
    * `controller_route`: a specific controller route besides the default
    * `resources`: creates nested routes. Object Has same options (actions, controller, controller_route)

### Examples
`/config/routes.php` contain example routes that can be removed.

`/api/controllers/example.php` is an example controller used in the example routes

`/pages/example/index.php` is an example view called in the example controller.

### Response.php
For help a response class has been provided to return JSON or a php view. Examples of use are in `/api/controllers/example.php`.
* `Response.sendJSON($data)`: Respond with $data as JSON with 200 status
* `Response.sendJSONwithStatus($data, $status)`: Respond with $data as JSON with $status
* `Response.sendView($view, $data)`: Render the php file at $view with $data available on to use on page.
