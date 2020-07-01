<?php
// sudo apt-get install php7.4-mysql
// insert into foo (id,name) values (1,'test');
// insert into foo (id,name) values (2,'lorem');
// select * from foo;
$servername = "localhost:3307";
$username = "admin";
$password = "password";
$db="ehr";

$dsn = "mysql:dbname=$db; host=$servername";

try {
// Create connection
$options  = array(PDO::ATTR_ERRMODE =>      PDO::ERRMODE_EXCEPTION,
                 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
);

$conn = new PDO($dsn, $username, $password, $options);

// Check connection
} catch (PDOException $e) {
   die("Connection failed: " . $e->getMessage());
}
echo "Connected successfully\n";

//
$sql = "SELECT * FROM foo;";
$rows = $conn->query($sql);
var_dump($rows);
if ($rows->rowCount()) {
   // output data of each row
   foreach ($rows as $row) {
       echo "id: " . $row["id"]. " - Name: " . $row["name"]. "\n";
   }
} else {
   echo "0 results";
}

//
$conn = null;
?>
