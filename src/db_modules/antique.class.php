<?php
require_once 'database.php';

class Antique {
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

    public $img_src = '';

    protected $db;

    function __construct() {
        $this->db = new Database();
    }

    function addAntique() {
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

        return $query->execute();
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
}

/* $obj = new Antique(); */
/* $obj->userLogin('eh202201078@wmsu.edu.ph', null ,'MegRyanPH244'); */
/* $obj->fetchCategory();
var_dump($obj); */