<?php
include "include/db_connect_oo.php";

include "model/user.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read get data
// firebase_id
if( isset($_GET["firebase_id"]) ) {
  $firebase_id = $_GET["firebase_id"];
  $user = getUserWithFirebase($conn, $firebase_id);
  if ( !is_null($user) ) {
    header('Content-Type: application/json');
    echo json_encode($user);
    $conn->close();
    exit();
  }
}

// id
if( isset($_GET["id"]) ) {
  $id = $_GET["id"];
  $user = getUserWithId($conn, $id);
  if ( !is_null($user) ) {
    header('Content-Type: application/json');
    echo json_encode($user);
    $conn->close();
    exit();
  }
}

http_response_code(204);
$conn->close();
exit();

?>
