<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Review</title>
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
</head>
<body>
    <div class="container">
        <h1>Client Review</h1>
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
            $worker_id = $_POST['worker_id'];
            $comment = $_POST['comment'];

            $sql = "INSERT INTO Review (Clientid, Workerid, Comment) VALUES ('$client_id', '$worker_id', '$comment')";

            if ($conn->query($sql) === TRUE) {
                echo "Review submitted successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }

        $client_id = $_SESSION['id'];
        $sql = "SELECT * FROM Hire WHERE Clientid = '$client_id' AND Status = 'Accepted'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $worker_id = $row['Workerid'];
                $sql_worker = "SELECT * FROM Worker WHERE Worker_ID = '$worker_id'";
                $result_worker = $conn->query($sql_worker);
                $worker_row = $result_worker->fetch_assoc();

                echo '<div class="review-card">';
                echo '<h2>' . $worker_row['Name'] . '</h2>';
                echo '<p>Worker ID: ' . $worker_row['Worker_ID'] . '</p>';
                echo '<p>Type: ' . $worker_row['Type'] . '</p>';
                echo '<form method="post" action="">';
                echo '<input type="hidden" name="worker_id" value="' . $worker_row['Worker_ID'] . '">';
                echo '<textarea name="comment" placeholder="Write your review here" required></textarea>';
                echo '<input type="submit" value="Submit Review">';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo '<p>No workers available for review.</p>';
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
