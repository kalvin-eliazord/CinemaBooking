<?php
require_once("includes/header.php");

?>
<div class="topBar">

    <ul class="navLinks">
        <li><a href="index.php">Home</a></li>
       <li><a href="mailto:cinemaBooking@gmail.com">Contact</a></li>
       <li><a href="booking.php">Booking</a></li>

        <?php 
        $userAdmin = new User($con, $userLoggedIn);
        if($userAdmin->getIsAdmin() == 1){
            echo "<li><a href='indexAdmin.php'>Home Admin</a></li>
                 <li><a href='sessionInsertion.php'>Session insertion</a></li>
                 <li><a href='movieInsertion.php'>Movie insertion</a></li>";
        }
        ?> 
    </ul>
    
   <div class="rightItems">
        <a href="profile.php">
            <i class="fas fa-user"></i>
        </a>

        <a href="logout.php">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>

</div>