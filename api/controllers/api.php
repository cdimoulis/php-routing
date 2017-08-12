<?php
require_once(dirname(__FILE__).'/../../config/routes.php');

# Display the all the routable routes in the system
function routes($params, $response) {
  $html = '';

  foreach (Routes::getRoutes() as $route => $methods) {
    $html .= "<div style='padding-bottom: 20px;'>";
    $html .= "<div style='font-weight: bolder;'>".$route."</div>";
    $html .= "<table style='margin-left:20px;'>";
    foreach ($methods as $method => $obj) {
      $html .="<tr>";
      $html .="<td>".$method.'</td>';
      $html .="<td style='padding-left:15px;'>".$obj['controller'].' -> '.$obj['function']."</td>";
      $html .="</tr>";
    }
    $html .= "</table></div>";
  }

  echo $html;
}
?>
