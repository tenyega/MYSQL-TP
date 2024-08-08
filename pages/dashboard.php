<?php

// Check if the session variable exists
if (isset($_SESSION['name'])) {
    $name = $_SESSION['name'];
    echo "<h1 class='header'>welcome<br> Mr/Mme :-" . $name . "</h1>";
}

try {
    // Store the form values in session variables

    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
    if (!$connection) {
        die('problem wih the connection' . mysqli_connect_error());
    }
    if (isset($_SESSION['name'])) {


        $sql = "SELECT posts.img, posts.title,posts.content,posts.date_publication FROM posts JOIN users ON users.id= user_id WHERE users.nom='" .  $_SESSION['name'] . "' ORDER BY date_publication DESC;";
        $sql2 = "SELECT posts.img, posts.title,posts.content,posts.date_publication FROM posts JOIN users ON users.id= user_id WHERE users.nom!='" .  $_SESSION['name'] . "' ORDER BY date_publication DESC;";


        $results = mysqli_query($connection, $sql);
        $otherResults =  mysqli_query($connection, $sql2);
        echo '<div class="cardContainer">';
        if (mysqli_num_rows($results) > 0) {

            // Assuming $results is the result of a query execution
            while ($rows = mysqli_fetch_assoc($results)) {
                // Display the posts for the user
                echo '
            <div class="card">
                <img src="' . htmlspecialchars($rows["img"]) . '" alt="Image" class="card-img">
                <div class="card-body">
                    <h2 class="card-title">' . htmlspecialchars($rows["title"]) . '</h2>
                    <p class="card-content">' . htmlspecialchars($rows["content"]) . '</p>
                     <p class="card-content">' . htmlspecialchars($rows["date_publication"]) . '</p>

                </div>
            </div>';
            }
        }
        if (mysqli_num_rows($otherResults) > 0) {
            echo '<br> <h1 class="header"> OTHER POPULAR POSTS </h1>';
            // Assuming $results is the result of a query execution
            while ($otherRows = mysqli_fetch_assoc($otherResults)) {
                echo '
            <div class="card">
                <img src="' . htmlspecialchars($otherRows["img"]) . '" alt="Image" class="card-img">
                <div class="card-body">
                    <h2 class="card-title">' . htmlspecialchars($otherRows["title"]) . '</h2>
                    <p class="card-content">' . htmlspecialchars($otherRows["content"]) . '</p>
                    <p class="card-content">' . htmlspecialchars($otherRows["date_publication"]) . '</p>

                </div>
            </div>';
            }
            echo '</div>';
        }
        echo "</div>";
    } else {
        echo "<h2 class='header'>PLEASE LOG IN</h2>";
        header("Location:index.php?pg=login");
    }
} catch (Exception $e) {
    echo "Une erreur est survenue dans le fischer :  " . $e->getFile() . "<br>";
    echo "a la ligne  :  " . $e->getLine() . "<br>";
    echo "and the error message is  :  " . $e->getMessage() . "<br>";
}
