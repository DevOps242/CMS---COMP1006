<?php 
require_once __DIR__. '/../utilities/shared.php';
require_once __DIR__. '/../utilities/Log.php';

class Database {

    private $dbHost = DB_HOST;
    private $dbName = DB_NAME;
    private $dbUser = DB_USERNAME;
    private $dbPass = DB_PASSWORD;
    public $connect;

    function __construct() {
        try{
            $this->connect = new PDO("mysql:host=$this->dbHost; dbname=$this->dbName", $this->dbUser, $this->dbPass);
            // To get the error.
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (Exception $error) {
            Log::error('Database Error: ' . json_encode($error->getMessage()) );
            // Send user to general eror page.
            header('Location: ../view/error.php');
            exit;
        }
    }

    // Method created to only fetch one data
    public function FetchRecordOne($query, ...$args) {
        $cmd = $this->connect;
        $cmd = $cmd->prepare($query);
        $cmd->execute();
        $result = $cmd->fetch();                                                        // Use PDO fetch() method to store result from b query 
    
        return $result;
    }

     // Method created to fetch more than 1 data
     public function fetchRecordAll(array $data) {
        // query the genres table
        // $cmd = $this->connect;
        // $cmd = $cmd->prepare($data['query']);
        // foreach($data as $item) {
        //     $cmd->bindParam($item['key'], $item['value'], $item['option']);
        // }
        // $cmd->execute();
        // $results = $cmd->fetchAll();                                                    // Use PDO fetchAll() method to store resultset from b query in an arry

        // return $results;

    }

    // terminate the db connection 
    public function kill() {
        $this->connect = null;
    }
}