<?php
require_once 'database.php';

class Account {
    public $id = '';
    public $firstname = '';
    public $lastname = '';
    public $email = '';
    public $password = '';

    protected $db;

    function __construct() {
        $this->db = new Database();
    }

    function userSignup() {
        $sql = "INSERT INTO account (firstname, lastname, email, password) VALUES ( :firstname, :lastname, :email, :password);";

        $prepQuery = $this->db->connect()->prepare($sql);

        $prepQuery->bindParam(':firstname', $this->firstname);
        $prepQuery->bindParam(':lastname', $this->lastname);
        $prepQuery->bindParam(':email', $this->email);
        $prepQuery->bindParam(':password', $this->password);

        if($prepQuery->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function userLogin($email, $password) {
        $sql = "SELECT * FROM account WHERE email = :email LIMIT 1;";

        $prepQuery = $this->db->connect()->prepare($sql);

        $prepQuery->bindParam(':email', $email);

        if($prepQuery->execute()) {
            $data = $prepQuery->fetch();
            if(isset($data['password']) && password_verify($password, $data['password'])){
                return true;
            }
        }
        return false;
    }
}