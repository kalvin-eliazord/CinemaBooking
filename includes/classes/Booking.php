<?php 
class Booking{
    private $con;

    public function __construct($con) {
        $this->con = $con;
    }

    public function insertBooking($userId, $sessionId){
            $query = $this->con->prepare("INSERT INTO bookings (userId, sessionId)
                                        VALUES (:userId, :sessionId)");
            $query->bindValue(":userId", $userId);
            $query->bindValue(":sessionId", $sessionId);
            $query->execute();
            return $query;
    }

    public function updateBooking($bookingId, $sessionId){
        $query = $this->con->prepare("UPDATE bookings SET sessionId=:sessionId WHERE id=:bookingId"); 
        $query->bindValue(":bookingId", $bookingId);
        $query->bindValue(":sessionId", $sessionId);
        $query->execute();

        return $query;
    }

    public function deleteBooking($id){
        $query = $this->con->prepare("DELETE FROM bookings WHERE id=:id"); 
        $query->bindValue(":id", $id);
        $query->execute();

        return $query;
    }

    public function getBooking($userId){
        $query = $this->con->prepare("SELECT * FROM bookings WHERE userId=:userId");
        $query->bindValue(":userId", $userId);
        $query->execute();

        if($query->rowCount() !== 0) {
            return $query;
        } else {
            return false;
        }    
    }
}