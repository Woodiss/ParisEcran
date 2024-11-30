<?php 

namespace parisecran\Entity;

class BddGenerate
{
    private \PDO $connector;

    public function __construct(\PDO $connector)
    {
        $this->connector = $connector;
    }

    public function selectCine()
    {
        $query = "SELECT * FROM cinema";
        $stmt = $this->connector->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function createRoom($id_cine)
    {
        $randomNumber = rand(3, 8);
        $randomName = rand(1, 2);

        $nameList = ["A", "B", "C"];
        $gauge = 400;
        
        for ($i=0; $i <= $randomNumber; $i++) {
            
            $name = $nameList[$randomName] . $i;

            $query = "INSERT INTO `room`(`name`, `gauge`, `cinema_id`) VALUES (:name, :gauge, :id_cine)";
            
            $stmt = $this->connector->prepare($query);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":gauge", $gauge);
            $stmt->bindParam(":id_cine", $id_cine);
            
            $stmt->execute();
        }
    }
}