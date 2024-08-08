<?php



// connection to the base de donnée

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Store the form values in session variables
        $_SESSION['email'] = htmlspecialchars($_POST['email']);
        $_SESSION['pwd'] = htmlspecialchars($_POST['pwd']);

        $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
        if (!$connection) {
            die('problem wih the connection' . mysqli_connect_error());
        }

        $sql = "SELECT nom FROM users WHERE email='" . $_SESSION['email'] . "' AND pwd ='" . $_SESSION['pwd'] . "';";
        $results = mysqli_query($connection, $sql);
        if (mysqli_num_rows($results) > 0) {
            while ($row = mysqli_fetch_assoc($results)) {
                echo "<br>Title : " . $row["nom"];
                // Set a session variable
                $_SESSION['name'] = $row["nom"];
                header("Location:index.php?pg=dashboard");
                exit();
            }
        } else {
            echo "Login details not found ";
        }
    }
} catch (Exception $e) {
    echo "Une erreur est survenue dans le fischer :  " . $e->getFile() . "<br>";
    echo "a la ligne  :  " . $e->getLine() . "<br>";
    echo "and the error message is  :  " . $e->getMessage() . "<br>";
}

?>

<div class="container">
    <form action="" class='form' method="POST">


        <p>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email">
        </p>
        <p>
            <label for="pwd">Password:</label>
            <input type="password" id="pwd" name="pwd">
        </p>

        <input type="hidden" name="hidden" value="<?php echo date('d/m/Y H:i:s'); ?>">
        <input type="submit" name="submit" value="Envoyer">


        Already have an account ?: <a href="index.php?pg=login">Login </a>: <a href="index.php?pg=register">signup</a>
    </form>
</div>