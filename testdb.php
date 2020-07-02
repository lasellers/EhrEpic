<?php
/**
 * This is a simple one-file test to verify external connection with the docker db works.
 */
// sudo apt-get install php7.4-mysql
// insert into docker_entrypoint_initdb (id,created_at) values (1,'1985-01-01');
// insert into docker_entrypoint_initdb (id,created_at) values (2,'2020-01-01');
// insert into docker_entrypoint_initdb (id,created_at) values (3,'1967-01-01');
// select * from docker_entrypoint_initdb;
$servername = "localhost:3306";
$username = "ehr";
$password = "password";
$db = "ehr";

$dsn = "mysql:dbname=$db; host=$servername";

try {
// Create connection
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    );

    $conn = new PDO($dsn, $username, $password, $options);

// Check connection
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
echo "Connected successfully\n";

//
$sql = "SELECT * FROM docker_entrypoint_initdb;";
$rows = $conn->query($sql);
var_dump($rows);
if ($rows->rowCount()) {
    // output data of each row
    foreach ($rows as $row) {
        echo "id: " . $row["id"] . " - created_at: " . $row["created_at"] . "\n";
    }
} else {
    echo "0 results";
}

//
$conn = null;
?>
