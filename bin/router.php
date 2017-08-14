<?php
require_once(dirname(__FILE__).'/../config/routes.php');
require_once(dirname(__FILE__).'/routes.php');
require_once(dirname(__FILE__).'/response.php');
/*********
Router will handle each request and determine whether to send th request to a
'controller', throw a 404, or let the request proced to the directory per PHP's
usual behavior.
**********/
class Router {

  /********
  Class variables that should be set in config/router.php
  *********/
  public static $full_routing = false;

  // public static $page_404 = "404.php";


  /*
  * Private class variables
  */
  private static $standard_methods = [
    "POST" => "create",
    "GET" => "index",
    "PUT" => "update",
    "PATCH" => "update",
    "DELETE" => "delete",
  ];



  /********
  Handle all incoming requests
  *********/
  public static function handleRequest() {
    $match = Routes::findRouteMatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

    if (count($match) == 0) {
      return self::handleNoMatch();
    }
    else {
      return self::handleMatch($match);
    }
  }

  /*******
  Handle requests that match a route
  ********/
  private static function handleMatch($match) {
    $response = new Response();
    $body_params = json_decode(file_get_contents('php://input'), true);
    if (!$body_params) {
      $merged_params = $_GET;
    }
    else {
      $merged_params = array_merge($_GET, $body_params);
    }
    require_once(dirname(__FILE__).'/../'.$match['controller_route'].'/'.$match['controller'].".php");
    call_user_func($match['function'],
                  array_merge($merged_params, $match['params']),
                  $response);
  }

  /*******
  Handle requests that do not have a match
  ********/
  private static function handleNoMatch() {
    $response = new Response();
    if (self::$full_routing) {
      $response->sendJSONwithStatus(['error' => "Route not found"], 404);
    }
    else {
      return false;
    }
  }
}
?>