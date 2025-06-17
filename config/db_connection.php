<?php
class Database {
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            $username = 'DemoHHMS';
            $password = 'DemoHHMS';
            $connection_string = 'TNS://localhost:1521/XE'; // e.g. "localhost/XEPDB1"

            self::$conn = oci_connect($username, $password, $connection_string);

            if (!self::$conn) {
                $e = oci_error();
                die("Database connection failed: " . $e['message']);
            }
        }
        return self::$conn;
    }

    public static function closeConnection() {
        if (self::$conn !== null) {
            oci_close(self::$conn);
            self::$conn = null;
        }
    }
}
