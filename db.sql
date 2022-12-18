/*creating a table in the database*/

CREATE TABLE
    object_detector (
        id int(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        sensor_name varchar(30) not null,
        value varchar(10),
        reading_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );