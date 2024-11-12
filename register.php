<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Registration</title>
    <link rel="stylesheet" href="register.css">
</head>

<body>
    <div class="container">
        <form method="POST" action="register.php" enctype="multipart/form-data">
            <h2 class="heading">Create Your Account</h2>
            <p class="sub">Fill in the details below to sign up</p>
            <div class="input-group">
                <input type="text" name="username" required placeholder="Username">
            </div>
            <div class="input-group">
                <input type="email" name="email" required placeholder="Email">
            </div>
            <div class="input-group">
                <input type="number" name="phone" required placeholder="Phone">
            </div>
            <div class="input-group">
                <input type="password" name="password1" required placeholder="Password">
            </div>
            <div class="input-group">
                <input type="password" name="password2" required placeholder="Confirm Password">
            </div>
            <div class="input-group">
                <label for="profile_pic">Upload Profile Picture</label>
                <input type="file" id="profile_pic" name="profile_pic" accept="image/*" required>
            </div>
            <button type="submit" class="btn">Sign Up</button>
        </form>
    </div>

    <?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include("config.php");

            $username = $_POST['username'] ?? "";
            $email = $_POST['email'] ?? "";
            $phone = $_POST['phone'] ?? "";
            $password1 = $_POST['password1'] ?? "";
            $password2 = $_POST['password2'] ?? "";

            if ($password1 != $password2) {
                echo "<script> alert('Passwords do not match!'); </script>";
                exit;
            }

            $uploadError = $_FILES['profile_pic']['error'] ?? UPLOAD_ERR_NO_FILE;
            if ($uploadError === UPLOAD_ERR_OK) {
                $uploadDir = "uploads/";
                $fileName = basename($_FILES["profile_pic"]["name"] ?? "");
                $targetFilePath = $uploadDir . $fileName;

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"] ?? "", $targetFilePath)) {
                    $profilePicPath = $targetFilePath;

                    $currentDateTime = date('Y-m-d H:i:s');
                    $defaultBio = "Welcome to my profile!";

                    $insert_data = "INSERT INTO user (username, email, phone, password, profile_pic, bio, created_at) VALUES ('$username', '$email', '$phone', '$password1', '$profilePicPath', '$defaultBio', '$currentDateTime')";


                    if (mysqli_query($con, $insert_data)) {
                        echo "<script>
                            alert('Image uploaded successfully! Redirecting to login page');
                            window.location.href = 'login.php';
                        </script>";
                    } else {
                        echo "<script> alert('Failed to insert data into the database.'); </script>";
                    }
                } else {
                    echo "<script> alert('Failed to upload the image.'); </script>";
                    exit;
                }
            } else {
                echo "<script> alert('Please upload a valid image file.'); </script>";
                exit;
            }
        }
    ?>
</body>

</html>