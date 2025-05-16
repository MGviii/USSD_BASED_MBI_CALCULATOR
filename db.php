<?php
class DB {
    private static $host = 'localhost'; 
    private static $dbName = 'BMICalculator'; 
    private static $username = 'root'; 
    private static $password = ''; 
    private static $conn;

    public static function connect() {
        if (!isset(self::$conn)) {
            try {
                self::$conn = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$dbName, self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }

        return self::$conn;
    }

    public static function disconnect() {
        self::$conn = null;
    }
}
