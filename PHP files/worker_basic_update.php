<!DOCTYPE html>
<html>
<head>
    <title>Update Profile</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }
        label, select, input[type="text"], input[type="password"], input[type="submit"] {
            display: block;
            margin-bottom: 20px;
            width: 100%;
        }
        input[type="text"], input[type="password"] {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        select {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        p.error-message {
            color: #ff0000;
            margin-top: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="block">
            <h1>Update Worker Type</h1>

            <div class="back">
            <a href="http://localhost/household_service_website/worker_home.php">Back to home</a>       
            </div>

            <form method="post" action="">
                <label for="worker_type">Worker Type:</label>
                <select id="worker_type" name="worker_type" required>
                    <option value="Nanny">Nanny</option>
                    <option value="Driver">Driver</option>
                    <option value="Cook">Cook</option>
                    <option value="Security Guard">Security Guard</option>
                </select>
                <button type="submit" name="update_type">Update</button>
            </form>
        </div>

        <?php
            session_start();
            $worker_id = $_SESSION['id'];

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "household_service_database";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql_check_type_updated = "SELECT Type_Updated FROM Worker WHERE Worker_ID = '$worker_id'";
            $result = $conn->query($sql_check_type_updated);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $type_updated = $row['Type_Updated'];
                if ($type_updated) {
                    echo '<div class="error-message">You have already updated your worker type. Further updates require admin permission.</div>';
                    exit;
                } 
            }
    
            if(isset($_POST['update_type'])) {
                $worker_type = $_POST['worker_type'];
                $sql_update = "UPDATE Worker SET Type='$worker_type' WHERE Worker_ID='$worker_id'";

                if ($conn->query($sql_update) === TRUE) {
                    echo '<div class="success-message">Worker type updated successfully!</div>';
                    switch ($worker_type) {
                        case 'Driver':
                            $sql_insert = "INSERT INTO Driver (Driver_ID) VALUES ('$worker_id')";
                            break;
                        case 'Security Guard':
                            $sql_insert = "INSERT INTO Security_guard (Security_guard_ID) VALUES ('$worker_id')";
                            break;
                        case 'Nanny':
                            $sql_insert = "INSERT INTO Nanny (Nanny_ID) VALUES ('$worker_id')";
                            break;
                        case 'Cook':
                            $sql_insert = "INSERT INTO Cook (Cook_ID) VALUES ('$worker_id')";
                            break;
                        default:
                            break;
                    }
                    
                    $sql_update_type = "UPDATE Worker SET Type_Updated = '1' WHERE Worker_ID = '$worker_id'";
                    if ($conn->query($sql_update_type) !== TRUE) {
                        echo '<div class="error-message">Error updating worker type status: ' . $conn->error . '</div>';
                        exit;
                    }
        
                    if (isset($sql_insert)) {
                        if ($conn->query($sql_insert) === TRUE) {
                            echo '<div class="success-message">Worker ID inserted into specific table successfully!</div>';
                        } else {
                            echo '<div class="error-message">Error inserting worker ID into specific table: ' . $conn->error . '</div>';
                        }
                    }
                } else {
                    echo '<div class="error-message">Error updating worker type: ' . $conn->error . '</div>';
                }
            }
        ?>
    </div>

</body>
</html>
