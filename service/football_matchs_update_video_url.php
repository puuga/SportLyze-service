<?php
include "include/db_connect_oo.php";

include "model/football_match.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read post data
$post_data->match_id = $_POST["match_id"];
$post_data->video_url = $_POST["video_url"];

$match = updateVideo($conn, $post_data);
if ( !is_null($match) ) {
  http_response_code(200);
  header('Content-Type: application/json');
  echo json_encode($match);
  $conn->close();
  exit();
}
http_response_code(500);
$conn->close();
exit();

?>
