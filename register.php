<?php
require_once "dbconnection.php";
require_once "session.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $fullname = mysqli_real_escape_string($dbcon, $_POST['name']);
    $phn = mysqli_real_escape_string($dbcon, $_POST['ph']);
    $email = mysqli_real_escape_string($dbcon, $_POST['email']);
    $password = mysqli_real_escape_string($dbcon, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($dbcon, $_POST['confirm_password']);

    // Check if email already exists
    $check_query = "SELECT * FROM `users` WHERE `email` = '$email'";
    $check_result = mysqli_query($dbcon, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Email already taken. Please choose a different email.');</script>";
    } else {
        // Proceed with registration
        if ($password == $confirm_password) {
            $qry2 = "INSERT INTO `login` (`email`, `password`) VALUES ('$email', '$password')";
            $qry = "INSERT INTO `users` (`email`, `name`, `pnumber`) VALUES ('$email', '$fullname', '$phn')";
            $run = mysqli_query($dbcon, $qry);
            $run2 = mysqli_query($dbcon, $qry2);

            if ($run && $run2) {
                $_SESSION['uid'] = mysqli_insert_id($dbcon); 
                $_SESSION['email'] = $email;
                echo "<script>alert('Registration Successful :)'); window.location='index.php';</script>";
                exit;
            } else {
                echo "<script>alert('Registration failed. Please try again later.'); </script>";
            }
        } else {
            echo "<script>alert('Password mismatched!!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('images/brr.png');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body><br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2 style="color:green">Register</h2>
            <p>Please fill this form to create an account.</p>
            <form action="" method="post">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Phone Num.</label>
                    <input type="text" name="ph" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-danger" value="Register">
                </div>
                <p>Already have an account? <a href="index.php" style="color: red;">Login here</a>.</p>
            </form>
        </div>
    </div>
    <hr>
    <p>Notice: If the email ID is registered before, it will not respond.</p>
    <p>In this case, reset your password or register with a different email ID.</p>
</div>
</body>
</html>
