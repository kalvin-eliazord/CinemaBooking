<?php
$hideNav = "hideNav";
require_once("includes/header.php");

if(!isset($_GET["dayId"]) && !isset($_GET["movieId"]) ) {
    ErrorMessage::show("No ID passed into page");
}

$movieId = $_GET["movieId"];
$dayId = $_GET["dayId"];
$movie = new Movie($con, $movieId);
$session = new Session($con);
$detailsMessage = "";
if(isset($_POST["updateButton"])) {
    if($_POST["end_hour"] !== "" &&  $_POST["start_hour"] !== "" ){
        $day = $_POST["day"];
        $start_hour = $_POST["start_hour"];
        $end_hour = $_POST["end_hour"];
        $sessionId = $_POST["session"];
        $session->updateSession($day, $start_hour, $end_hour, $sessionId);
            header("Location: sessionManagement.php?id=".$movieId);
            $detailsMessage = "<div class='alertSuccess'>
                                    Session updated successfully!
                                </div>";
        } else {
            $detailsMessage = "<div class='alertError'>
                                Update error, please check the fields.
                            </div>";
        }
    }

 if(isset($_POST["deleteButton"])) {
    $sessionId = $_POST["session"];
    if($session->deleteSession($sessionId)) {
        
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
        <title>Manage session</title>
        <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
    </head>
    <body>
        
        <div class="signInContainer">

            <div class="column">
            <h1>Session management</h1>
                <div class="header">
                </div>

                <form method="POST">
                <h3>Session</h3>
                            <select name='session'>
                                <?php 
                                    $query = $con->prepare("SELECT sessions.id, start_hour, end_hour, day
                                                            FROM sessions, days
                                                            WHERE sessions.dayId=days.id
                                                            AND dayId=:dayId
                                                            AND movieId=:movieId");
                                    $query->bindValue(":movieId", $movieId);
                                    $query->bindValue(":dayId", $dayId);
                                    $query->execute();
                                    while($row = $query->fetch(PDO::FETCH_ASSOC)){       
                                        echo "<option value='$row[id]'> $row[day] - $row[start_hour] - $row[end_hour] </option>";
                                    } 
                                ?>
                            </select>
                            <h3>Day</h3>
                            <select name='day'>
                                <?php 
                                    $query = $con->prepare("SELECT * FROM days");
                                    $query->execute();
                                    while($row = $query->fetch(PDO::FETCH_ASSOC)){       
                                        echo "<option value='$row[id]'> $row[day] </option>";
                                    } 
                                ?>
                            </select>
                            <h3>Start hour</h3>
                        <input type="time" id="start_hour" name="start_hour" min="09:00" max="23:00">
                        <h3>End hour</h3>
                        <input type="time" id="end_hour" name="end_hour" min="11:00" max="00:00">
                 <div class="message">
                     <?php echo $detailsMessage; ?>
                 </div>
                    <div class="settingsContainer">
                        <input type="submit" name="updateButton" value="UPDATE">
                        <input type="submit" name="deleteButton" value="DELETE">
                    </div>
                </form>
                <a href="indexAdmin.php" class="signInMessage">Return</a>
            </div>
        </div>
    </body>
</html>