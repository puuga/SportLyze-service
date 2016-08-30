<?php
include "include/db_connect_oo.php";

include "model/user.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read post data
$post_data->firebase_id = $_POST["firebase_id"];
$post_data->name = $_POST["name"];

// 1. check if firebase_id exist then return user data
$user = getUserWithFirebase($conn, $post_data->firebase_id);
if ( !is_null($user) ) {
  header('Content-Type: application/json');
  echo json_encode($user);
  $conn->close();
  exit();
} else {
  // 2. if firebase_id non exist then insert firebase_id and name then return user data
  $user = addUser($conn, $post_data->firebase_id, $post_data->name);
  if ( !is_null($user) ) {
    http_response_code(201);
    header('Content-Type: application/json');
    echo json_encode($user);
    $conn->close();
    exit();
  } else {
    http_response_code(500);
    $conn->close();
    exit();
  }
}




?>
