<?php

/******
* BASIC CRUD OPERATIONS
*******/
function create($params, $response) {

}

function index($params, $response) {
  $records = [
    ["id" => 1, "name" => "example 1"],
    ["id" => 2, "name" => "example 2"],
    ["id" => 3, "name" => "example 3"],
  ];

  $response->sendJSON($records);
}

function show($params, $response) {
  if (!array_key_exists('id',$params)) {
    // Return an error
  }
  else {
    $id = $params['id'];
    // Return the data
    $record = ["id" => $id, "name" => "example ".$id];
    $response->sendJSON($record);
  }
}

function update($params, $response) {

}

function delete($params, $response) {

}
/*****
* END BASIC CRUD OPS
******/

// return view
function example_view($params, $response) {
  $data = [
    "title" => "My Examples",
    "description" => "A php rendered page",
    "records" => [
      ["id" => 1, "name" => "example 1"],
      ["id" => 2, "name" => "example 2"],
      ["id" => 3, "name" => "example 3"],
    ]
  ];

  $response->sendView('/pages/example/index.php', $data);
}

?>
