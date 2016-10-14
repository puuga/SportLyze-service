<?php
include "include/db_connect_oo.php";

?>
<?php
function getVideoStatsIntervalFromMySQL($conn, $video_id) {
  $sql = "SELECT MAX(created_at) time_end, MIN(created_at) time_start
          FROM analytic_video_stats
          WHERE video_id=$video_id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $resutls[] = $row;
      $mysql_result = [
        "video_id" => $video_id,
        "time_start" => $row["time_start"],
        "time_end" => $row["time_end"]
      ];
    }

    return $mysql_result;
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

  $mysql_result = getVideoStatsIntervalFromMySQL($conn, $video_id);
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
