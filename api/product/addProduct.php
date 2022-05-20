<?php 
  // Headers
  if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

  include_once '../../config/Database.php';
  include_once '../../models/Product.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $post = new Product($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $post->sku = $data->sku;
  $post->name = $data->name;
  $post->price = $data->price;
  $post->type = $data->type;
  $post->size = $data->size;
  $post->height = $data->height;
  $post->width = $data->width;
  $post->length = $data->length;
  $post->weight = $data->weight;

  if($post->sku === null || $post->sku === '') {
  exit();
  }

  // add member
  if($post->addProduct()) {
    echo json_encode(
      array(
        'status' => true,
        'message' => 'Successfuly added to database'
          )
    );
  } else {
    echo json_encode(
      array(
        'status' => false,
        'message' => 'error'
          )
    );
  }

