<?php
include "include/db_connect_oo.php";

include "model/football_match.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read post data
$post_data->user_id = $_POST["user_id"];
$post_data->home_id = $_POST["home_id"];
$post_data->away_id = $_POST["away_id"];

$match = addMatch($conn, $post_data);
if ( !is_null($match) ) {
  http_response_code(201);
  header('Content-Type: application/json');
  echo json_encode($match);
  $conn->close();
  exit();
}
http_response_code(500);
$conn->close();
exit();

?>
