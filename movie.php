<?php
require_once("includes/header.php");

if(!isset($_GET["dayId"]) && !isset($_GET["movieId"]) ) {
    ErrorMessage::show("No ID passed into page");
}

$movieId = $_GET["movieId"];
$dayId = $_GET["dayId"];
$user = new User($con, $userLoggedIn);
$booking = new Booking($con);
$detailsMessage = "";

if(isset($_POST["bookButton"])) {
    $sessionId = $_POST["session"];
    if($booking->insertBooking($user->getId(), $sessionId)){
        $detailsMessage = "<div class='alertSuccess'>
                             Details inserted successfully!
                          </div>";
    } else {
        $detailsMessage = "<div class='alertError'>
                            Insert error!
                            </div>";
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Reserve</title>
        <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
    </head>
    <body>
        
        <div class="settingsContainer column">
                <div class="header">
                    <h3>Reserve your session </h3>
                </div>
                <form method="POST">                    
                            <select name='session'>
                                <?php 
                                    $query = $con->prepare("SELECT * FROM sessions WHERE movieId=:movieId AND
                                                            dayId=:dayId");
                                    $query->bindValue(":movieId", $movieId);
                                    $query->bindValue(":dayId", $dayId);
                                    $query->execute();
                                    while($row = $query->fetch(PDO::FETCH_ASSOC)){       
                                        echo "<option value='$row[id]'> $row[start_hour] </option>";
                                    } 
                                ?>
                            </select>
                    <div class="message">
                        <?php echo $detailsMessage; ?>
                    </div>
                    <div class="season"> 
    <a href='review.php?id=<?php echo $movieId ?>'> Click here to review </a>
</div>
                        <div class="settingsContainer">
                            <input type="submit" name="bookButton" value="Book">
                </form>
                          <a href="index.php" class="signInMessage">Return</a>
                    </div>
         </div>

    </body>
</html>

