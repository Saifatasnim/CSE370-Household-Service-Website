<!DOCTYPE html>
<html>
<head>
    <title>Hire Workers</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
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
        <h1>Hire Workers</h1>
        <form class="search-bar" method="get" action="">
            <label for="worker_type">Select Worker Type:</label>
            <select id="worker_type" name="worker_type">
                <option value="Nanny">Nanny</option>
                <option value="Driver">Driver</option>
                <option value="Cook">Cook</option>
                <option value="Security Guard">Security Guard</option>
            </select>
            <input type="submit" value="Search">
        </form>

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

            // Check if worker type is selected
            if(isset($_GET['worker_type'])) {
                $worker_type = $_GET['worker_type'];

                $sql = "SELECT * FROM Worker WHERE Type = '$worker_type' AND Status = 'Active'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="worker-card">';
                        echo '<h2>' . $row['Name'] . '</h2>';
                        echo '<p>Age: ' . $row['Age'] . '</p>';
                        echo '<p>Gender: ' . $row['Gender'] . '</p>';
                        echo '<p>Type: ' . $row['Type'] . '</p>';
                        echo '<p>Status: ' . $row['Status'] . '</p>';
                        echo '<p>Rating: ' . $row['Rating'] . '</p>';
                        echo '<p>Experience years: ' . $row['Experience_year'] . ' </p>';
                        
                        // Display additional information based on worker type
                        switch ($worker_type) {
                            case "Nanny":
                                echo '<p>Skills:</p>';
                                $nanny_id = $row['Worker_ID'];
                                $nanny_sql = "SELECT Skill1, Skill2, Skill3 FROM Nanny WHERE Nanny_ID = '$nanny_id'";
                                $nanny_result = $conn->query($nanny_sql);
                                if ($nanny_result->num_rows > 0) {
                                    while($nanny_row = $nanny_result->fetch_assoc()) {
                                        echo '<p>' . $nanny_row['Skill1'] . ', ' . $nanny_row['Skill2'] . ', ' . $nanny_row['Skill3'] . '</p>';
                                    }
                                }
                                break;
                            case "Driver":
                                $driver_id = $row['Worker_ID'];
                                $driver_sql = "SELECT Licence,Vehicle FROM Driver WHERE Driver_ID = '$driver_id'";
                                $driver_result = $conn->query($driver_sql);
                                if ($driver_result->num_rows > 0) {
                                    while($driver_row = $driver_result->fetch_assoc()) {
                                        echo '<p>Licence: ' . $driver_row['Licence'] . '</p>';
                                        echo '<p>Vehicle: ' . $driver_row['Vehicle'] . '</p>';
                                    }
                                }
                                break;
                            case "Cook":
                                echo '<p>Food Types:</p>';
                                $cook_id = $row['Worker_ID'];
                                $cook_sql = "SELECT Food_type1, Food_type2, Food_type3 FROM Cook WHERE Cook_ID = '$cook_id'";
                                $cook_result = $conn->query($cook_sql);
                                if ($cook_result->num_rows > 0) {
                                    while($cook_row = $cook_result->fetch_assoc()) {
                                        echo '<p>' . $cook_row['Food_type1'] . ', ' . $cook_row['Food_type2'] . ', ' . $cook_row['Food_type3'] . '</p>';
                                    }
                                }
                                break;
                            case "Security Guard":
                                $sg_id = $row['Worker_ID'];
                                $sg_sql = "SELECT Shift,Location FROM Security_guard WHERE Security_guard_ID = '$sg_id'";
                                $sg_result = $conn->query($sg_sql);
                                if ($sg_result->num_rows > 0) {
                                    while($sg_row = $sg_result->fetch_assoc()) {
                                        echo '<p>Shift: ' . $sg_row['Shift'] . '</p>';
                                        echo '<p>Location: ' . $sg_row['Location'] . '</p>';
                                    }
                                }
                                break;
                            default:
                                break;
                        }

                        $worker_id = $row['Worker_ID'];
                        $review_sql = "SELECT Comment FROM Review WHERE Workerid = '$worker_id'";
                        $review_result = $conn->query($review_sql);

                        if ($review_result->num_rows > 0) {
                            echo '<h3>Reviews:</h3>';
                            while($review_row = $review_result->fetch_assoc()) {
                                echo '<p>' . $review_row['Comment'] . '</p>';
                            }
                        } else {
                            echo '<p>No reviews yet.</p>';
                        }
                        
                        echo '<form method="post" action="client_process_hire.php">';
                        echo '<input type="hidden" name="worker_id" value="' . $row['Worker_ID'] . '">';
                        echo '<label for="cost">Cost:</label>';
                        echo '<input type="number" id="cost" name="cost" min="0" required>';
                        echo '<label for="duration">Duration (hours):</label>';
                        echo '<input type="number" id="duration" name="duration" min="1" required>';
                        echo '<button type="submit" class="hire-button">Hire</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No workers available for the selected type.</p>';
                }
            }


            $conn->close();
            ?>
    </div>
    <script>
        const forms = document.querySelectorAll('.hire-form');
        forms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                const submitButton = this.querySelector('.hire-button');
                submitButton.textContent = 'Request Sent';
                submitButton.style.backgroundColor = '#5cb85c';
                submitButton.disabled = true;
            });
        });
    </script>
</body>
</html>
