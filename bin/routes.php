<?php
class Routes {

  /*****
  Class variables
  ******/

  // Default base route for controller location
  public static $controller_route = '/api/controllers';
  // Route that will display all routes and route info
  public static $view_routes = '_routes';

  // Array of routes. Will be added to by calling addResource() or addRoute()
  // Retrive by calling getRoutes()
  private static $routes = [];

  /*******
  PUBLIC functions for adding and searching routes
  ********/

  // Get the routes tree
  public static function getRoutes() {
    return self::$routes;
  }

  // Add routes by adding resource options
  public static function addResource($resource, $options=[]) {
    self::setResourceDefaults($resource, $options);
    self::buildRoutes("", $resource, $options);
  }

  // Add an individual route
  public static function addRoute($route, $options) {
    self::setRouteDefaults($route, $options);
    self::setRoute($route, $options['method'], $options['controller_route'],
                  $options['controller'], $options['function']);
  }

  // Call with the request route and request method.
  // Will return the controller information if there is a match
  public static function findRouteMatch($route, $method) {
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    $uri = trim($uri, '//');
    $request_route = explode("/", $uri);
    // print_r($request_route);
    $index = array_search('api', $request_route);

    // Get the request after the api route
    $match = self::searchRoutes($request_route, $method);
    return $match;
  }

  // Call to show routes page
  public static function showRoutes() {
    self::addRoute(self::$view_routes, [
      'method' => 'GET',
      'controller' => 'routes',
      'function' => 'display_routes',
      'controller_route' => '/bin'
    ]);
  }

  /********
  * PRIVATE functions
  *********/
  private static function setResourceDefaults($resource, &$options) {
    // Add the default actions if not provided
    if (!(isset($options['actions']))) {
      $options['actions'] = ["new", "create", "index", "show", "edit", "update", "delete"];
    }

    // Add the default controller if not provided
    if (!(isset($options['controller']))) {
      $options['controller'] = $resource;
    }

    // Add the default base_route if contrller_route is not set
    if (!(isset($options['controller_route']))) {
      $options['controller_route'] = self::$controller_route;
    }

    // If there are resources then set defaults on them
    if (isset($options['resources'])) {
      foreach ($options['resources'] as $res => &$opt) {
        self::setResourceDefaults($res, $opt);
      }
    }
  }

  private static function setRouteDefaults($route, &$options) {
    // Add the default controller if not provided
    if (!(isset($options['controller']))) {
      $options['controller'] = explode('/', $route)[1];
    }

    // Add the default base_route if contrller_route is not set
    if (!(isset($options['controller_route']))) {
      $options['controller_route'] = self::$controller_route;
    }
  }

  // Base route comes from nested resources
  private static function buildRoutes($base_route, $resource, $options) {
    // Build the base routes
    foreach ($options['actions'] as $action) {
      switch ($action) {
        case 'new':
          self::setRoute($base_route.'/'.$resource.'/new', "GET", $options['controller_route'], $options['controller'], "new");
          break;
        case 'create':
          self::setRoute($base_route.'/'.$resource, "POST", $options['controller_route'], $options['controller'], "create");
          break;
        case 'index':
          self::setRoute($base_route.'/'.$resource, "GET", $options['controller_route'], $options['controller'], "index");
          break;
        case 'show':
          self::setRoute($base_route.'/'.$resource."/:id", "GET", $options['controller_route'], $options['controller'], "show");
          break;
        case 'edit':
          self::setRoute($base_route.'/'.$resource.'/edit', "GET", $options['controller_route'], $options['controller'], "edit");
          break;
        case 'update':
          self::setRoute($base_route.'/'.$resource."/:id", "PUT", $options['controller_route'], $options['controller'], "update");
          break;
        case 'delete':
          self::setRoute($base_route.'/'.$resource."/:id", "DELETE", $options['controller_route'], $options['controller'], "delete");
      }
    }

    if (isset($options['resources'])) {
      foreach ($options['resources'] as $res => $opt) {
        $route = $base_route.'/'.$resource.'/:'.$resource.'_id';
        self::buildRoutes($route, $res, $opt);
      }
    }
  }

  private static function setRoute($route, $method, $controller_route, $controller, $function) {
    if (!(isset(self::$routes[$route]))) {
      self::$routes[$route] = [];
    }

    self::$routes[$route][$method] = [
      'controller' => $controller,
      'function' => $function,
      'controller_route' => $controller_route,
    ];
  }

  private static function searchRoutes($request_array, $method) {
    $match = [];

    foreach (self::$routes as $route => $methods) {
      // If method is specified check it is speified
      if (!array_key_exists($method, $methods)) {
        continue;
      }

      $details = $methods[$method];
      // Split the route into an array at "/"
      $r = trim($route, "/");
      $route_array = explode("/", $r);
      // If route lenths do not match, move on
      if (count($route_array) != count($request_array)) {
        continue;
      }

      $is_match = self::checkRoute($request_array, $route_array);
      // If a match is found populate match array and
      // break the loop
      if ($is_match['found']) {
        // Select controller and function
        $match['controller'] = $details['controller'];
        $match['function'] = $details['function'];
        $match['controller_route'] = $details['controller_route'];
        // Add params
        $match['params'] = $is_match['params'];
        break;
      }
    }

    return $match;
  }

  private static function checkRoute($request_array, $route_array) {
    $response = [
      'found' => false,
      'params' => [],
      'test' => 'test',
    ];

    foreach ($request_array as $index => $request_val) {
      // The current value is the $route_array at $index
      $route_val = $route_array[$index];
      // If string begins with : it is a variable, store in params
      if (strlen($route_val) > 0 && $route_val[0] == ':') {
        $var = substr($route_val, 1);
        $response['params'][$var] = $request_val;
      }
      // If not equal we can return
      else {
        if (strcasecmp($request_val, $route_val) != 0) {
          return $response;
        }
      }
    }
    // Made it through so match was found
    $response['found'] = true;
    return $response;
  }
}

// TO display routes as a controller
function display_routes($params, $response) {
  $html = '';

  foreach (Routes::getRoutes() as $route => $methods) {
    $html .= "<div style='padding-bottom: 20px;'>";
    $html .= "<div style='font-weight: bolder;'>".$route."</div>";
    $html .= "<table style='margin-left:20px;'>";
    foreach ($methods as $method => $obj) {
      $html .="<tr>";
      $html .="<td>".$method.'</td>';
      $html .="<td style='padding-left:15px;'>".$obj['controller_route'].'/'.$obj['controller'].' -> '.$obj['function']."</td>";
      $html .="</tr>";
    }
    $html .= "</table></div>";
  }

  echo $html;
  return;
}
?>
