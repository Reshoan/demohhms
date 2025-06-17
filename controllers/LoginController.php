<?php
require_once(__DIR__ . '/../models/LoginModel.php');

class LoginController {
    private $model;

    public function __construct() {
        $this->model = new LoginModel();
    }

    public function handleLogin() {
        $error = null;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $result = $this->model->login($email, $password);

            if ($result) {
                session_start();
                session_regenerate_id(true);
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['user_type'] = $result['user_type'];
                $_SESSION['user_name'] = $result['user_name'];

                header("Location: ../views/register.html"); // Adjust path if needed
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        }
        include(__DIR__ . '/../views/login.php');
    }
}

// Run the login handler
$loginController = new LoginController();
$loginController->handleLogin();
