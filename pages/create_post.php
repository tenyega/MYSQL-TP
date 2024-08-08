<?php
if (isset($_SESSION['name'])) {
    try {
        if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['title']) && isset($_POST['content'])) {
            // Store the form values in session variables
            $_SESSION['img'] = htmlspecialchars($_POST['img']);
            $_SESSION['title'] = htmlspecialchars($_POST['title']);
            $_SESSION['content'] = htmlspecialchars($_POST['content']);
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';port=' . DB_PORT . ';';
            $connexionPDO = new PDO($dsn, DB_USER, DB_PASSWORD);

            $connexionPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $userFound = "SELECT id from users WHERE nom='" . $_SESSION['name'] . "';";
            $userquery = $connexionPDO->query($userFound);
            if ($userquery->rowCount() > 0) {
                $userId = $userquery->fetch(PDO::FETCH_OBJ);

                //fetch is used to check the result data
            } else {
                echo "database is empty";
            }
            $sql = "INSERT INTO posts (img,title, user_id, content) VALUES (:img,:title,:userid,:content);";


            $stmt = $connexionPDO->prepare($sql);
            $img =  $_SESSION['img'] ?? '';
            $stmt->bindParam(':img', $img, PDO::PARAM_STR);
            $stmt->bindParam(':title',  $_SESSION['title'], PDO::PARAM_STR);
            $stmt->bindParam(':userid', $userId->id, PDO::PARAM_STR);
            $stmt->bindParam(':content',  $_SESSION['content'], PDO::PARAM_STR);


            if ($stmt->execute()) {
                echo "<h2 class='header>Data saved successfully</h2>";
            } else {
                echo "<h2 class='error'>Login details not found</h2> ";
            }
            if (!$connexionPDO) {
                die('<h2 class ="error">problem wih the connection' .  $stmt->errorInfo()[2] . '</h2>');
            }
        }
        $connexionPDO = null;
    } catch (Exception $e) {

        echo "<h2 class='error'>" . $e->getMessage() . "</h2><br>";
    }
} else {
    echo "<h2 class='header'>PLEASE LOG IN</h2>";
    header("Location:index.php?pg=login");
}
?>



<div class="form-container">
    <form method="post" action="">
        <div class="form-group">
            <label for="img">Image URL:</label>
            <input type="text" id="img" name="img" placeholder="Enter the image URL">
        </div>

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" placeholder="Enter the title" oninput="validateTitle()">
            <span id="titleMsg" class="error"></span><br><br>

        </div>

        <div class="form-group">
            <label for="content">Content:</label>
            <textarea id="content" name="content" placeholder="Enter the content"></textarea oninput="validateContent()">
            <span id="contentMsg" class="error"></span><br><br>
        </div>

        <div class="form-group">
            <input type="submit" value="Submit">
        </div>
    </form>
</div>

<script>
    // Function to validate name
    function validateContent() {
        const content = document.getElementById('content'); // Password input field
        const contentMsg = document.getElementById('contentMsg'); // Error message element
        const contentValue = content.value.trim(); // Trimmed confirm password value

        if (contentValue === '') {
            contentMsg.textContent = 'Content is required';
            content.classList.add('error');
        } 
    }
    function validateTitle() {
    const title = document.getElementById('title'); // Password input field
    const titleMsg = document.getElementById('titleMsg'); // Error message element
    const titleValue = title.value.trim(); // Trimmed confirm password value

        if (titleValue === '') {
            titleMsg.textContent = 'Title is required';
            title.classList.add('error');
        } 
    }
</script>