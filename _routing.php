<?php
require(dirname(__FILE__).'/config/routes.php');
print_r(array_keys(Routes::getRoutes()));
// routing.php
// $message = "\nROUTER: Request Uri:  ".$_SERVER["REQUEST_URI"]."\n";
// error_log($message,4);
// error_log(preg_match('/^\/*/',$_SERVER["REQUEST_URI"]),4);
// if (preg_match('/^\/*/',$_SERVER["REQUEST_URI"])) {
//     include __DIR__ . '/router/router.php';
// } else {
//     return false;
// }
?>
