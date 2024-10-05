<?php
session_start(); // Start the session

// Clear the session array
$_SESSION = array();

// If there is a cookie for the session, delete it
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-86400, '/');
}

// Destroy the session
session_destroy();

// Redirect to index.php
header('Location: index.php'); // Redirect to the homepage 
exit(); 
?>