<?php
class MovieProvider {
   
    public static function getMovies($con, $dayId) {

        $sql = "SELECT DISTINCT(movies.id) 
                FROM movies, sessions 
                WHERE movies.id=sessions.movieId 
                AND dayId=:dayId ";

        $query = $con->prepare($sql);

        $query->bindValue(":dayId", $dayId);

        $query->execute();

        $result = array();
        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Movie($con, $row["id"]);
        }

        return $result;
    }
}
?>