<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Debug information
echo "Session before unset: ";
print_r($_SESSION);

session_unset();
session_destroy();

// Debug information
echo "Session after destroy: ";
print_r($_SESSION);

// Multiple redirect methods
header("Location: index.php");
echo '<script>window.location.href = "index.php";</script>';
echo '<meta http-equiv="refresh" content="0;url=index.php">';

exit();
?>