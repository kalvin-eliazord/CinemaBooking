<?php 
class Session{
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function insertSession($dayId, $movieId, $start_hour, $end_hour){
            $query = $this->con->prepare("INSERT INTO sessions (dayId, movieId, start_hour, end_hour)
                                          VALUES (:dayId, :movieId, :start_hour, :end_hour)");
            $query->bindValue(":dayId", $dayId);
            $query->bindValue(":movieId", $movieId);
            $query->bindValue(":start_hour", $start_hour);
            $query->bindValue(":end_hour", $end_hour);
            $query->execute();
            return $query;
    }

    public function updateSession($dayId, $start_hour, $end_hour, $id){
        $query = $this->con->prepare("UPDATE sessions SET dayId=:dayId, start_hour=:start_hour,
         end_hour=:end_hour WHERE id=:id"); 
        $query->bindValue(":dayId", $dayId);
        $query->bindValue(":start_hour", $start_hour);
        $query->bindValue(":end_hour", $end_hour);
        $query->bindValue(":id", $id);
        $query->execute();

        return $query;
    }

    public function deleteSession($id){
        $query = $this->con->prepare("DELETE FROM sessions WHERE id=:id"); 
        $query->bindValue(":id", $id);
        $query->execute();

        return $query;
    }

}