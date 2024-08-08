inside log out
<?php
//starting the session 
session_start();
session_unset();
$_SESSION['msg'] = "Deconnection reussi";

session_destroy();
//unsets all the varaibles of the session

//destroys the session completely 
header("Location:index.php?pg=login");
exit();
