<?php
include "include/db_connect_oo.php";

?>
<?php
function getVideoStatsFromMySQL($conn, $video_id, $time_start, $time_end) {
  $sql = "SELECT *
          FROM analytic_video_stats
          WHERE video_id=$video_id AND created_at BETWEEN '$time_start' AND '$time_end'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $resutls[] = $row;
    }
    return $resutls;
  } else {
    return [];
  }
}
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read raw data
// Get param
if (isset($_GET["video_id"])) {
  $video_id = $_GET["video_id"];
  $time_start = $_GET["time_start"];
  $time_end = $_GET["time_end"];

  $mysql_result = getVideoStatsFromMySQL($conn, $video_id, $time_start, $time_end);
  if ( isset($mysql_result) ) {
    http_response_code(201);
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    echo json_encode($mysql_result);
    $conn->close();
    exit();
  }
  header("Access-Control-Allow-Origin: *");
  http_response_code(500);
  $conn->close();
  exit();
}
header("Access-Control-Allow-Origin: *");
http_response_code(500);
$conn->close();
exit();
?>
