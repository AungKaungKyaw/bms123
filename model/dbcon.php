<?php
class Database{
    private static $localhost ='localhost';
    private static $dbname = 'bms';
    private static $port = 3306;
    private static $username = 'root';
    private static $password ='';
    private static $connection = null;
    public static function Connect(){
        try{
            $attr = "mysql:host=".self::$localhost.";port=".self::$port.";dbname=".self::$dbname;
            self::$connection = new PDO($attr,self::$username,self::$password);
            return self::$connection;
        }catch(PDOException $e){
            echo "connetion failed - ". $e->getMessage();
            return self::$connection;
        }
    }
    public static function Disconnect(){
        self::$connection = null;
    }
}
