<?php
require(dirname(__FILE__).'/../bin/router.php');
/****************
Configure the router settings
*****************/

/*
$full_routing determines whether all requsted routes should exist in the
config/route.php file. If true a 404 will be given upon no match with the
routes. If false then requests will be allwed to proceed per usual PHP behavior
Default: false
*/
// Router::$full_routing = true;

/*
$view_routes is the route which will show all
Default: '/_routes'
*/
// Router::$view_routes = '/_routes';


?>
