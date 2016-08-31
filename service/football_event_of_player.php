<?php
include "include/db_connect_oo.php";

include "model/football_event.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read post data
$football_match_id = $_GET["football_match_id"];
$football_match_player_id = $_GET["football_match_player_id"];

$events = getEventsOfPlayerInMatch($conn, $football_match_id, $football_match_player_id);
if ( !is_null($events) ) {
  header('Content-Type: application/json');
  echo json_encode($events);
  $conn->close();
  exit();
}
http_response_code(500);
$conn->close();
exit();

?>
