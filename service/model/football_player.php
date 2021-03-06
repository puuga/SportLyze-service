<?php
function getFootballPlayersByCreaterId($conn, $id): array {
  $sql = "SELECT * FROM football_players_with_age_position WHERE created_by_user=$id";
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

function getFootballPlayerById($conn, $id) {
  $sql = "SELECT * FROM football_players_with_age_position WHERE id=$id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      return $row;
    }
  }

  return NULL;
}

function addPlayer($conn, $post_data) {
  $sql = "INSERT INTO football_players (
            created_by_user,
            first_name,
            last_name,
            position,
            memo,
            birthday,
            created_at, updated_at)
          VALUES (
            '$post_data->user_id',
            '$post_data->first_name',
            '$post_data->last_name',
            '$post_data->position',
            '$post_data->memo',
            '$post_data->birthday',
            NOW(), NOW())";
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    return getFootballPlayerById($conn, $last_id);
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit();
  }

  return NULL;
}
?>
