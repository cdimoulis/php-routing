<?php
// Response provides quick functions to send request responses
class Response {

  // Send the $data as JSON as success
  public function sendJSON($data) {
    self::sendJSONwithStatus($data, 200);
  }

  // Send the $data as JSON with specific $status
  public function sendJSONwithStatus($data, $status) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
  }

  // Render php file at $view with $data available on page
  public function sendView($view, $data) {
    if (file_exists(dirname(__FILE__).'/..'.$view)) {
      require_once(dirname(__FILE__).'/..'.$view);
    }
  }
}
?>
