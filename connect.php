<?php /* 
define('USER',"root");
define('PASSWD', ""); 
define('SERVER',"localhost"); 
define('BASE',"concours"); */?> 
<?php
// Database connection parameters
$host = 'localhost'; // Change this to your MySQL host
$dbname = 'concours'; // Change this to your database name
$username = 'root'; // Change this to your MySQL username
$password = ''; // Change this to your MySQL password

// Attempt database connection
try {
    $dsn = "mysql:host=$host;dbname=$dbname";
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected to the database successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>