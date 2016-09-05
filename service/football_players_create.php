<?php
include "include/db_connect_oo.php";

include "model/football_player.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read post data
$post_data->user_id = $_POST["user_id"];
$post_data->first_name = $_POST["first_name"];
$post_data->last_name = $_POST["last_name"];
$post_data->birthday = $_POST["birthday"];
$post_data->position = $_POST["position"];
$post_data->memo = $_POST["memo"];

$player = addPlayer($conn, $post_data);
if ( !is_null($player) ) {
  http_response_code(201);
  header('Content-Type: application/json');
  echo json_encode($player);
  $conn->close();
  exit();
}
http_response_code(500);
$conn->close();
exit();

?>
