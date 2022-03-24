<?php 
require 'shared.php';

class Log {

//    public function __construct()
//    {
//         $this->checkLogFiles();
//    }
   
    public static function error($message) {
        $logPath = '../../storage/logs/';
        $fileName = 'cli-server-' .date('j F, Y') .'.log';
        $fileName = $logPath . $fileName;
        
        // Build the log message 
        date_default_timezone_set('US/Eastern');
        $message = $message  . PHP_EOL . 'TimeStamp: ' . date("l jS \of F Y h:i:s A") . PHP_EOL;

        try {
            if (file_exists($fileName) && strpos($fileName, date('j F, Y')) ) {
                $file = fopen($fileName, 'a+');
                // Append the message if not already done.
                fwrite($file, $message . PHP_EOL);
                fclose($file);
            }
        } catch (Exception $error){
            throw new Exception($error->message);
        }
       
        // takes in the error 

        // Grabs the current date. 

        // Grabs the users session if any, 

        // Grabs the users time, 
        
        // Creats a .log file if not already created for the date. 


        
    }

    public static function log($message) {
        $logPath = '../../storage/logs/';
        $fileName = 'cli-server-' .date('j F, Y') .'.log';
        $fileName = $logPath . $fileName;
        
        // Build the log message 
        date_default_timezone_set('US/Eastern');
        $message = $message  . PHP_EOL . 'TimeStamp: ' . date("l jS \of F Y h:i:s A") . PHP_EOL;

        try {
            if (file_exists($fileName) && strpos($fileName, date('j F, Y')) ) {
                $file = fopen($fileName, 'a+');
                // Append the message if not already done.
                fwrite($file, $message . PHP_EOL);
                fclose($file);
            }
        } catch (Exception $error){
            throw new Exception($error->message);
        }
    }

    // Creates the log file if not already created.
    private static function generateLogFileDaily(){
        $logPath = '../../storage/logs/';
        $fileName = 'cli-server-' .date('j F, Y') .'.log';
        $fileName = $logPath . $fileName;

        $file = fopen($fileName, 'x+');

        if (!$file) {
            die('Error creating the file ' . $fileName );
        }
        
        fwrite($file, 'cli-server-' . date('j F, Y') .PHP_EOL . 'Logs Begin Here:' . PHP_EOL);
        fclose($file);
    }

    // Checks to see if the log files for today is created.
    private static function checkLogFiles() {
        $logPath = '../../storage/logs/';
        $fileName = 'cli-server-' .date('j F, Y') .'.log';
        $fileName = $logPath . $fileName;

        if ( !file_exists($fileName) ) {
            Log::generateLogFileDaily();
        } 
    }
}