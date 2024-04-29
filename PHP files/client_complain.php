<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Complain</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .menu {
            background-color: #333;
            overflow: hidden;
        }
        .menu a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .menu a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            margin: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            width: 80%;
            margin: auto;
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        p {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .edit-profile-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .edit-profile-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<div class="menu">
    <a href="http://localhost/household_service_website/client_home.php">Profile</a>
    <a href="http://localhost/household_service_website/client_review.php">Review</a>
    <a href="http://localhost/household_service_website/client_rating.php">Rating</a>
    <a href="http://localhost/household_service_website/client_complain.php">Complain</a>
    <a href="http://localhost/household_service_website/client_cancel_request.php">Cancel Request</a>
    <a href="http://localhost/household_service_website/client_hire.php">Hire</a>
    <a href="http://localhost/household_service_website/client_payment.php">Payment</a>
    <a href="http://localhost/household_service_website/logout.php">Logout</a>
</div>
<body>
    <div class="container">
        <h1>Client Complain</h1>
        <form method="post" action="">
            <label for="admin">Select Admin:</label>
            <select id="admin" name="admin">
                <?php
                session_start();

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "household_service_database";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $client_id = $_SESSION['id'];
                    $admin_id = $_POST['admin'];
                    $complain = $_POST['complain'];

                    $sql = "INSERT INTO Complain (Clientid, Adminid, Complain) VALUES ('$client_id', '$admin_id', '$complain')";

                    if ($conn->query($sql) === TRUE) {
                        echo "Complain submitted successfully!";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }

                $sql = "SELECT * FROM Admin";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['Admin_ID'] . '">' . $row['Name'] . '</option>';
                    }
                }

                $conn->close();
                ?>
            </select>
            <label for="complain">Complain:</label>
            <textarea id="complain" name="complain" rows="4" required></textarea>
            <input type="submit" value="Submit Complain">
        </form>
    </div>
</body>
</html>
