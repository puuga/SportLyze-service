<?php
include "include/db_connect_oo.php";

include "model/football_team.php";
?>
<?php
$conn = connect_db($db_server, $db_username, $db_password, $db_dbname);

// read get data
$events = getFootballTeams($conn);
header('Content-Type: application/json');
echo json_encode($events);
$conn->close();
exit();

?>
