<?php
include "include/db_connect_oo.php";

include "model/football_match.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read get data
$match_id = $_GET["match_id"];

$result = deleteMatch($conn, $match_id);
if ( $result ) {
  http_response_code(204);
  header('Content-Type: application/json');
  echo json_encode($match);
  $conn->close();
  exit();
}
http_response_code(500);
$conn->close();
exit();

?>
