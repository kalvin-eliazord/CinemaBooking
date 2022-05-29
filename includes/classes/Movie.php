<?php
class Movie {

    private $con, $sqlData;

    public function __construct($con, $id = null) {
        $this->con = $con;

        $query = $this->con->prepare("SELECT * FROM movies WHERE id=:id");
        $query->bindValue(":id", $id);
        $query->execute();

        $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
    }
    

    public function updateMovie($name, $thumbnail, $preview, $categoryId, $producerId){
        $query = $this->con->prepare("UPDATE movies SET name=:name, thumbnail=:thumbnail, preview=:preview,
        categoryId=:categoryId, producerId=:producerId WHERE id=:id"); 
        $query->bindValue(":name", $name);
        $query->bindValue(":thumbnail", $thumbnail);
        $query->bindValue(":preview", $preview);
        $query->bindValue(":categoryId", $categoryId);
        $query->bindValue(":producerId", $producerId);
        $query->bindValue(":id", $this->getId());
        $query->execute();

        return $query;
    }

    public function deleteMovie(){
        $query = $this->con->prepare("DELETE FROM movies WHERE id=:id"); 
        $query->bindValue(":id", $this->getId());
        $query->execute();

        return $query;
    }

    public function insertMovie($name, $thumbnail, $preview, $categoryId, $producerId){
        $query = $this->con->prepare("INSERT INTO movies (name, thumbnail, preview, categoryId, producerId)
                                      VALUES (:name, :thumbnail, :preview, :categoryId, :producerId)");
        $query->bindValue(":name", $name);
        $query->bindValue(":thumbnail", $thumbnail);
        $query->bindValue(":preview", $preview);
        $query->bindValue(":categoryId", $categoryId);
        $query->bindValue(":producerId", $producerId);
        $query->execute();

        return $query;
    }

    public function getId() {
        return $this->sqlData["id"];
    }

    public function getName() {
        return $this->sqlData["name"];
    }

    public function getThumbnail() {
        return $this->sqlData["thumbnail"];
    }

    public function getPreview() {
        return $this->sqlData["preview"];
    }

    public function getCategoryId() {
        return $this->sqlData["categoryId"];
    }

    public function getDescription() {
        return $this->sqlData["description"];
    }

    public function getProducerId() {
        return $this->sqlData["producerId"];
    }


}
?>