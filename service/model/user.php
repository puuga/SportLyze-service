<?php
function getUserWithFirebase($conn, $firebase_id) {
  $sql = "SELECT * FROM users WHERE firebase_id='$firebase_id'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      return $row;
    }
  }

  return NULL;
}

function getUserWithId($conn, $id) {
  $sql = "SELECT * FROM users WHERE id='$id'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      return $row;
    }
  }

  return NULL;
}

function addUser($conn, $firebase_id, $name) {
  $sql = "INSERT INTO users (firebase_id, name, user_type_id, created_at, updated_at)
          VALUES ('$firebase_id', '$name', 1, NOW(), NOW())";
  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    return getUserWithId($conn, $last_id);
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    exit();
  }

  return NULL;
}
?>
