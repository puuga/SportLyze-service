<?php
include "include/db_connect_oo.php";

include "model/football_match.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read get data
$user_id = $_GET["user_id"];
$events = getFootballMatchsByCreaterId($conn, $user_id);
header('Content-Type: application/json');
echo json_encode($events);
$conn->close();
exit();

?>
