<?php
session_start();

function send_msg($message) {
    $serverKey = 'AAAAq33pIeo:APA91bHEIz05h_ENYhuaGyfTpXHDQr4JXzRQLKYCZYa9ZcIJ2yi9kSnsVJWUH41v_9tAHyq74p5jgqyy8rqO7Iqi89-0OIPGYY1vRJ_OoC739_PHIyEyst54Z7Qg_xzpgIz-WFOi7p48';

    $topic = 'broad_messages';
    $data = ['field' => 'broad_messages'];

    // Prepare the FCM request payload
    $payload = [
        'data' => $data,
        'notification' => [
            'title' => 'New Message',
            'body' => $message,
            'android_channel_id' => 'tle_channel',
            'sound' => 'Tri-tone',
        ],
        'to' => '/topics/' . $topic,
    ];

    // Prepare the headers
    $headers = [
        'Authorization: key=' . $serverKey,
        'Content-Type: application/json',
    ];

    // Initialize cURL session
    $ch = curl_init('https://fcm.googleapis.com/fcm/send');

    // Set cURL options
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Adjust this if needed

    // Set the POST data
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    // Execute cURL request
    $result = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Error: ' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);

    return $result;

    // Check the response
    // if ($result !== false) {
    //     echo 'Message sent successfully!';
    // } else {
    //     echo 'Failed to send the message.';
    // }
}

// Check if the user is logged in
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: index.php");
    exit();
}

// Clear the previous error message if any
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data from the dashboard
    // Add your custom processing logic here
    $inputData = $_POST["inputData"];

    $msg_firebase = send_msg($inputData);

    if ($msg_firebase !== false) {
        echo 'Message sent successfully!';
        // Example: Show the input data in the dashboard (replace this with your logic)
        // $message = "You entered: " . htmlspecialchars($inputData);

        $servername = "localhost";
        $username = "land_patchew";
        $password = "59q2GB6k$3";
        $dbname = "land_landscap_lollive";
        $table_name = "broadcast";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $user_name = 'TLE';

        // Get the current time for created_at field
        $created_at = date("Y-m-d H:i:s");

        // Prepare and execute the SQL query to insert the message content, user, and created_at into the table
        $sql = "INSERT INTO $table_name (message, user, created_at) VALUES ('$inputData', '$user_name', '$created_at')";
        if ($conn->query($sql) === TRUE) {
            echo "Message saved successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        // Close the database connection
        $conn->close();

    } else {
        echo 'Failed to send the message.';
    }
}

   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        .form-body {
            font-family: Arial, sans-serif;
            /* background-color: #f0f0f0; */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column
        }
        .container {
            /* background-color: #fff; */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label, input {
            display: block;
            width: 100%;
        }
        input[type="text"] {
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
        .instruction {
            text-align: center;
        }
        textarea {
            resize: vertical; /* Allow vertical resizing only */
            overflow-y: hidden; /* Hide vertical scrollbar when not needed */
            min-height: 100px; /* Set a minimum height for the textarea */
            width: 100%;
        }
    </style>
    <script>
        function confirmSubmit() {
            return confirm("Are you sure you want to submit the form?");
        }
    </script>
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
            <h1>TLE Broadcast Message</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="return confirmSubmit();">
                <div class="form-group">
                    <label for="inputData">Enter the text of your broadcast message:</label>
                    <textarea id="inputData" name="inputData" required></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" value="Send Now">
                </div>
            </form>
            <p class="instruction" style="font-size: 23px;"><strong>Please note:</strong> When you click on the Send Now button, it will be sent to all users who have the app open or allowed notifications.  <strong>This cannot be undone.</strong></p>
            <?php if (isset($message)) { ?>
                <div class="message">
                    <!-- <p><?php echo $message; ?></p> -->
                </div>
            <?php } ?>
        </div>
        <div>
            <a  href="https://thelandscapeexpo.com/broadcast/logs.php"
                    style="align-items: center; display: flex; margin-top: 20px; justify-content: end;">Go to the Logs</a>
        </div>
    </div>
</body>
</html>
