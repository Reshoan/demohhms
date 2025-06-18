<?php
session_start();
require_once(__DIR__ . '/../models/ProfileModel.php');

$action = isset($_POST['action']) ? $_POST['action'] : null;

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized";
    exit;
}

$userId = $_SESSION['user_id'];
$controller = new ProfileModel();

if ($action === 'update_profile') {
    // Implement update logic later
    echo "Update logic goes here.";
    exit;
} else {
    try {
        $userData = $controller->getProfileById($userId);
        // Pass data to the view
        include(__DIR__ . '/../views/edit_profile.php');
    } catch (Exception $e) {
        echo "Error loading profile: " . $e->getMessage();
    }
}
