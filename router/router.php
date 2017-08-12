<?php
require(dirname(__FILE__).'/../config/routes.php');
require_once(dirname(__FILE__).'/response.php');

$standard_methods = [
  "POST" => "create",
  "GET" => "index",
  "PUT" => "update",
  "DELETE" => "delete",
];
$method = $_SERVER["REQUEST_METHOD"];
$uri = explode('?', $_SERVER['REQUEST_URI'])[0];
$uri = trim($uri, '//');
$request_route = explode("/", $uri);
$index = array_search('api', $request_route);

// Get the request after the api route
$request_array = array_slice($request_route, $index+1);

// A match array will have a controller and function keys
// Possibly will contain params key
// No match will be empty array
$match = Routes::findRouteMatch($_SERVER['REQUEST_URI'], $method);
$response = new Response();

if (count($match) == 0) {
  error_log("\n\tResponse 404: ".$_SERVER['REQUEST_URI'], 4);
  $response->sendJSONwithStatus(['error' => "Route not found"], 404);
}
else {
  // error_log("\n\tMatch: ".$match['controller'].'.'.$match['function'], 4);
  // If there are params in the body of the request, get those and merge
  // This will be true for a post request
  $body_params = json_decode(file_get_contents('php://input'), true);
  if (!$body_params) {
    $merged_params = $_GET;
  }
  else {
    $merged_params = array_merge($_GET, $body_params);
  }
  require(dirname(__FILE__).'/../api/controllers/'.$match['controller'].".php");
  call_user_func($match['function'],
                array_merge($merged_params, $match['params']),
                $response);
}

?>
