<?php


session_start();


// All the parameters of configuration needs to be in at the top of our index page 
require('./config/config.php');
// // Determine the page to load
$page = $_GET['pg'] ?? 'login';

// // Define authorized pages
$authorizedPages = ['dashboard', 'create_post', 'login', 'logout', 'register'];

// // Ensure the page is authorized, otherwise use '404'
$page = in_array($page, $authorizedPages) ? $page : '404';

// // HEADER OF THE ENTIRE PAGE
require_once('./inc/header.php');
// // Include the content of the page
$pageFile = './pages/' . $page . '.php';
if (file_exists($pageFile)) {
    require $pageFile;
} else {
    echo '<p>Page not found.</p>';
}

// // FOOTER FOR THE ENTIRE PAGE
// require('./inc/footer.php');
