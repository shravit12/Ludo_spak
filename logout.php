<?php
session_start();
session_destroy(); // Destroy all session data

// Redirect to the login page after logging out
header("Location: index.html");
exit();
?>