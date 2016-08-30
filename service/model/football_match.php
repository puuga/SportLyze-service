<?php
function getFootballMatchsByCreaterId($conn, $id): array {
  $sql = "SELECT
              fm.*, ft1.name home_name, ft2.name away_name
          FROM
              football_matchs fm
                  INNER JOIN
              football_teams ft1 ON fm.home_id = ft1.id
                  INNER JOIN
              football_teams ft2 ON fm.away_id = ft2.id
          WHERE created_by_user=$id";
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

function getFootballMatchById($conn, $id) {
  $sql = "SELECT
              fm.*, ft1.name home_name, ft2.name away_name
          FROM
              football_matchs fm
                  INNER JOIN
              football_teams ft1 ON fm.home_id = ft1.id
                  INNER JOIN
              football_teams ft2 ON fm.away_id = ft2.id
          WHERE fm.id=$id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      return $row;
    }
  }

  return NULL;
}

function addMatch($conn, $post_data) {
  $sql = "INSERT INTO football_matchs (
            home_id,
            away_id,
            created_by_user,
            video_url,
            created_at, updated_at)
          VALUES (
            '$post_data->home_id',
            '$post_data->away_id',
            '$post_data->user_id',
            '',
            NOW(), NOW())";
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    return getFootballMatchById($conn, $last_id);
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit();
  }

  return NULL;
}

function updateVideo($conn, $post_data) {
  $sql = "UPDATE football_matchs
          SET video_url = '$post_data->video_url'
          WHERE id = $post_data->match_id";
  if ($conn->query($sql) === TRUE) {
    return getFootballMatchById($conn, $post_data->match_id);
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit();
  }

}
?>
