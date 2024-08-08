<?php
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Store the form values in session variables
        $_SESSION['user'] = htmlspecialchars($_POST['user']);
        $_SESSION['email'] = htmlspecialchars($_POST['email']);
        $_SESSION['pwd'] = htmlspecialchars($_POST['pwd']);
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';port=' . DB_PORT . ';';
        $connexionPDO = new PDO($dsn, DB_USER, DB_PASSWORD);

        $connexionPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $emailsql = "SELECT * FROM users WHERE email='" . $_SESSION['email'] . "';";
        $emailquery = $connexionPDO->query($emailsql);
        $emailfound = $emailquery->fetch(PDO::FETCH_OBJ);
        if (isset($emailfound->email)) {
            echo "<h2 class='error'>email already in use</h2> ";
            echo "<script>window.onload = function() { document.getElementById('myForm').reset(); };</script>";
        }
        $usersql = "SELECT * FROM users WHERE nom='" . $_SESSION['user'] . "';";
        $userquery = $connexionPDO->query($usersql);
        $userfound = $userquery->fetch(PDO::FETCH_OBJ);

        if (isset($userfound->nom)) {
            echo "<h2 class='error'>user name already in use</h2> ";
            echo "<script>window.onload = function() { document.getElementById('myForm').reset(); };</script>";
        }
        $sql = "INSERT INTO users (nom, email, pwd) VALUES (:pseudo,:mail,:password);";
        $stmt = $connexionPDO->prepare($sql);

        $stmt->bindParam(':pseudo', $_SESSION['user'], PDO::PARAM_STR);
        $stmt->bindParam(':mail',  $_SESSION['email'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $_SESSION['pwd'], PDO::PARAM_STR);


        if ($stmt->execute()) {
            echo "<h2 class='valid center'>Data saved successfully</h2>";
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

?>

<div class="container">
    <form action="" class='form' method="POST">

        <p>
            <label for="user">User:</label>
            <input type="text" id="user" name="user">
        </p>
        <p>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email">
        </p>
        <p>
            <label for="pwd">Password:</label>
            <input type="password" id="pwd" name="pwd">
        </p>
        <p>
            <label for="confirmPwd">Confirmation Password:</label>
            <input type="password" id="confirmPwd" name="confirmPwd" oninput="confirmSamePwd()">
            <span id="confirmPwdError" class="error"></span><br><br>
        </p>
        <input type="submit" name="submit" value="Envoyer">


    </form>
</div>
<script>
    // Function to validate name
    function confirmSamePwd() {
        console.log('Inside function');
        const pwd = document.getElementById('pwd'); // Password input field
        const pwdInput = document.getElementById('confirmPwd'); // Confirm password input field
        const pwdError = document.getElementById('confirmPwdError'); // Error message element
        const pwdValue = pwdInput.value.trim(); // Trimmed confirm password value

        // Compare trimmed values of both password fields
        if (pwd.value.trim() !== pwdValue) {
            console.log("Password value: " + pwd.value.trim()); // Correct concatenation
            console.log("Confirmation value: " + pwdValue); // Correct concatenation

            pwdError.textContent = 'Passwords do not match'; // Clear error message
        } else {
            pwdError.textContent = ''; // Clear error message if passwords match
        }
    }
</script>