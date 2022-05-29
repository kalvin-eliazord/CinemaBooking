<?php 
class Review{
    private $con, $movieId, $sqlData;

    public function __construct($con, $movieId) {
        $this->con = $con;
        $this->movieId = $movieId;
        $query = $this->con->prepare("SELECT * FROM reviews WHERE movieId=:movieId");
        $query->bindValue(":movieId", $this->movieId);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }

    public function insertReview($userId, $review){
        $query = $this->con->prepare("INSERT INTO reviews (userId, movieId, review)
                                        values (:userId, :movieId, :review) ");
        $query->bindValue(":userId", $userId);
        $query->bindValue(":movieId", $this->movieId);
        $query->bindValue(":review", $review);

        return $query->execute();
    }

    public function getReview(){
        if(isset($this->sqlData["review"])){
           return true;
        }
        
        return false;
    }

}
