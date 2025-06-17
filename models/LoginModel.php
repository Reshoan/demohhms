<?php
require_once(__DIR__ . '/../config/db_connection.php');

class LoginModel {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection(); // Oracle connection
    }

    public function login($email, $password) {
        $conn = $this->db;

        $user_id = null;
        $user_type = null;
        $user_name = null;
        $hashed_pw = null;

        $stmt = oci_parse($conn, "BEGIN loginUser(:email, :user_id, :user_type, :user_name, :hashed_pw); END;");

        oci_bind_by_name($stmt, ":email", $email);
        oci_bind_by_name($stmt, ":user_id", $user_id, 32);
        oci_bind_by_name($stmt, ":user_type", $user_type, 100);
        oci_bind_by_name($stmt, ":user_name", $user_name, 100);
        oci_bind_by_name($stmt, ":hashed_pw", $hashed_pw, 100);

        $success = oci_execute($stmt);

        if (!$success) {
            return false;
        }

        if ($user_id === null) {
            return false;
        }

        // Verify password with PHP password_verify
        if (!password_verify($password, $hashed_pw)) {
            return false;
        }

        return [
            'user_id' => $user_id,
            'user_type' => $user_type,
            'user_name' => $user_name,
        ];
    }
}
