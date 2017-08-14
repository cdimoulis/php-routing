<?php
// _routing.php
require_once(dirname(__FILE__).'/config/routes.php');
require_once(dirname(__FILE__).'/config/router.php');
require_once(dirname(__FILE__).'/bin/router.php');
// print_r((Routes::getRoutes()));

return Router::handleRequest();
?>
