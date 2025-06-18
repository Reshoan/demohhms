<?php
require_once(__DIR__ . '/../config/db_connection.php');

class ProfileModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function getProfileById($userId) {
        $stmt = oci_parse($this->conn, "BEGIN getProfile(:p_user_id, :p_name, :p_phone, :p_email, :p_address, :p_us_type, :p_experience, :p_gender, :p_dob, :p_nid_no, :p_expected_salary, :p_education, :p_certification, :p_status, :p_sp_type, :p_languages, :p_vehicle_types, :p_licence_doc, :p_valid_until, :p_employment_type, :p_cuisine_expertise, :p_max_people_served, :p_speciality, :p_vehicle_type, :p_weapons_training); END;");

        // Declare PHP variables
        $fields = [
            'p_name' => null, 'p_phone' => null, 'p_email' => null, 'p_address' => null, 'p_us_type' => null,
            'p_experience' => null, 'p_gender' => null, 'p_dob' => null, 'p_nid_no' => null,
            'p_expected_salary' => null, 'p_education' => null, 'p_certification' => null, 'p_status' => null,
            'p_sp_type' => null, 'p_languages' => null, 'p_vehicle_types' => null, 'p_licence_doc' => null,
            'p_valid_until' => null, 'p_employment_type' => null, 'p_cuisine_expertise' => null,
            'p_max_people_served' => null, 'p_speciality' => null, 'p_vehicle_type' => null,
            'p_weapons_training' => null
        ];

        oci_bind_by_name($stmt, ":p_user_id", $userId);
        foreach ($fields as $key => &$val) {
            // Lengths can be adjusted as per your schema
            $length = in_array($key, ['p_valid_until', 'p_max_people_served', 'p_experience']) ? -1 : 100;
            oci_bind_by_name($stmt, ":$key", $val, $length);
        }

        if (!oci_execute($stmt)) {
            $e = oci_error($stmt);
            throw new Exception("Oracle execution error: " . $e['message']);
        }

        return [
            'us_name' => $fields['p_name'],
            'us_phone_no' => $fields['p_phone'],
            'us_email' => $fields['p_email'],
            'us_address' => $fields['p_address'],
            'us_type' => $fields['p_us_type'],
            'sp_type' => $fields['p_sp_type'],
            'sp_experience' => $fields['p_experience'],
            'sp_gender' => $fields['p_gender'],
            'sp_dob' => $fields['p_dob'],
            'sp_nid_no' => $fields['p_nid_no'],
            'sp_expected_salary' => $fields['p_expected_salary'],
            'sp_education' => $fields['p_education'],
            'sp_certification' => $fields['p_certification'],
            'sp_status' => $fields['p_status'],
            'bs_languages' => $fields['p_languages'],
            'ch_vehicle_types' => $fields['p_vehicle_types'],
            'ch_licence_doc' => $fields['p_licence_doc'],
            'ch_licence_valid_until' => $fields['p_valid_until'],
            'cl_employment_type' => $fields['p_employment_type'],
            'ck_cuisine_expertise' => $fields['p_cuisine_expertise'],
            'ck_max_people_served' => $fields['p_max_people_served'],
            'ms_speciality' => $fields['p_speciality'],
            'rl_vehicle_type' => $fields['p_vehicle_type'],
            'sg_weapons_training' => $fields['p_weapons_training']
        ];
    }
}
