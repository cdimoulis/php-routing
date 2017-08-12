<?php
class Response {

  public function sendJSON($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
  }

  public function sendJSONwithStatus($data, $status) {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
  }
}
?>
