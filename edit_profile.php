<?php

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'] ?? '';
$email = $_SESSION['email'] ?? '';
$phone = $_SESSION['phone'] ?? '';
$bio = $_SESSION['bio'] ?? '';
$profilePicPath = $_SESSION['profile_picture'] ?? 'uploads/default_profile_pic.svg';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="edit_profile.css">
</head>

<body>
    <div class="container">
        <h2>Edit Profile</h2>
        <form action="update_profile.php" method="POST" enctype="multipart/form-data">

            <div class="profile-picture-container">
                <label for="profile-picture">Profile Picture</label>
                <div class="current-pic">
                    <img id="profile-picture" src="<?php echo $profilePicPath; ?>" alt="Current Profile Picture">
                </div>
                <input type="file" name="profile_pic" accept="image/*">
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" required value="<?php echo $username; ?>">
            </div>

            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea name="bio" id="bio" rows="4" placeholder="Tell something about yourself..."><?php echo $bio; ?></textarea>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required value="<?php echo $email; ?>">
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" name="phone" id="phone" required value="<?php echo $phone; ?>">
            </div>

            <button type="submit">Save Changes</button>
        </form>
    </div>

</body>

</html>