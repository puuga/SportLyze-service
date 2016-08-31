<?php
include "include/db_connect_oo.php";

include "model/football_event.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read post data
$football_match_event_id = $_GET["football_match_event_id"];

$result = deleteEventFromPlayerInMatch($conn, $football_match_event_id);
if ( $result ) {
  http_response_code(204);
  header('Content-Type: application/json');
  $conn->close();
  exit();
}
http_response_code(500);
$conn->close();
exit();

?>
