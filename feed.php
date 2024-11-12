<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include("config.php");

$query = "SELECT posts.*, user.username, user.profile_pic 
          FROM posts 
          JOIN user ON posts.user_id = user.user_id 
          ORDER BY posts.posted_at DESC";
$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
    <link rel="stylesheet" href="feed.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <a href="profile.php">
                <img id="dp" class="profile-icon" src="<?php echo $_SESSION['profile_picture'] ?? 'uploads/default_profile_pic.svg'; ?>" alt="Profile Icon">
            </a>
            <h1>Feed</h1>
        </div>

        <div class="feed-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($post = mysqli_fetch_assoc($result)) {
                    echo "<div class='post'>";
                    echo "<div class='post-header'>";
                    echo "<div class='profile-icon'> <img id='dp' src='{$post['profile_pic']}' alt='User Profile' > </div>";
                    echo "<span class='username'>{$post['username']}</span>";
                    echo "<span class='time'>{$post['posted_at']}</span>";
                    echo "</div>";
                    echo "<p class='content'>{$post['content']}</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No posts to display.</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>