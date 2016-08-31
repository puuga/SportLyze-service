<?php
include "include/db_connect_oo.php";

include "model/football_event.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read post data
$post_data->match_id = $_POST["match_id"];
$post_data->match_player_id = $_POST["match_player_id"];
$post_data->event_id = $_POST["event_id"];
$post_data->happened_at = $_POST["happened_at"];
$post_data->layer_1 = $_POST["layer_1"];
$post_data->layer_2 = $_POST["layer_2"];

$events = addEventToPlayerInMatch($conn, $post_data);
if ( !is_null($events) ) {
  http_response_code(201);
  header('Content-Type: application/json');
  echo json_encode($events);
  $conn->close();
  exit();
}
http_response_code(500);
$conn->close();
exit();

?>
