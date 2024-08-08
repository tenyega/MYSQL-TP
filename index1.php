<?php

$server = 'localhost';
$user = 'root';
$pwd = 'root';
$db = 'tp_mysql';
$port = 8800;
$connection = mysqli_connect($server, $user, $pwd, $db, $port);
if (!$connection) {
    die('problem wih the connection' . mysqli_connect_error());
} else {
    echo "connection successful";
}

$sql = "SELECT title, content, tags, slug, duration FROM posts ;";

$results = mysqli_query($connection, $sql);
if (mysqli_num_rows($results) > 0) {
    while ($row = mysqli_fetch_assoc($results)) {
        echo "<br>Title : " . $row["title"] . "<br> Content : " . $row["content"] . "<br>";
    }
} else {
    echo "no results found";
}
