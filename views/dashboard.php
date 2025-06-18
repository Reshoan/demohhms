<h1>Welcome, <?= htmlspecialchars($profile['name']) ?></h1>
<p>Email: <?= htmlspecialchars($profile['email']) ?></p>
<p>Phone: <?= htmlspecialchars($profile['phone']) ?></p>

<?php if ($user_type == 'cleaner'): ?>
    <p>Experience: <?= htmlspecialchars($profile['experience']) ?> years</p>
    <p>Cleaning Types: <?= htmlspecialchars($profile['cleaning_types']) ?></p>
<?php elseif ($user_type == 'cook'): ?>
    <p>Experience: <?= htmlspecialchars($profile['experience']) ?> years</p>
    <p>Specialties: <?= htmlspecialchars($profile['specialties']) ?></p>
<?php endif; ?>

<a href="edit_profile.php">Edit Profile</a>
