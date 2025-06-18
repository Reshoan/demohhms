<?php
require_once(__DIR__ . '/../config/db_connection.php');
$conn = Database::getConnection();

$p_user_id = 15;  // Replace with session later

// Declare variables
$p_us_type = $p_name = $p_phone = $p_email = $p_address = $p_sp_type = null;
$p_experience = $p_gender = $p_dob = $p_nid_no = $p_expected_salary = $p_education = $p_certification = null;
$p_status = null; // You missed this in your version

// Type-specific
$p_ck_cuisine_expertise = $p_ck_max_people_served = null;
$p_ch_vehicle_types = $p_ch_licence_doc = $p_ch_licence_valid = null;
$p_cl_employment_type = null;
$p_sg_weapons_training = null;
$p_rl_vehicle_type = null;
$p_bs_languages = null;
$p_ms_speciality = null;

// Step 1: Base profile
$stmt_base = oci_parse($conn, "BEGIN getBaseProfile(:p_user_id, :p_name, :p_phone, :p_email, :p_address, :p_us_type); END;");
oci_bind_by_name($stmt_base, ":p_user_id", $p_user_id);
oci_bind_by_name($stmt_base, ":p_name", $p_name, 100);
oci_bind_by_name($stmt_base, ":p_phone", $p_phone, 20);
oci_bind_by_name($stmt_base, ":p_email", $p_email, 100);
oci_bind_by_name($stmt_base, ":p_address", $p_address, 200);
oci_bind_by_name($stmt_base, ":p_us_type", $p_us_type, 20);

$success = oci_execute($stmt_base);
if (!$success) {
    $e = oci_error($stmt_base);
    throw new Exception("Oracle execution error for base: " . $e['message']);
}

// Step 2: If service provider, get EPG info
if ($p_us_type !== 'customer') {

    $stmt_epg = oci_parse($conn, "BEGIN getEPGProfile(:p_user_id, :p_experience, :p_gender, :p_dob, :p_nid_no, :p_expected_salary, :p_education, :p_certification, :p_status, :p_sp_type); END;");

    oci_bind_by_name($stmt_epg, ":p_user_id", $p_user_id);
    oci_bind_by_name($stmt_epg, ":p_experience", $p_experience, 1000);
    oci_bind_by_name($stmt_epg, ":p_gender", $p_gender, 110);           // +1 buffer
    oci_bind_by_name($stmt_epg, ":p_dob", $p_dob, 100);                     // DATE type, no buffer needed
    oci_bind_by_name($stmt_epg, ":p_nid_no", $p_nid_no, 210);
    oci_bind_by_name($stmt_epg, ":p_expected_salary", $p_expected_salary);
    oci_bind_by_name($stmt_epg, ":p_education", $p_education, 1010);
    oci_bind_by_name($stmt_epg, ":p_certification", $p_certification, 1010);
    oci_bind_by_name($stmt_epg, ":p_status", $p_status, 20);           // CHAR(1) needs buffer 2
    oci_bind_by_name($stmt_epg, ":p_sp_type", $p_sp_type, 310);


    $success = oci_execute($stmt_epg);
    if (!$success) {
        $e = oci_error($stmt_epg);
        throw new Exception("Oracle execution error for EPG: " . $e['message']);
    }

    // Service-type-specific info
    switch (strtolower($p_sp_type)) {
        case 'cleaner':
            $stmt = oci_parse($conn, "BEGIN getCleanerProfile(:p_user_id, :p_employment_type); END;");
            oci_bind_by_name($stmt, ":p_user_id", $p_user_id);
            oci_bind_by_name($stmt, ":p_employment_type", $p_cl_employment_type, 20);
            break;
        case 'cook':
            $stmt = oci_parse($conn, "BEGIN getCookProfile(:p_user_id, :p_cuisine, :p_max); END;");
            oci_bind_by_name($stmt, ":p_user_id", $p_user_id);
            oci_bind_by_name($stmt, ":p_cuisine", $p_ck_cuisine_expertise, 100);
            oci_bind_by_name($stmt, ":p_max", $p_ck_max_people_served, 1000);
            break;
        case 'chauffeur':
            $stmt = oci_parse($conn, "BEGIN getChauffeurProfile(:p_user_id, :p_vehicle, :p_doc, :p_valid); END;");
            oci_bind_by_name($stmt, ":p_user_id", $p_user_id);
            oci_bind_by_name($stmt, ":p_vehicle", $p_ch_vehicle_types, 100);
            oci_bind_by_name($stmt, ":p_doc", $p_ch_licence_doc, 100);
            oci_bind_by_name($stmt, ":p_valid", $p_ch_licence_valid, 100);
            break;
        case 'security guard':
            $stmt = oci_parse($conn, "BEGIN getSecurityGuardProfile(:p_user_id, :p_training); END;");
            oci_bind_by_name($stmt, ":p_user_id", $p_user_id);
            oci_bind_by_name($stmt, ":p_training", $p_sg_weapons_training, 1);
            break;
        case 're-locator':
            $stmt = oci_parse($conn, "BEGIN getReLocatorProfile(:p_user_id, :p_vehicle_type); END;");
            oci_bind_by_name($stmt, ":p_user_id", $p_user_id);
            oci_bind_by_name($stmt, ":p_vehicle_type", $p_rl_vehicle_type, 100);
            break;
        case 'baby sitter':
            $stmt = oci_parse($conn, "BEGIN getBabySitterProfile(:p_user_id, :p_languages); END;");
            oci_bind_by_name($stmt, ":p_user_id", $p_user_id);
            oci_bind_by_name($stmt, ":p_languages", $p_bs_languages, 100);
            break;
        case 'masseuse':
            $stmt = oci_parse($conn, "BEGIN getMasseuseProfile(:p_user_id, :p_speciality); END;");
            oci_bind_by_name($stmt, ":p_user_id", $p_user_id);
            oci_bind_by_name($stmt, ":p_speciality", $p_ms_speciality, 100);
            break;
    }

    if (isset($stmt)) {
        $success = oci_execute($stmt);
        if (!$success) {
            $e = oci_error($stmt);
            throw new Exception("Oracle execution error for $p_sp_type: " . $e['message']);
        }
    }
}

// ✅ Display the gathered data
echo "<h2>Profile</h2>";
echo "Name: $p_name<br>Email: $p_email<br>Phone: $p_phone<br>Address: $p_address<br>User Type: $p_us_type<br>";

if ($p_us_type !== 'customer') {
    echo "SP Type: $p_sp_type<br>Status: $p_status<br>Gender: $p_gender<br>DOB: $p_dob<br>NID: $p_nid_no<br>Salary: $p_expected_salary<br>Education: $p_education<br>Certification: $p_certification<br>Experience: $p_experience<br>";

    switch (strtolower($p_sp_type)) {
        case 'cleaner':
            echo "Employment Type: $p_cl_employment_type<br>";
            break;
        case 'cook':
            echo "Cuisine Expertise: $p_ck_cuisine_expertise<br>";
            echo "Max People Served: $p_ck_max_people_served<br>";
            break;
        case 'chauffeur':
            echo "Vehicle Types: $p_ch_vehicle_types<br>";
            echo "Licence Doc: $p_ch_licence_doc<br>";
            echo "Licence Validity: $p_ch_licence_valid<br>";
            break;
        case 'security guard':
            echo "Weapons Training: $p_sg_weapons_training<br>";
            break;
        case 're-locator':
            echo "Vehicle Type: $p_rl_vehicle_type<br>";
            break;
        case 'baby sitter':
            echo "Languages: $p_bs_languages<br>";
            break;
        case 'masseuse':
            echo "Speciality: $p_ms_speciality<br>";
            break;
    }
}
?>
