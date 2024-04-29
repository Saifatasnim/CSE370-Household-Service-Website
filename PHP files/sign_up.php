<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
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
        label, input[type="text"], input[type="password"], select, input[type="submit"] {
            display: block;
            margin-bottom: 20px;
            width: 100%;
        }
        input[type="text"], input[type="password"], select {
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
        p.success-message, p.error-message {
            color: #ff0000;
            margin-top: 5px;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>
        <div class="sign-option">
            <a href="http://localhost/household_service_website/sign_in.php">Sign In</a>
            <span> | </span>
            <a href="#">Sign Up</a>       
        </div>
        
        <form method="post" action="">
            <label for="role">Select User Type:</label>
            <select id="role" name="role">
                <option value="admin">Admin</option>
                <option value="worker">Worker</option>
                <option value="client">Client</option>
            </select>
            <label for="email">Email/Phone:</label>
            <input type="text" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Sign Up">
        </form>
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "household_service_database";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get form data
                $role = $_POST["role"];
                $email = $_POST["email"];
                $password = $_POST["password"];

                // Insert into User table with role
                $insertUserSql = "INSERT INTO User (Email_Phone, Password, Type) VALUES ('$email', '$password', '$role')";
                if ($conn->query($insertUserSql) === TRUE) {
                    $userId = $conn->insert_id;

                    switch ($role) {
                        case "admin":
                            $insertAdminSql = "INSERT INTO admin (Admin_ID) VALUES ('$userId')";
                            if ($conn->query($insertAdminSql) === TRUE) {
                                echo "<p class='success-message'>User signed up successfully as an admin.</p>";
                            } else {
                                echo "<p class='error-message'>Error: " . $conn->error . "</p>";
                            }
                            break;
                        case "worker":
                            $insertWorkerSql = "INSERT INTO worker (Worker_ID) VALUES ('$userId')";
                            if ($conn->query($insertWorkerSql) === TRUE) {
                                echo "<p class='success-message'>User signed up successfully as a worker.</p>";
                            } else {
                                echo "<p class='error-message'>Error: " . $conn->error . "</p>";
                            }
                            break;
                        case "client":
                            $insertClientSql = "INSERT INTO client (Client_ID) VALUES ('$userId')";
                            if ($conn->query($insertClientSql) === TRUE) {
                                echo "<p class='success-message'>User signed up successfully as a client.</p>";
                            } else {
                                echo "<p class='error-message'>Error: " . $conn->error . "</p>";
                            }
                            break;
                        default:
                            echo "<p class='error-message'>Invalid user role.</p>";
                    }
                } else {
                    echo "<p class='error-message'>Error: " . $conn->error . "</p>";
                }
            }

            $conn->close();
            ?>

    </div>
</body>
</html>
