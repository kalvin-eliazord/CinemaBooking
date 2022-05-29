<?php
class PreviewProvider {

    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }
    
    public function createMoviePreviewSquare($movie, $dayId) {
        $movieId = $movie->getId();
        $thumbnail = $movie->getThumbnail();
        $name = $movie->getName();

        return "<a href='movie.php?dayId=$dayId&amp;movieId=$movieId'>
                    <div class='previewContainer small'>
                        <img src='$thumbnail' title='$name'>
                    </div>
                </a>"
                ;
    }

    public function createMoviePreviewSquareAdmin($movie, $dayId) {
        $movieId = $movie->getId();
        $thumbnail = $movie->getThumbnail();
        $name = $movie->getName();

        return "<a href='movieAdmin.php?dayId=$dayId&amp;movieId=$movieId'>
                    <div class='previewContainer small'>
                        <img src='$thumbnail' title='$name'>
                    </div>
                </a>
                <a href='movieManagement.php?id=$movieId'>
                <input type='button' name='manageBtn' value='Manage movie'>
                </a>
                <a href='sessionManagement.php?dayId=$dayId&amp;movieId=$movieId'>
                <input type='button' name='sessionBtn' value='Manage session'>
                </a>";
    }

}
?>