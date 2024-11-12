<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="container">
        <div class="alert" id="passwordAlert" style="display: none;">
            <p>Incorrect Password!</p>
            <button class="btn" onclick="closeAlert('passwordAlert')">OK</button>
        </div>
        <div class="alert" id="emailAlert" style="display: none;">
            <p>Incorrect Email!</p>
            <button class="btn" onclick="closeAlert('emailAlert')">OK</button>
        </div>
        <form method="POST">
            <h2 class="heading">Welcome Back</h2>
            <p class="sub">Login to access your account</p>
            <div class="input-group">
                <input type="email" name="email" required placeholder="Email">
            </div>
            <div class="input-group">
                <input type="password" name="password" required placeholder="Password">
            </div>
            <button type="submit" class="btn">Login</button>
            <p class="heading redirect">Not a member?</p>
            <button type="button" class="btn" id="register" onclick="redirectToRegister()">Register</button>
        </form>
    </div>

    <script>
        function showAlert(alertId) {
            document.getElementById(alertId).style.display = 'block';
        }

        function closeAlert(alertId) {
            document.getElementById(alertId).style.display = 'none';
        }

        function redirectToRegister() {
            window.location.href = 'register.php';
        }
    </script>

    <?php

        session_start();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include("config.php");

            $email = $_POST["email"] ?? "";
            $password = $_POST["password"] ?? "";

            $sql = "SELECT * FROM user WHERE email = '$email'";
            $result = mysqli_query($con, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);


                if ($row['password'] === $password) {
                    
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['profile_picture'] = $row['profile_pic'];
                    $_SESSION['bio'] = $row['bio'];
                    $_SESSION['phone'] = $row['phone'];

                    echo "<script> window.location.href = 'feed.php' </script>";
                } else {
                    echo "<script> showAlert('passwordAlert'); </script>";
                }
            } else {
                echo "<script> showAlert('emailAlert'); </script>";
            }
        }

    ?>


</body>

</html>