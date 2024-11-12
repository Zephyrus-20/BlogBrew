<?php

    session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: login.php");
        exit();
    }

    include("config.php");

    $username = $email = $phone = $bio = '';
    $profilePicPath = 'uploads/default_profile_pic.svg';

    $email = $_SESSION['email'];
    $query = "SELECT user_id, username, phone, bio, profile_pic FROM user WHERE email='$email' ";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $userId = $row['user_id'];
        $username = $row['username'];
        $phone = $row['phone'];
        $bio = $row['bio'];
        $profilePicPath = $row['profile_pic'];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $bio = $_POST['bio'] ?? '';

        
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = "uploads/";
            $fileName = basename($_FILES["profile_pic"]["name"]);
            $targetFilePath = $uploadDir . $fileName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $targetFilePath)) {
                $profilePicPath = $targetFilePath; 
            }
        }

        $update_query = "UPDATE user SET username='$username', email='$email', phone='$phone', bio='$bio', profile_pic='$profilePicPath' WHERE user_id='$userId'";

        if (mysqli_query($con, $update_query)) {
        
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['bio'] = $bio;
            $_SESSION['profile_picture'] = $profilePicPath;

            echo "<script>alert('Profile updated successfully!'); window.location.href = 'profile.php';</script>";
        } else {
            echo "<script>alert('Failed to update profile.');</script>";
        }
    }


?>