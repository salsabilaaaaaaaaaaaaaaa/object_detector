<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="refresh" content="2">
  <link rel="stylesheet" type="text/css" href="style.css" media="screen" />

  <title> Sensor Data </title>

</head>

<body>

  <h1>SENSOR DATA</h1>
  <?php
  $servername = "localhost";
  $username = "set";
  $password = "admin_set";
  $dbname = "db_object_detector";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT * FROM object_detector ORDER BY id DESC"; /*select items to display from the sensordata table in the data base*/

  echo '<table cellspacing="5" cellpadding="5">
      <tr> 
        <th>ID</th> 
        <th>Date | Time</th> 
        <th>Sensor</thh> 
        <th>Value</th>      
      </tr>';

  if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
      $row_id = $row["id"];
      $row_reading_time = $row["reading_time"];
      $row_sensor = $row["sensor_name"];
      $row_value1 = $row["value"];
      if ($row_value1 < 60) {
        $row_value1 = "Object Detected";
      } else {
        $row_value1 = "No Object Detected";
      }

      // Uncomment to set timezone to - 1 hour (you can change 1 to any number)
      // $row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time - 1 hours"));

      // Uncomment to set timezone to + 4 hours (you can change 4 to any number)
      //$row_reading_time = date("Y-m-d H:i:s", strtotime("$row_reading_time + 4 hours"));

      echo '<tr> 
                <td>' . $row_id . '</td> 
                <td>' . $row_reading_time . '</td> 
                <td>' . $row_sensor . '</td>  
                <td>' . $row_value1 . '</td>
                
              </tr>';
    }
    $result->free();
  }

  $conn->close();
  ?>
  </table>

</body>

</html>

</body>

</html>