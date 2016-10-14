<?php
include "include/db_connect_oo.php";

?>
<?php
function addVideoStatsToMySQL($conn, $sql) {
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    return true;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    return false;
  }
}
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read raw data
// Get POST body content
$inputJSON = file_get_contents('php://input');
// Parse JSON
$video_stats = json_decode($inputJSON, TRUE);

if (isset($video_stats)) {
  $sql = "INSERT INTO analytic_video_stats
          (video_id, video_source, match_id, match_name,
            team_id, team_name, x, y,
            color, number, time_stamp, raw,
            created_at, updated_at)
          VALUES ";
  foreach ($video_stats['video_stats'] as $video_stat) {
    $video_id = $video_stat['video_id'];
    $video_source = $video_stat['video_source'];
    $match_id = $video_stat['match_id'];
    $match_name = $video_stat['match_name'];
    $team_id = $video_stat['team_id'];
    $team_name = $video_stat['team_name'];
    $x = $video_stat['x'];
    $y = $video_stat['y'];
    $color = $video_stat['color'];
    $number = $video_stat['number'];
    $time_stamp = $video_stat['time_stamp'];
    $raw = json_encode($video_stat);
    $sql .= "('$video_id','$video_source','$match_id','$match_name',
            '$team_id','$team_name','$x','$y',
            '$color','$number','$time_stamp','$raw',
            NOW(),NOW()),";
  }
  $sql = rtrim($sql, ",");

  $mysql_result = addVideoStatsToMySQL($conn, $sql);
  if ( $mysql_result ) {
    http_response_code(201);
    header('Content-Type: application/json');
    $conn->close();
    exit();
  }
  http_response_code(500);
  $conn->close();
  exit();
}
http_response_code(500);
$conn->close();
exit();
?>
