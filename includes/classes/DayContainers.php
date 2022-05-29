<?php
class DayContainers {

    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function showAllDaysForAdmin() {
        $query = $this->con->prepare("SELECT * FROM days");
        $query->execute();
        
        $html = "<div class='previewCategoriesAdmin'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getDayHtmlAdmin($row, null);
        }

        return $html . "</div>";
    }

    public function showAllDays(){
        $query = $this->con->prepare("SELECT * FROM days");

          
        $query->execute();
        $html = "<div class='previewCategories'>";
    
        while($daysResult = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getDayHtml($daysResult, null);
        }

        return $html . "</div>";
    }

    
    public function showDay($dayId, $title = null) {
        $query = $this->con->prepare("SELECT * FROM days WHERE id=:id");
        $query->bindValue(":id", $dayId);
        $query->execute();

        $html = "<div class='previewCategories noScroll'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getDayHtml($row, $title);
        }

        return $html . "</div>";
    }

   
    private function getDayHtml($sqlData, $title){
        $dayId = $sqlData["id"];
        $title = $title == null ? $sqlData["day"] : $title;

        $movies = MovieProvider::getMovies($this->con, $dayId);

        if(sizeof($movies) == 0) {
            return;
        }

        $moviesHtml = "";
        $previewProvider = new PreviewProvider($this->con, $this->username);
        foreach($movies as $movie) {
            $moviesHtml .= $previewProvider->createMoviePreviewSquare($movie, $dayId);
        }

        return "<div class='categoryAdmin'>
                        <h3>$title</h3>

                    <div class='entities'>
                        $moviesHtml
                    </div>
                </div>";
    }

    private function getDayHtmlAdmin($sqlData, $title) {
        $dayId = $sqlData["id"];
        $title = $title == null ? $sqlData["day"] : $title;

        $movies = MovieProvider::getMovies($this->con, $dayId);

        if(sizeof($movies) == 0) {
            return;
        }

        $moviesHtml = "";
        $previewProvider = new PreviewProvider($this->con, $this->username);
        foreach($movies as $movie) {
            $moviesHtml .= $previewProvider->createMoviePreviewSquareAdmin($movie, $dayId);
        }

        return "<div class='categoryAdmin'>

                        <h3>$title</h3>

                    <div class='entities'>
                        $moviesHtml
                    </div>
                </div>";
    }

}
?>