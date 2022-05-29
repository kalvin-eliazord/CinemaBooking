<?php
require_once("includes/header.php");

$containers = new DayContainers($con, $userLoggedIn);
echo $containers->showAllDaysForAdmin();
?>


