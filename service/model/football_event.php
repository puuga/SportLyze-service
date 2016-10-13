<?php
function getFootballEvents($conn): array {
  $sql = "SELECT * FROM football_events_renamed";
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

function addEventToPlayerInMatch($conn, $post_data) {
  $sql = "INSERT INTO football_match_events (
            football_match_id,
            football_match_player_id,
            football_event_id,
            happened_at,
            layer_1,
            layer_2,
            created_at, updated_at)
          VALUES (
            '$post_data->match_id',
            '$post_data->match_player_id',
            '$post_data->event_id',
            '$post_data->happened_at',
            '$post_data->layer_1',
            '$post_data->layer_2',
            NOW(), NOW())";
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    return getEventById($conn, $last_id);
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit();
  }

  return NULL;
}

function getEventById($conn, $match_event_id) {
  $sql = "SELECT * FROM football_match_events WHERE id=$match_event_id";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      return $row;
    }
  }

  return NULL;
}

function deleteEventFromPlayerInMatch($conn, $football_match_event_id) {
  $sql = "DELETE FROM football_match_events WHERE id=$football_match_event_id";
  if ($conn->query($sql) === TRUE) {
    return TRUE;
  } else {
    return FALSE;
  }
}

function getEventsOfPlayerInMatch($conn, $football_match_id, $football_match_player_id) {
  $sql = "SELECT * FROM football_match_events
          WHERE football_match_id=$football_match_id
          AND football_match_player_id=$football_match_player_id";
  $results = [];
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $results[] = $row;
    }
    return $results;
  }

  return $results;
}
?>
