<?php
// Response provides quick functions to send request responses
class Response {

  public function sendJSON($data) {
    self::sendJSONwithStatus($data, 200);
  }

  public function sendJSONwithStatus($data, $status) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
  }
}
?>
