<?php
require_once "credentials.php";

// Create connection
$conn = mysqli_connect($servername, $username, $password);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

 
// Attempt create table query execution
$sql = "CREATE TABLE users (
    id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    username varchar(255) NOT NULL,
    email varchar(255) NOT NULL,
    role enum('Author','Admin') DEFAULT NULL,
    password varchar(255) NOT NULL,
    created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp NULL DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1";


if (mysqli_query($conn, $sql)) {
    echo "Table users created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);

}

$sql = "CREATE TABLE posts (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id int(11) DEFAULT NULL,
    title varchar(255) NOT NULL,
    slug varchar(255) NOT NULL UNIQUE,
    views int(11) NOT NULL DEFAULT '0',
    image varchar(255) NOT NULL,
    body text NOT NULL,
    published tinyint(1) NOT NULL,
    created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_at timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
     FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
   ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

if (mysqli_query($conn, $sql)) {
    echo "Table posts created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);

}

$sql = "CREATE TABLE post_topics (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    post_id int(11) DEFAULT NULL UNIQUE,
    topic_id int(11) DEFAULT NULL,
    FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

    if (mysqli_query($conn, $sql)) {
        echo "Table post_topics created successfully";
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    
    }

$sql = "CREATE TABLE topics (
    id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(255) NOT NULL,
    slug varchar(255) NOT NULL UNIQUE
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1";

if (mysqli_query($conn, $sql)) {
    echo "Table topics created successfully";
} else {
    echo "Error creating table: " . mysqli_error($conn);

}

mysqli_close($conn);
?>

 

