<?php
require_once "../config.php";

$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

$result = $conn->query("select * from item");
while ($row = $result->fetch_assoc()) {
    print_r($row);
}
$result->free();

echo "done";

