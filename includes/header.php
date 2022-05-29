<?php
require_once("includes/config.php");
require_once("includes/classes/DayContainers.php");
require_once("includes/classes/Movie.php");
require_once("includes/classes/PreviewProvider.php");
require_once("includes/classes/MovieProvider.php");
require_once("includes/classes/ErrorMessage.php");
require_once("includes/classes/Session.php");
require_once("includes/classes/User.php");
require_once("includes/classes/Booking.php");
require_once("includes/classes/Review.php");

if(!isset($_SESSION["userLoggedIn"])) {
    header("Location: register.php");
}

$userLoggedIn = $_SESSION["userLoggedIn"];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cinema booking</title>
        <link rel="stylesheet" type="text/css" href="assets/style/style.css" />

        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/06a651c8da.js" crossorigin="anonymous"></script>
        <script src="assets/js/script.js"></script>
    </head>
    <body>
        <div class='wrapper'>

<?php
if(!isset($hideNav)) {
    include_once("includes/navBar.php");
}
?>