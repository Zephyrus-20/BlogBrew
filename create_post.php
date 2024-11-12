<?php
session_start();
$user_id = $_SESSION['user_id'] ?? "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new post</title>
    <link rel="stylesheet" href="create_post.css">
</head>

<body>
    <div class="container">
        <form method="POST" action="create_post.php">
            <div class="head">
                <h1>What's on your mind...?</h1>
                <div class="textarea">
                    <textarea name="content" id="content"></textarea>
                </div>
            </div>
            <button class="btn" id="submit">Submit</button>
        </form>
    </div>
</body>

</html>

<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        

        include("config.php");
        
        $content = $_POST["content"] ?? "";

        if (!empty($content) && !empty($user_id)) {
            $content = mysqli_real_escape_string($con, $content);
            $currentDateTime = date('Y-m-d H:i:s');
            $query = "INSERT INTO posts (user_id, content, posted_at) VALUES ('$user_id', '$content', '$currentDateTime')";
            $result = mysqli_query($con, $query);

            if ($result) {
                echo "<script> alert('Post created successfully!');
                window.location.href = 'feed.php'; </script>";
            } else {
                echo "<script> alert('Sorry, could not create post') </script>";
            }
        }

    }
?>