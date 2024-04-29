<!DOCTYPE html>
<html>
<head>
    <title>Household Service</title>
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
        label, select, input[type="password"], input[type="submit"] {
            display: block;
            margin-bottom: 20px;
            width: 100%;
        }
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="text"], input[type="password"], input[type="submit"] {
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
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Household Service</h1>
        
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "household_service_database";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            session_start();
            if(isset($_SESSION['id'])) {
                $user_type = $_SESSION['user_type'];
                switch ($user_type) {
                    case "admin":
                        $redirectURL = "http://localhost/household_service_website/admin_home.php";
                        break;
                    case "client":
                        $redirectURL = "http://localhost/household_service_website/client_home.php";
                        break;
                    case "worker":
                        $redirectURL = "http://localhost/household_service_website/worker_home.php";
                        break;
                    default:
                        echo "<p class='error-message'>Invalid user type.</p>";
                        exit;
                }
                header("Location: $redirectURL");
                exit();
            }

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email_phone = $_POST["email_phone"];
                $password = $_POST["password"];

                $sql = "SELECT * FROM User WHERE Email_Phone = '$email_phone' AND Password = '$password'";
                $result = $conn->query($sql);

                if ($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    $user_type = $row["Type"];
                    $_SESSION["id"] = $row["id"];
                    $_SESSION["user_type"] = $user_type;
                    
                    switch ($user_type) {
                        case "admin":
                            $redirectURL = "http://localhost/household_service_website/admin_home.php";
                            break;
                        case "client":
                            $redirectURL = "http://localhost/household_service_website/client_home.php";
                            break;
                        case "worker":
                            $redirectURL = "http://localhost/household_service_website/worker_home.php";
                            break;
                        default:
                            echo "<p class='error-message'>Invalid user type.</p>";
                            exit;
                    }
                    header("Location: $redirectURL");
                    exit();
                } else {
                    echo "<p class='error-message'>Invalid credentials. Please try again.</p>";
                }
            }

            $conn->close();
            ?>


        <div class="sign-option">
            <a href="#">Sign In</a>
            <span> | </span>
            <a href="http://localhost/household_service_website/sign_up.php">Sign Up</a>       
        </div>

        <form method="post" action="">
            <label for="email_phone">Email/Phone:</label>
            <input type="text" id="email_phone" name="email_phone" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" value="Sign In">
        </form>
    </div>
</body>
</html>
