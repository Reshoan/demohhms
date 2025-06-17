<?php
require_once __DIR__ . '/../config/db_connection.php';


class RegisterModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();

    }

    private function callProcedure($procedureName, $params) {
    // Prepare PL/SQL anonymous block to call procedure with bind variables
    $paramPlaceholders = [];

    foreach ($params as $key => $val) {
        if ($key === 'p_dob') {
            // Wrap DOB with TO_DATE for Oracle
            $paramPlaceholders[] = "TO_DATE(:$key, 'YYYY-MM-DD')";
        } else {
            $paramPlaceholders[] = ':' . $key;
        }
    }

    $paramList = implode(', ', $paramPlaceholders);
    $sql = "BEGIN $procedureName($paramList); END;";

    $stid = oci_parse($this->conn, $sql);
    if (!$stid) {
        $e = oci_error($this->conn);
        return "Failed to parse statement: " . $e['message'];
    }

    // Bind parameters
    foreach ($params as $key => &$val) {
        oci_bind_by_name($stid, ':' . $key, $val);
    }

    // Execute
    $result = oci_execute($stid);
    if (!$result) {
        $e = oci_error($stid);
        return "Failed to execute procedure $procedureName: " . $e['message'];
    }

    return true;
}


    // Customer registration
    public function registerCustomer($name, $password, $address, $phone, $email) {
        $params = [
            'p_name' => $name,
            'p_password' => $password,
            'p_address' => $address,
            'p_phone' => $phone,
            'p_email' => $email,
        ];

        return $this->callProcedure('registerCustomer', $params);
    }

    // Service Provider: Electrician, Plumber, Gardener (EPG)
    public function registerEPG($name, $password, $address, $phone, $email,
                                $experience, $gender, $dob, $nid_no,
                                $expected_salary, $education, $certification,
                                $provider_type) {
        $params = [
            'p_name' => $name,
            'p_pass' => $password,              // ✅ corrected key
            'p_addr' => $address,               // ✅ corrected key
            'p_phone' => $phone,
            'p_email' => $email,
            'p_type' => $provider_type,         // ✅ newly added (maps to 'service_provider' user type)
            'p_experience' => $experience,
            'p_gender' => $gender,
            'p_dob' => $dob,
            'p_nid_no' => $nid_no,
            'p_expected_salary' => $expected_salary,
            'p_education' => $education,
            'p_certification' => $certification,
            'p_provider_type' => $provider_type
        ];

        return $this->callProcedure('registerEPG', $params);
    }

    // Cook
    public function registerCook($name, $password, $address, $phone, $email,
                                 $experience, $gender, $dob, $nid_no,
                                 $expected_salary, $education, $certification,
                                 $provider_type, $cuisine, $people) {
        $params = [
            'p_name' => $name,
            'p_password' => $password,
            'p_address' => $address,
            'p_phone' => $phone,
            'p_email' => $email,
            'p_experience' => $experience,
            'p_gender' => $gender,
            'p_dob' => $dob,
            'p_nid_no' => $nid_no,
            'p_expected_salary' => $expected_salary,
            'p_education' => $education,
            'p_certification' => $certification,
            'p_provider_type' => $provider_type,
            'p_cuisine' => $cuisine,
            'p_people' => $people
        ];

        return $this->callProcedure('registerCook', $params);
    }

    // Cleaner
    public function registerCleaner($name, $password, $address, $phone, $email,
                                    $experience, $gender, $dob, $nid_no,
                                    $expected_salary, $education, $certification,
                                    $provider_type, $employment_type) {
        $params = [
            'p_name' => $name,
            'p_password' => $password,
            'p_address' => $address,
            'p_phone' => $phone,
            'p_email' => $email,
            'p_experience' => $experience,
            'p_gender' => $gender,
            'p_dob' => $dob,
            'p_nid_no' => $nid_no,
            'p_expected_salary' => $expected_salary,
            'p_education' => $education,
            'p_certification' => $certification,
            'p_provider_type' => $provider_type,
            'p_employment_type' => $employment_type
        ];

        return $this->callProcedure('registerCleaner', $params);
    }

    // Security Guard
    public function registerSecurityGuard($name, $password, $address, $phone, $email,
                                          $experience, $gender, $dob, $nid_no,
                                          $expected_salary, $education, $certification,
                                          $provider_type, $training) {
        $params = [
            'p_name' => $name,
            'p_password' => $password,
            'p_address' => $address,
            'p_phone' => $phone,
            'p_email' => $email,
            'p_experience' => $experience,
            'p_gender' => $gender,
            'p_dob' => $dob,
            'p_nid_no' => $nid_no,
            'p_expected_salary' => $expected_salary,
            'p_education' => $education,
            'p_certification' => $certification,
            'p_provider_type' => $provider_type,
            'p_training' => $training
        ];

        return $this->callProcedure('registerSecurityGuard', $params);
    }

    // Chauffer
    public function registerChauffer($name, $password, $address, $phone, $email,
                                     $experience, $gender, $dob, $nid_no,
                                     $expected_salary, $education, $certification,
                                     $provider_type, $vehicle_types, $licence_doc, $licence_valid_until) {
        $params = [
            'p_name' => $name,
            'p_password' => $password,
            'p_address' => $address,
            'p_phone' => $phone,
            'p_email' => $email,
            'p_experience' => $experience,
            'p_gender' => $gender,
            'p_dob' => $dob,
            'p_nid_no' => $nid_no,
            'p_expected_salary' => $expected_salary,
            'p_education' => $education,
            'p_certification' => $certification,
            'p_provider_type' => $provider_type,
            'p_vehicle_types' => $vehicle_types,
            'p_licence_doc' => $licence_doc,
            'p_licence_valid_until' => $licence_valid_until
        ];

        return $this->callProcedure('registerChauffer', $params);
    }

    // Babysitter
    public function registerBabysitter($name, $password, $address, $phone, $email,
                                       $experience, $gender, $dob, $nid_no,
                                       $expected_salary, $education, $certification,
                                       $provider_type, $languages) {
        $params = [
            'p_name' => $name,
            'p_password' => $password,
            'p_address' => $address,
            'p_phone' => $phone,
            'p_email' => $email,
            'p_experience' => $experience,
            'p_gender' => $gender,
            'p_dob' => $dob,
            'p_nid_no' => $nid_no,
            'p_expected_salary' => $expected_salary,
            'p_education' => $education,
            'p_certification' => $certification,
            'p_provider_type' => $provider_type,
            'p_languages' => $languages
        ];

        return $this->callProcedure('registerBabysitter', $params);
    }

    // Relocator
    public function registerRelocator($name, $password, $address, $phone, $email,
                                     $experience, $gender, $dob, $nid_no,
                                     $expected_salary, $education, $certification,
                                     $provider_type, $vehicle_type) {
        $params = [
            'p_name' => $name,
            'p_password' => $password,
            'p_address' => $address,
            'p_phone' => $phone,
            'p_email' => $email,
            'p_experience' => $experience,
            'p_gender' => $gender,
            'p_dob' => $dob,
            'p_nid_no' => $nid_no,
            'p_expected_salary' => $expected_salary,
            'p_education' => $education,
            'p_certification' => $certification,
            'p_provider_type' => $provider_type,
            'p_vehicle_type' => $vehicle_type
        ];

        return $this->callProcedure('registerRelocator', $params);
    }

    // Masseuse
    public function registerMasseuse($name, $password, $address, $phone, $email,
                                    $experience, $gender, $dob, $nid_no,
                                    $expected_salary, $education, $certification,
                                    $provider_type, $speciality) {
        $params = [
            'p_name' => $name,
            'p_password' => $password,
            'p_address' => $address,
            'p_phone' => $phone,
            'p_email' => $email,
            'p_experience' => $experience,
            'p_gender' => $gender,
            'p_dob' => $dob,
            'p_nid_no' => $nid_no,
            'p_expected_salary' => $expected_salary,
            'p_education' => $education,
            'p_certification' => $certification,
            'p_provider_type' => $provider_type,
            'p_speciality' => $speciality
        ];

        return $this->callProcedure('registerMasseuse', $params);
    }

    public function __destruct() {
        oci_close($this->conn);
    }
}
