<?php 
// require 'shared.php';

class Log {

//    public function __construct()
//    {
//         $this->checkLogFiles();
//    }

    public static function error($message) {
        date_default_timezone_set('US/Eastern');
        $logPath = __DIR__ .'/../storage/logs/';
        $fileName = 'cli-server-' .date('j-F-Y') .'.log';
        $fileName = $logPath . $fileName;
        
        // Build the log message 
        date_default_timezone_set('US/Eastern');
        $message = $message  . PHP_EOL . 'TimeStamp: ' . date("l jS \of F Y h:i:s A") . PHP_EOL;
     
        try {
            if (file_exists($fileName) && strpos($fileName, date('j-F-Y')) ) {
                $file = fopen($fileName, 'a+');
                // Append the message if not already done.
                fwrite($file, $message . PHP_EOL);
                fclose($file);
            } else {
                Log::checkLogFiles();
                $file = fopen($fileName, 'a+');
                // Append the message if not already done.
                fwrite($file, $message . PHP_EOL);
                fclose($file);
            }
            
        } catch (Exception $error){
            throw new Exception($error->message);
            // Send user to general eror page.
            header('Location: ../../view/error.php');
            exit;
        }
       
        // takes in the error 

        // Grabs the current date. 

        // Grabs the users session if any, 

        // Grabs the users time, 
        
        // Creats a .log file if not already created for the date. 

    }
// && strpos($fileName, date('j-F-Y'))
    public static function info($message) {
        date_default_timezone_set('US/Eastern');
        $logPath = __DIR__ .'/../storage/logs/';
        $fileName = 'cli-server-' .date('j-F-Y') .'.log';
        $fileName = $logPath . $fileName;
    
        // Build the log message     
        $message = $message  . PHP_EOL . 'TimeStamp: ' . date("l jS \of F Y h:i:s A") . PHP_EOL;
        
        try {
            if (file_exists($fileName) && strpos($fileName, date('j-F-Y')) ) {
                $file = fopen($fileName, 'a+');
                // Append the message if not already done.
                fwrite($file, $message . PHP_EOL);
                fclose($file);
            } else {
                Log::checkLogFiles();
                $file = fopen($fileName, 'a+');
                // Append the message if not already done.
                fwrite($file, $message . PHP_EOL);
                fclose($file);
            }
            
        } catch (Exception $error){
            throw new Exception($error->message);
            // Send user to general eror page.
            header('Location: ../../view/error.php');
            exit;
        }
    }

    // Creates the log file if not already created.
    private static function generateLogFileDaily(){
        date_default_timezone_set('US/Eastern');
        $logPath = __DIR__ .'/../storage/logs/';
        $fileName = 'cli-server-' .date('j-F-Y') .'.log';
        $fileName = $logPath . $fileName;
        try {
            $file = fopen($fileName, 'x+');

            if (!$file) {
                die('Error creating the file ' . $fileName );
            }
            
            fwrite($file, 'cli-server-' . date('j-F-Y') .PHP_EOL . 'Logs Begin Here:' . PHP_EOL);
            fclose($file);
        } catch (Exception $error) {
            Log::error('Log File failed to create: '. json_encode($error->getMessage()));
            // Send user to general eror page.
            header('Location: ../../view/error.php');
            exit;
        }
        
    }

    // Checks to see if the log files for today is created.
    private static function checkLogFiles() {
        date_default_timezone_set('US/Eastern');
        $logPath = __DIR__ .'/../storage/logs/';
        $fileName = 'cli-server-' .date('j-F-Y') .'.log';
        $fileName = $logPath . $fileName;

        if ( !file_exists($fileName) ) {
            Log::generateLogFileDaily();
        } 
    }
}