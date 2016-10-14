<?php
include "include/db_connect_oo.php";

?>
<?php
function getVideoStatsFromMySQL($conn, $video_id) {
  $sql = "SELECT *
          FROM analytic_video_stats
          WHERE video_id=$video_id";
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

  $mysql_result = getVideoStatsFromMySQL($conn, $video_id);
  if ( isset($mysql_result) ) {
    http_response_code(201);
    header('Content-Type: application/json');
    echo json_encode($mysql_result);
    $conn->close();
    exit();
  }
  echo json_encode("sql");
  http_response_code(500);
  $conn->close();
  exit();
}
echo json_encode("param");
http_response_code(500);
$conn->close();
exit();
?>
