<?php
require_once("includes/header.php");
$user = new User($con, $userLoggedIn);
$booking = new Booking($con);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Your booking(s)</title>
        <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
    </head>
    <body>
        <div class="settingsContainer column">
                <div class="header">
                    <h1> Your booking(s)</h1>
                </div>
                <?php 
                if($booking->getBooking($user->getId())){
                 ?>
                    <select name='booking'>
                 <?php
                                    $bookings = $booking->getBooking($user->getId());
                                    $tSessionId = array();
                                    foreach($bookings as $booking){
                                        array_push($tSessionId, $booking["sessionId"]);
                                    }
                                
                                    $sql = "SELECT start_hour, end_hour, day, name
                                            FROM sessions, movies, days
                                            WHERE sessions.movieId=movies.id
                                            AND sessions.dayId=days.id
                                            AND sessions.id IN (";
                                    $sql .= implode(", ",$tSessionId) . ") ";
                                    $query = $con->prepare($sql);
                                    $query->execute();

                                    while($row = $query->fetch(PDO::FETCH_ASSOC)){       
                                        echo "<option value='$row[id]'> $row[day] : $row[name] ($row[start_hour] - $row[end_hour]) </option>";
                                    } 
                                ?>
                </select>
                <?php } else {
                    echo "<h2> No booking. </h2>";
                }
                    ?>
         </div>
    </body>
</html>