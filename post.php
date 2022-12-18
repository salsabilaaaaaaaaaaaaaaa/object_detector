<?php
$server_name = "localhost";
$username = "set";              // ganti username kalian (ada di vid)
$password = "admin_set";        // ganti password kalian (ada di vid)
$dbname = "db_object_detector"; // ganti nama db kalian (ada di vid)

$api_key_value = "APIKEY";

$api_key = "APIKEY";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $api_key = test_input($_POST["api_key"]);
    if ($api_key == $api_key_value) {
        $sensor_name = test_input($_POST["sensor_name"]);
        $value = test_input($_POST["value"]);

        echo "sensor_name: " . $sensor_name . "<br>";
        echo "value: " . $value . "<br>";


        // check if sensor_name exists
        $conn = new mysqli($server_name, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM object_detector WHERE sensor_name = '$sensor_name'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // update
            $sql = "UPDATE object_detector SET value = '$value' WHERE sensor_name = '$sensor_name'";
            if ($conn->query($sql) == TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            // insert
            $sql = "INSERT INTO object_detector (sensor_name, value) VALUES ('$sensor_name', '$value')";
            if ($conn->query($sql) == TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        $conn->close();
    }
} else {
    echo "Error: Invalid API Key";
}


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
