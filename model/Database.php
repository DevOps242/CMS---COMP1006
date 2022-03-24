<?php 

class Database {
  
    private $dbHost;
    private $dbName;
    private $dbUser;
    private $dbPass;
    public $connect;


    function __construct() {

        // $this->handle();
    }

    public function handle() {
        $this->connect = new PDO("mysql:host=$this->dbHost; dbname=$this->dbName", $this->dbUser, $this->dbPass);
        // To get the error.
        $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($this->connect) {
            echo 'connected'; 
            
        } else {
            echo 'connection failed';
        }
    }

    // Method created to only fetch one data
    public function FetchRecordOne($query) {
        $cmd = $this->connect;
        $cmd = $cmd->prepare($query);
        $cmd->execute();
        $result = $cmd->fetch();                                                        // Use PDO fetch() method to store result from b query 
    
        return $result;
    }

     // Method created to fetch more than 1 data
     public function fetchRecordAll($query) {
        // query the genres table
        $cmd = $this->connect;
        $cmd = $cmd->prepare($query);
        $cmd->execute();
        $results = $cmd->fetchAll();                                                    // Use PDO fetchAll() method to store resultset from b query in an arry

        return $results;

    }

    // terminate the db connection 
    public function kill() {
        $this->connect = null;
    }
}