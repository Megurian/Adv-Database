<?php
require_once 'database.php';

class Antique {
    //Antique Table Properties
    public $id = '';
    public $antique_name = '';
    public $description = '';
    public $category_id = '';
    public $year = '';
    public $value = '';
    public $street = '';
    public $barangay = '';
    public $city = '';
    public $postal_code = '';

    //Antique Images Table Properties
    public $img_src = '';

    protected $db;

    function __construct() {
        $this->db = new Database();
    }

    function addAntique() {
        try {
            $this->db->connect()->beginTransaction();

            $sql = "INSERT INTO antique (antique_name, description, category_id, year, value, street, barangay, city, postal_code)
                    VALUES (:antique_name, :description, :category_id, :year, :value, :street, :barangay, :city, :postal_code);";
        
            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':antique_name', $this->antique_name);
            $query->bindParam(':description', $this->description);
            $query->bindParam(':category_id', $this->category_id);
            $query->bindParam(':year', $this->year);
            $query->bindParam(':value', $this->value);
            $query->bindParam(':street', $this->street);
            $query->bindParam(':barangay', $this->barangay);
            $query->bindParam(':city', $this->city);
            $query->bindParam(':postal_code', $this->postal_code);

            $antiqueId = '';
            if($query->execute()) {
                // Retrieve the last inserted ID for this transaction
                $antiqueId = $this->db->connect()->lastInsertId();
                $this->db->connect()->commit();
                
                return $antiqueId;
            }

        } catch (PDOException $e) {
            $this->db->connect()->rollBack();
            return false;
        }
    }

    function insertImagePath($antiqueId, $imagePath) {
        try {
            $this->db->connect()->beginTransaction();

            $sql = "INSERT INTO antique_images (antique_id, img_path) 
                    VALUES (:antiqueId, :imagePath);";

            $query = $this->db->connect()->prepare($sql);

            $query->bindParam(':antiqueId', $antiqueId);
            $query->bindParam(':imagePath', $imagePath);

            if($query->execute()) {
                $this->db->connect()->commit();
                return true;
            }

        } catch (PDOException $e) {

            $this->db->connect()->rollBack();
            return false;
        }
    }

    function fetchAllRecord($keyword = ''){
        $sql_statement = "SELECT * FROM antique WHERE antique_name LIKE CONCAT('%', :keyword, '%');";    //sql query to fetch all records

        //prepare query for execution
        $query = $this->db->connect()->prepare($sql_statement);
        $query->bindParam(":keyword", $keyword);

        $data = null;    //initialize a variable to hold the fetched data

        if($query->execute()){
            $data = $query->fetchAll(); //fetch all rows from the result set
        }

        return $data;   //return data after function called
    }

    function fetchCategory() {
        $sql = "SELECT * FROM category ORDER BY name ASC;";
    
        $query = $this->db->connect()->prepare($sql);
    
        $data = null;
    
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all rows as an associative array.
        }

        return $data;
    }

    function getAntiqueCategorybyID($id = '') {
        $sql = "SELECT * FROM category WHERE id = :id;";
        $query = $this->db->connect()->prepare($sql);

        $query->bindParam(':id', $id);

        $data = null;
        if ($query->execute()) {
            $data = $query->fetch(); // Fetch all rows as an associative array.
        }

        return $data;
    }
}

/* $obj = new Antique(); */
/* $obj->userLogin('eh202201078@wmsu.edu.ph', null ,'MegRyanPH244'); */
/* $obj->fetchCategory();
var_dump($obj); */