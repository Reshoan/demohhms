<?php
require_once '../models/RegisterModel.php';

class RegisterController {
    private $model;

    public function __construct() {
        $this->model = new RegisterModel();
    }

    public function register() {
        // Collect common user fields
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';

        // Basic validation
        if (!$name || !$password || !$address || !$phone || !$email || !$user_type) {
            echo "All required fields must be filled.";
            return;
        }

        // Hash password before sending to model
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($user_type === 'customer') {
            // Call registerCustomer procedure via model
            $result = $this->model->registerCustomer($name, $hashedPassword, $address, $phone, $email);
        } 
        else if ($user_type === 'service_provider') {
            $provider_type = isset($_POST['provider_type']) ? $_POST['provider_type'] : '';

            if (!$provider_type) {
                echo "Please select a provider type.";
                return;
            }

            // Common service provider fields
            $sp_experience = isset($_POST['sp_experience']) ? $_POST['sp_experience'] : null;
            $sp_gender = isset($_POST['sp_gender']) ? $_POST['sp_gender'] : null;
            $sp_dob = isset($_POST['sp_dob']) ? $_POST['sp_dob'] : null;
            $sp_nid_no = isset($_POST['sp_nid_no']) ? $_POST['sp_nid_no'] : null;
            $sp_expected_salary = isset($_POST['sp_expected_salary']) ? $_POST['sp_expected_salary'] : null;
            $sp_education = isset($_POST['sp_education']) ? $_POST['sp_education'] : null;
            $sp_certification = isset($_POST['sp_certification']) ? $_POST['sp_certification'] : null;

            // Check if provider type is electrician, plumber, gardener (EPG)
            $epg_types = ['electrician', 'plumber', 'gardener'];

            if (in_array(strtolower($provider_type), $epg_types)) {
                $result = $this->model->registerEPG(
                    $name, $hashedPassword, $address, $phone, $email,
                    $sp_experience, $sp_gender, $sp_dob, $sp_nid_no, 
                    $sp_expected_salary, $sp_education, $sp_certification,
                    $provider_type
                );
            } else {
                // For other provider types, call their respective procedures
                switch (strtolower($provider_type)) {
                    case 'cook':
                        $ck_cuisine = isset($_POST['ck_cuisine']) ? $_POST['ck_cuisine'] : '';
                        $ck_people = isset($_POST['ck_people']) ? $_POST['ck_people'] : null;
                        $result = $this->model->registerCook(
                            $name, $hashedPassword, $address, $phone, $email,
                            $sp_experience, $sp_gender, $sp_dob, $sp_nid_no,
                            $sp_expected_salary, $sp_education, $sp_certification,
                            $provider_type, $ck_cuisine, $ck_people
                        );
                        break;

                    case 'cleaner':
                        $cl_type = isset($_POST['cl_type']) ? $_POST['cl_type'] : '';
                        $result = $this->model->registerCleaner(
                            $name, $hashedPassword, $address, $phone, $email,
                            $sp_experience, $sp_gender, $sp_dob, $sp_nid_no,
                            $sp_expected_salary, $sp_education, $sp_certification,
                            $provider_type, $cl_type
                        );
                        break;

                    case 'security guard':
                        $sg_training = isset($_POST['sg_training']) ? $_POST['sg_training'] : '';
                        $result = $this->model->registerSecurityGuard(
                            $name, $hashedPassword, $address, $phone, $email,
                            $sp_experience, $sp_gender, $sp_dob, $sp_nid_no,
                            $sp_expected_salary, $sp_education, $sp_certification,
                            $provider_type, $sg_training
                        );
                        break;

                    case 'chauffeur':
                        $ch_vehicle_types = isset($_POST['ch_vehicle_types']) ? $_POST['ch_vehicle_types'] : '';
                        $ch_licence_doc = isset($_POST['ch_licence_doc']) ? $_POST['ch_licence_doc'] : '';
                        $ch_licence_valid_until = isset($_POST['ch_licence_valid_until']) ? $_POST['ch_licence_valid_until'] : null;

                        if ($ch_licence_valid_until) {
                            // Convert date to 'd-M-Y' format (Oracle-compatible)
                            $ch_licence_valid_until = date('d-M-Y', strtotime($ch_licence_valid_until));
                        }

                        $result = $this->model->registerChauffer(
                            $name, $hashedPassword, $address, $phone, $email,
                            $sp_experience, $sp_gender, $sp_dob, $sp_nid_no,
                            $sp_expected_salary, $sp_education, $sp_certification,
                            $provider_type, $ch_vehicle_types, $ch_licence_doc, $ch_licence_valid_until
                        );
                        break;

                    case 'baby sitter':
                        $bs_languages = isset($_POST['bs_languages']) ? $_POST['bs_languages'] : '';
                        $result = $this->model->registerBabysitter(
                            $name, $hashedPassword, $address, $phone, $email,
                            $sp_experience, $sp_gender, $sp_dob, $sp_nid_no,
                            $sp_expected_salary, $sp_education, $sp_certification,
                            $provider_type, $bs_languages
                        );
                        break;

                    case 're-locator':
                        $rl_vehicle_type = isset($_POST['rl_vehicle_type']) ? $_POST['rl_vehicle_type'] : '';
                        $result = $this->model->registerRelocator(
                            $name, $hashedPassword, $address, $phone, $email,
                            $sp_experience, $sp_gender, $sp_dob, $sp_nid_no,
                            $sp_expected_salary, $sp_education, $sp_certification,
                            $provider_type, $rl_vehicle_type
                        );
                        break;

                    case 'masseuse':
                        $ms_speciality = isset($_POST['ms_speciality']) ? $_POST['ms_speciality'] : '';
                        $result = $this->model->registerMasseuse(
                            $name, $hashedPassword, $address, $phone, $email,
                            $sp_experience, $sp_gender, $sp_dob, $sp_nid_no,
                            $sp_expected_salary, $sp_education, $sp_certification,
                            $provider_type, $ms_speciality
                        );
                        break;

                    default:
                        echo "Unsupported provider type.";
                        return;
                }
            }
        } else {
            echo "Invalid user type.";
            return;
        }

        // Handle result
        if ($result === true) {
            echo "Registration successful!";
        } else {
            echo "Registration failed: " . $result;
        }
    }
}

// Instantiate and run
$controller = new RegisterController();
$controller->register();
