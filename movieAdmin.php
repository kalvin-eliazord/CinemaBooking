<?php
require_once("includes/header.php");

if(!isset($_GET["dayId"]) && !isset($_GET["movieId"]) ) {
    ErrorMessage::show("No ID passed into page");
}
$noBooking = false;
$movieId = $_GET["movieId"];
$dayId = $_GET["dayId"];
$user = new User($con, $userLoggedIn);
$booking = new Booking($con);
$detailsMessage = "";

if(isset($_POST["updateButton"])) {
    $bookingId = $_POST["booking"];
    $sessionId = $_POST["session"];
    if($booking->updateBooking($bookingId, $sessionId)){
        $detailsMessage = "<div class='alertSuccess'>
                             Booking updated successfully!
                          </div>";
    } else {
        $detailsMessage = "<div class='alertError'>
                            Update error!
                            </div>";
    }
}

if(isset($_POST["deleteButton"])) {
    $bookingId = $_POST["booking"];
    if($booking->deleteBooking($bookingId)) {
        header("Location: indexAdmin.php");
    } else {
        $detailsMessage = "<div class='alertError'>
                                Delete error!
                            </div>";
    }
 }

?>
<!DOCTYPE html>
<html>
    <head>
        <title>manage Booking</title>
        <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
    </head>
    <body>
        
        <div class="settingsContainer column">
                <div class="header">
                    <h3>Manage booking </h3>
                </div>
                <form method="POST">           
                    <h3>Booking</h3>         
                            <select name='booking'>
                                <?php 
                                    $query = $con->prepare("SELECT bookings.id, username, sessions.start_hour, sessions.end_hour
                                                            FROM bookings, sessions, users
                                                            WHERE bookings.sessionId=sessions.id 
                                                            AND bookings.userId=users.id
                                                            AND movieId=:movieId
                                                            AND dayId=:dayId");
                                    $query->bindValue(":movieId", $movieId);
                                    $query->bindValue(":dayId", $dayId);
                                    $query->execute();
                                    if($query->rowCount() == 0){
                                        $noBooking = true;
                                    }
                                                   
                                    while($row = $query->fetch(PDO::FETCH_ASSOC)){       
                                        echo "<option value='$row[id]'> $row[id] - $row[username] - $row[start_hour] - $row[end_hour] </option>";
                                    }
                                
                                ?>
                            </select>
                            <?php 
                            if(!$noBooking){
                                ?>
                            <h3>Session</h3>
                            <select name='session'>
                                <?php 
                                    $query = $con->prepare("SELECT * FROM sessions 
                                                            WHERE movieId=:movieId");
                                    $query->bindValue(":movieId", $movieId);
                                    $query->execute();
                                    while($row = $query->fetch(PDO::FETCH_ASSOC)){       
                                        echo "<option value='$row[id]'> $row[start_hour] - $row[end_hour] </option>";
                                    } 
                                ?>
                            </select>
                    <div class="message">
                        <?php echo $detailsMessage; ?>
                    </div>
                        <div class="settingsContainer">
                        
                            <input type="submit" name="updateButton" value="Update">
                            <input type="submit" name="deleteButton" value="Delete">
                        <?php
                        } else {
                            echo "<div class='category'>
                                <h3> No booking available. </h3>
                                </div>";
                        }
                        ?>
                     </form>
                          <a href="indexAdmin.php" class="signInMessage">Return</a>
                    </div>
         </div>

    </body>
</html>

