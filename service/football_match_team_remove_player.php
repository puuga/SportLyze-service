<?php
include "include/db_connect_oo.php";

include "model/football_match.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read post data
$post_data->match_id = $_POST["match_id"];
$post_data->team_id = $_POST["team_id"];
$post_data->player_id = $_POST["player_id"];
$post_data->user_id = $_POST["user_id"];

$players = removePlayerFromTeamInMatch($conn, $post_data);
if ( !is_null($players) ) {
  header('Content-Type: application/json');
  echo json_encode($players);
  $conn->close();
  exit();
}
http_response_code(500);
$conn->close();
exit();

?>
