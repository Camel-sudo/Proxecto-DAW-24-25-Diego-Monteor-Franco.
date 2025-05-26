
<?php
define("DSN","mysql:host=mariadb;dbname=nutripro");
define("DB_USER","root");
define("DB_PASS","bitnami");

class ConnectionDB{
    private static $pdo;

    public static function get(){
        if(!isset(self::$pdo)){
            try {
                self::$pdo = new PDO(DSN, DB_USER, DB_PASS);
            } catch (PDOException $th) {
                error_log($th->getMessage());
            }
        }
        
        return self::$pdo;
    }
}
