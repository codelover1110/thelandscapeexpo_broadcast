<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["logged_in"]) || $_SESSION["logged_in"] !== true) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Message Log</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 70vh;
            /* background-color: #f5f5f5; */
        }
        .container {
            width: 800px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .table-container {
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-collapse: collapse;
            margin: 20px;
        }
        table {
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        caption {
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <div class="container">
        <div style="margin-bottom: 10px; display: flex; width: 100%;">
            <a id="tle-logoo" href="https://thelandscapeexpo.com" style="display: flex; width: 100%; justify-content: end;"><img class="logo-20233" src="https://thelandscapeexpo.com/images/logos/TLE-A-2023-Logo-No-Dates.png" style="
                width: 230px;
                display: block;
                float: left;
            "></a>
            <a  href="https://thelandscapeexpo.com/broadcast/dashboard.php" style="align-items: center; display: flex; width: 50%; justify-content: end;">Go Dashboard</a>
        </div>
        <div class="table-container">
            <table>
                <caption><h1>TLE Broadcast Log</h1></caption>
                <tr><th>ID</th><th>User</th><th>Content</th><th>Created At</th></tr>
                <?php
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
    
                // Fetch all data from the broadcast table
                $sql = "SELECT * FROM $table_name ORDER BY id DESC";
                $result = $conn->query($sql);
    
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["user"] . "</td>";
                        echo "<td>" . $row["message"] . "</td>";
                        echo "<td>" . $row["created_at"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No data found in the log.</td></tr>";
                }
    
                // Close the database connection
                $conn->close();
                ?>
            </table>
        </div>
    </div>
</body>
</html>
