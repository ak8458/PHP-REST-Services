<?php

class DB_Functions {

    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {

    }


    public function addUser($name, $age, $email,$pwd) {
        //$uuid = uniqid('', true);
        if($this->ifUserExists($email,$pwd)){
            return false;
        }
        else {

            $stmt = $this->conn->prepare("INSERT INTO users(fullName, age, emailID, pwd) VALUES(?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $age, $email, $pwd);
            $result = $stmt->execute();
            $stmt->close();

            // check for successful store
            if ($result) {
                $stmt = $this->conn->prepare("SELECT * FROM users WHERE emailID = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                return $user;
            } else {
                return false;
            }
        }
    }


    public function registerUserToEvent($userID, $eventID) {
        //$uuid = uniqid('', true);
        if($this->isUserRegistered($userID,$eventID)){
            return false;
        }
        else{
            $userID=intval($userID);
            $eventID=intval($eventID);
            $stmt = $this->conn->prepare("INSERT INTO eventreg(userID, eventID) VALUES(?, ?)");
            $stmt->bind_param("ii",$userID, $eventID);
            $result = $stmt->execute();
            $stmt->close();

            // check for successful store
            if ($result) {
                $stmt = $this->conn->prepare("SELECT * FROM eventreg WHERE userID = ?");
                $stmt->bind_param("i", $userID);
                $stmt->execute();
                $confirm= $stmt->get_result()->fetch_assoc();
                $stmt->close();

                return $confirm;
            } else {
                return false;
            }
        }
    }
    /**
     * Storing new event
     * returns event details
     */
    public function addEvent($name, $date, $location,$desc) {
        //$uuid = uniqid('', true);

        // $date='2009-04-30 10:09:00';//date("Y-m-d",strtotime($date));
        $stmt = $this->conn->prepare("INSERT INTO events(ename, location, description, edate) VALUES(?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name,$location, $desc,$date);
        $result = $stmt->execute();
        $stmt->close();

        // check for successful store
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM events WHERE ename = ?");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $event = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            return $event;
        } else {
            return false;
        }
    }

    /**
     * Get user by email and password
     */
    public function getAllEvents() {

        $stmt = $this->conn->prepare("SELECT * FROM events");



        if ($stmt->execute()) {
            $events = $stmt->get_result();
            $stmt->close();
            return $events;
        } else {
            return NULL;
        }
    }


    public function checkEmailAndPassword($email) {

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE emailID = ?");

        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }

    /**
     * Check user is registered to the event
     */
    public function isUserRegistered($userID, $eventID) {
        $stmt = $this->conn->prepare("SELECT * from eventreg WHERE userID = ? and eventID= ?");

        $stmt->bind_param("ii", $userID,$eventID);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }

    /**
     * Check user is present
     */
    public function ifUserExists($email) {
        $stmt = $this->conn->prepare("SELECT * from users WHERE emailID = ?");

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }


}

?>