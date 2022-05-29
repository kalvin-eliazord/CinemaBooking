<?php 
include_once("includes/header.php");

$detailsMessage = "";
$session = new Session($con);
if(isset($_POST["insertButton"])) {
        $dayId = $_POST["day"];
        $movieId = $_POST["movie"];
        $start_hour = $_POST["start_hour"];
        $end_hour = $_POST["end_hour"];
    if($session->insertSession($dayId, $movieId, $start_hour, $end_hour)){
        $detailsMessage = "<div class='alertSuccess'>
                                Session inserted successfully!
                            </div>";
    } else {
        $detailsMessage = "<div class='alertError'>
                                Insert error, please check the fields.
                            </div>";
    }
}


function getInputValue($name) {
    if(isset($_POST[$name])) {
        echo $_POST[$name];
    }
}  
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Insert session</title>
        <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
    </head>
    <body>
        
        <div class="settingsContainer column">
                <div class="header">
                <h1> Insert session </h1>
                </div>
                <form method="POST">
                                <h3>Day </h3>
                            <select name='day'>
                                <?php 
                                    $query = $con->prepare("SELECT * FROM days");
                                    $query->execute();
                                    while($row = $query->fetch(PDO::FETCH_ASSOC)){       
                                        echo "<option value='$row[id]'> $row[day] </option>";
                                    } 
                                ?>
                            </select>
                            <h3>Movie</h3>
                            <select name='movie'>
                                <?php 
                                    $query = $con->prepare("SELECT * FROM movies");
                                    $query->execute();
                                    while($row = $query->fetch(PDO::FETCH_ASSOC)){       
                                        echo "<option value='$row[id]'> $row[name] </option>";
                                    } 
                                ?>
                            </select>
                            <h3>start hour</h3>
                        <input type="time" id="start_hour" name="start_hour" min="09:00" max="23:00" required>
                        <h3>end hour</h3>
                        <input type="time" id="end_hour" name="end_hour" min="11:00" max="00:00" required>
                        <div class="message">
                            <?php echo $detailsMessage; ?>
                        </div>
                        <div class="settingsContainer">
                            <input type="submit" name="insertButton" value="INSERT">
                                </form>
                <a href="indexAdmin.php" class="signInMessage">Return</a>
                </div>
            </div>

    </body>
</html>
