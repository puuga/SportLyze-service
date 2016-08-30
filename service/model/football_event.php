<?php
function getFootballEvents($conn): array {
  $sql = "SELECT * FROM football_events";
  $resutls = [];
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $resutls[] = $row;
    }
  }

  return $resutls;
}
?>
