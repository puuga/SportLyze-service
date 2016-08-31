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

function deleteMatch($conn, $match_id) {
  $sql = "DELETE FROM football_matchs WHERE id=$match_id";
  if ($conn->query($sql) === TRUE) {
    return TRUE;
  } else {
    return FALSE;
  }
}

function addPlayerToTeamInMatch($conn, $post_data) {
  $sql = "INSERT INTO football_match_players (
            football_match_id,
            football_team_id,
            football_player_id,
            created_by_user,
            created_at, updated_at)
          VALUES (
            '$post_data->match_id',
            '$post_data->team_id',
            '$post_data->player_id',
            '$post_data->user_id',
            NOW(), NOW())";
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    $players = getPlayersInTeamInMatch($conn, $post_data->match_id, $post_data->team_id);
    return $players;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit();
  }
  return NULL;
}

function getPlayersInTeamInMatch($conn, $match_id, $team_id) {
  $sql = "SELECT
              fp.*
          FROM
              football_match_players fmp
                  INNER JOIN
              football_players fp ON fmp.football_player_id = fp.id
          WHERE fmp.football_match_id = 4";
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

function removePlayerFromTeamInMatch($conn, $post_data) {
  $sql = "DELETE FROM football_match_players WHERE
              football_match_id=$post_data->match_id
              AND football_team_id=$post_data->team_id
              AND football_player_id=$post_data->player_id
              AND created_by_user=$post_data->user_id ";
  $players = [];
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    $players = getPlayersInTeamInMatch($conn, $post_data->match_id, $post_data->team_id);
    return $players;
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit();
  }
  return $players;
}
?>
