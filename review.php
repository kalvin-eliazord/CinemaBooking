<?php include_once("includes/header.php");

if(!isset($_GET["id"])){
    ErrorMessage::show("No ID passed into page");
}

$movieId = $_GET["id"];
$movie = new Movie($con, $movieId);
$review = new Review($con, $movieId);
$user = new User($con, $userLoggedIn);
$userId = $user->getId();
$detailsMessage ="";

if(isset($_POST["insertButton"])) {
    $userReview = $_POST["review"];
    if($review->insertReview($userId, $userReview)) {
            header("Location:review.php?id=".$movieId);
    } else {
        $detailsMessage = "<div class='alertError'>
                                Insert review error!
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
        <title>Insert Reviews</title>
        <link rel="stylesheet" type="text/css" href="assets/style/style.css" />
    </head>
    <body>
        
        <div class="settingsContainer column">
                <div class="header">
                <h1> Insert a review for <?php echo $movie->getName(); ?></h1>
                </div>
                <form method="POST">
                            <textarea name="review" value="<?php getInputValue("review"); ?>" required> </textarea>
                 <div class="message">
                     <?php echo $detailsMessage; ?>
                 </div>
                 <div class="settingsContainerAdmin">                    
                    <input type="submit" name="insertButton" value="Review">
                    <?php echo "<a href='index.php'"?> <a class="signInMessage">Return</a>
                    <?php
                    if($review->getReview()){
                        $query = $con->prepare("SELECT * FROM reviews WHERE movieId=:movieId");
                        $query->bindValue(":movieId", $movieId);
                        $query->execute();
                    
                        while($row = $query->fetch(PDO::FETCH_ASSOC)){
                            $html = "<h2> ";
                            $username = $user->getUsernameById($row["userId"]);
                            echo $html .= $username.
                                    "</h2>
                                    <div class='comment'>
                                        ".$row["review"]."      
                                    </div>";                       
                        }       
                    } else {
                        echo "Be the first comment!";
                    }
                     
                    ?>
                    </div>
                </div>
                </form>
                
                </div>
            </div>

    </body>
</html>