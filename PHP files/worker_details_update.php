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
            <h2>Update Worker Information</h2>

            <div class="back">
            <a href="http://localhost/household_service_website/worker_home.php">Back to home</a>       
            </div>

            <form method="post" action="">
                <label for="worker_name">Name:</label>
                <input type="text" id="worker_name" name="worker_name" required>
                <label for="worker_age">Age:</label>
                <input type="number" id="worker_age" name="worker_age" min="18" required>
                <label for="worker_gender">Gender:</label>
                <select id="worker_gender" name="worker_gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <label for="worker_experience">Experience Year:</label>
                <input type="number" id="worker_experience" name="worker_experience" min="0" required>
                <button type="submit" name="update_info">Update</button>
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

            if(isset($_POST['update_info'])) {
                $worker_name = $_POST['worker_name'];
                $worker_age = $_POST['worker_age'];
                $worker_gender = $_POST['worker_gender'];
                $worker_experience = $_POST['worker_experience'];

                $sql_update = "UPDATE Worker SET Name='$worker_name', Age='$worker_age', Gender='$worker_gender', Experience_year='$worker_experience' WHERE Worker_ID='$worker_id'";

                if ($conn->query($sql_update) === TRUE) {
                    echo '<div class="success-message">Worker information updated successfully!</div>';
                } else {
                    echo '<div class="error-message">Error updating worker information: ' . $conn->error . '</div>';
                }
            }
        ?>
    </div>
</body>
</html>
