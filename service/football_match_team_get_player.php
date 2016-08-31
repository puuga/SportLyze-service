<?php
include "include/db_connect_oo.php";

include "model/football_match.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read get data
$match_id = $_GET["match_id"];
$team_id = $_GET["team_id"];

$players = getPlayersInTeamInMatch($conn, $match_id, $team_id);
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
