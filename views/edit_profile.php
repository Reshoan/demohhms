<?php
if (!isset($_SESSION['user_id'])) {
    echo "<p>Unauthorized access.</p>";
    exit;
}

$userType = $_SESSION['user_type'];
$userId = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>
    <h2>Edit Your Profile</h2>

    <form method="POST" action="../controllers/ProfileController.php">
        <input type="hidden" name="action" value="update_profile">
        <input type="hidden" name="user_id" value="<?= $userId ?>">

        <h3>Basic Information</h3>
        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($userData['us_name']) ?>"><br>

        

        <label>Address:</label><br>
        <input type="text" name="address" value="<?= htmlspecialchars($userData['us_address']) ?>"><br>

        <label>Phone:</label><br>
        <input type="text" name="phone" value="<?= htmlspecialchars($userData['us_phone_no']) ?>"><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($userData['us_email']) ?>"><br>

        <?php if ($userType === 'service_provider'): ?>
            <h3>Service Provider Information</h3>
            <label>Experience (years):</label><br>
            <input type="number" name="experience" value="<?= $userData['sp_experience'] ?>"><br>

            <label>Gender:</label><br>
            <input type="text" name="gender" value="<?= $userData['sp_gender'] ?>"><br>

            <label>Date of Birth:</label><br>
            <input type="date" name="dob" value="<?= $userData['sp_dob'] ?>"><br>

            <label>NID No:</label><br>
            <input type="text" name="nid_no" value="<?= $userData['sp_nid_no'] ?>"><br>

            <label>Expected Salary:</label><br>
            <input type="number" name="expected_salary" value="<?= $userData['sp_expected_salary'] ?>"><br>

            <label>Education:</label><br>
            <input type="text" name="education" value="<?= $userData['sp_education'] ?>"><br>

            <label>Certification:</label><br>
            <input type="text" name="certification" value="<?= $userData['sp_certification'] ?>"><br>

            <?php
                $spType = strtolower(isset($userData['sp_type']) ? $userData['sp_type'] : '');
                if ($spType === 'cleaner'): ?>
                    <h3>Cleaner Details</h3>
                    <label>Employment Type:</label><br>
                    <input type="text" name="cl_employment_type" value="<?= $userData['cl_employment_type'] ?>"><br>

                <?php elseif ($spType === 'cook'): ?>
                    <h3>Cook Details</h3>
                    <label>Cuisine Expertise:</label><br>
                    <input type="text" name="ck_cuisine_expertise" value="<?= $userData['ck_cuisine_expertise'] ?>"><br>
                    <label>Max People Served:</label><br>
                    <input type="number" name="ck_max_people_served" value="<?= $userData['ck_max_people_served'] ?>"><br>

                <?php elseif ($spType === 'chauffeur'): ?>
                    <h3>Chauffeur Details</h3>
                    <label>Vehicle Types:</label><br>
                    <input type="text" name="ch_vehicle_types" value="<?= $userData['ch_vehicle_types'] ?>"><br>
                    <label>License Document:</label><br>
                    <input type="text" name="ch_licence_doc" value="<?= $userData['ch_licence_doc'] ?>"><br>
                    <label>License Valid Until:</label><br>
                    <input type="date" name="ch_licence_valid_until" value="<?= $userData['ch_licence_valid_until'] ?>"><br>

                <?php elseif ($spType === 'security guard'): ?>
                    <h3>Security Guard Details</h3>
                    <label>Weapons Training (Y/N):</label><br>
                    <input type="text" name="sg_weapons_training" value="<?= $userData['sg_weapons_training'] ?>"><br>

                <?php elseif ($spType === 're-locator'): ?>
                    <h3>Relocator Details</h3>
                    <label>Vehicle Type:</label><br>
                    <input type="text" name="rl_vehicle_type" value="<?= $userData['rl_vehicle_type'] ?>"><br>

                <?php elseif ($spType === 'baby sitter'): ?>
                    <h3>Babysitter Details</h3>
                    <label>Languages:</label><br>
                    <input type="text" name="bs_languages" value="<?= $userData['bs_languages'] ?>"><br>

                <?php elseif ($spType === 'masseuse'): ?>
                    <h3>Masseuse Details</h3>
                    <label>Speciality:</label><br>
                    <input type="text" name="ms_speciality" value="<?= $userData['ms_speciality'] ?>"><br>
            <?php endif; ?>
        <?php endif; ?>

        <br><button type="submit">Update Profile</button>
    </form>
</body>
</html>
