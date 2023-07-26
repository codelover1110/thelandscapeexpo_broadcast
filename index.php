<?php
session_start();
session_destroy(); // Remove all session variables and destroy the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the username is "admin" and the password is "password"
    if (strtolower($username) === "tle" && $password === "2023expo") {
        session_start(); // Start a new session
        // If the credentials are correct, redirect to dashboard.php
        $_SESSION["logged_in"] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        // If the credentials are incorrect, show an error message
        $error_message = "Invalid username or password. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <style>
        .form-body {
            font-family: Arial, sans-serif;
            /* background-color: #f0f0f0; */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 98vh;
            flex-direction: column
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label, input {
            display: block;
            width: 100%;
        }
        input[type="text"], input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="form-body">
        <div style="margin-bottom: 10px;">
            <a id="tle-logoo" href="https://thelandscapeexpo.com"><img class="logo-20233" src="https://thelandscapeexpo.com/images/logos/TLE-A-2023-Logo-No-Dates.png" style="
                width: 230px;
                display: block;
                float: left;
            "></a>
        </div>
        <div class="container">
            <h2>Broadcast Login</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Sign In">
                </div>
                <?php if (isset($error_message)) { ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php } ?>
            </form>
        </div>
    </div>
</body>
</html>
