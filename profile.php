<?php

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include("config.php");

$username = $_SESSION['username'] ?? 'User';
$profilePicPath =  $_SESSION['profile_picture'] ?? 'uploads/default_profile_pic.svg';

$user_id = $_SESSION['user_id'];
$query_posts = "SELECT * FROM posts WHERE user_id = '$user_id' ORDER BY posted_at DESC";
$result_posts = mysqli_query($con, $query_posts);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>

<body>
    <div class="container">
        <div class="profile-sidebar">
            <div class="profile-picture-container">
                <img id="profile-picture" src="http://localhost/OSP/<?php echo $profilePicPath; ?>" alt="User Profile Picture">
            </div>
            <div class="user-details">
                <h2 id="username"><?php echo $username; ?></h2>
                <p id="user-bio"><?php echo $_SESSION['bio'] ?? 'This is a short bio about the user.'; ?></p>
            </div>

            <div class="icon-container">
                <img id="edit-icon" class="icon" src="Assets/Edit_icon.svg" alt="Edit profile">
            </div>

            <div class="icon-container">
                <img id="feed-icon" class="icon" src="Assets/Home_icon.svg" alt="Go to feed">
            </div>
        </div>

        <div class="main-content">
            <div class="posts">
                <div class="head">
                    <h3>Your Posts</h3>
                    <div class="create-post-container">
                        <img id="create-post" src="Assets/Add_icon.svg" alt="Create new post">
                    </div>
                </div>

                <?php while ($post = mysqli_fetch_assoc($result_posts)) { ?>
                    <div class="post">
                        <p><?php echo $post['content']; ?></p>
                        <small>Posted on: <?php echo date("d M Y, H:i", strtotime($post['posted_at'])); ?></small>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("edit-icon").addEventListener("click", function() {
            const url = "edit_profile.php";
            window.open(url, "_self");
        });

        document.getElementById("create-post").addEventListener("click", function() {
            const url = "create_post.php";
            window.open(url, "_self");
        });

        document.getElementById("feed-icon").addEventListener("click", function() {
            const url = "feed.php";
            window.open(url, "_self");
        });
    </script>
</body>

</html>