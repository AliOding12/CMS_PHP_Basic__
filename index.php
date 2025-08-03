<?php
require_once 'includes/functions.php';
if (isLoggedIn()) {
    header('Location: pages/dashboard.php');
} else {
    header('Location: pages/login.php');
}
exit;
?>