<?php
class Routes {

  /*****
  Class variables
  ******/

  // Array of routes. Will be added to by calling addResource() or addRoute()
  // Retrive by calling getRoutes()
  private static $routes = [
    '/_routes' => [
      'GET' => [
        'controller' => 'api',
        'function' => 'routes',
      ],
    ],
  ];

  // Default base route
  public static $base_route;



  /*******
  PUBLIC functions for adding and searching routes
  ********/

  // Get the routes tree
  public static function getRoutes() {
    return self::$routes;
  }

  // Add routes by adding resource options
  public static function addResource($resource, $options=[]) {
    self::_setDefaults($resource, $options);
    self::_buildRoutes("", $resource, $options);
  }

  public static function addRoute($route, $options) {
    self::_setRoute($route, $options['method'], $options['controller'], $options['function']);
  }

  public static function findRouteMatch($route, $method) {
    error_log("\nFIND? ".$route." ".$method, 4);
    $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
    $uri = trim($uri, '//');
    $request_route = explode("/", $uri);
    // print_r($request_route);
    $index = array_search('api', $request_route);

    // Get the request after the api route
    $match = self::_searchRoutes($request_route, $method);
    return $match;
  }


  /********
  * PRIVATE functions
  *********/
  private static function _setDefaults($resource, &$options) {
    // Add the default actions if not provided
    if (!(isset($options['actions']))) {
      $options['actions'] = ["create", "index", "show", "update", "delete"];
    }

    // Add the default controller if not provided
    if (!(isset($options['controller']))) {
      $options['controller'] = $resource;
    }

    // If there are resources then set defaults on them
    if (isset($options['resources'])) {
      foreach ($options['resources'] as $res => &$opt) {
        self::_setDefaults($res, $opt);
      }
    }
  }

  private static function _buildRoutes($base_route, $resource, $options) {
    // Build the base routes
    foreach ($options['actions'] as $action) {
      switch ($action) {
        case 'create':
          self::_setRoute($base_route.'/'.$resource, "POST", $options['controller'], "create");
          break;
        case 'index':
          self::_setRoute($base_route.'/'.$resource, "GET", $options['controller'], "index");
          break;
        case 'show':
          self::_setRoute($base_route.'/'.$resource."/:id", "GET", $options['controller'], "show");
          break;
        case 'update':
          self::_setRoute($base_route.'/'.$resource."/:id", "PUT", $options['controller'], "update");
          break;
        case 'delete':
          self::_setRoute($base_route.'/'.$resource."/:id", "DELETE", $options['controller'], "delete");
      }
    }

    if (isset($options['resources'])) {
      foreach ($options['resources'] as $res => $opt) {
        $route = $base_route.'/'.$resource.'/:'.$resource.'_id';
        self::_buildRoutes($route, $res, $opt);
      }
    }
  }

  private static function _setRoute($route, $method, $controller, $function) {
    if (!(isset(self::$routes[$route]))) {
      self::$routes[$route] = [];
    }

    self::$routes[$route][$method] = [
      'controller' => $controller,
      'function' => $function,
    ];
  }

  private static function _searchRoutes($request_array, $method) {
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
?>
