<!DOCTYPE html>
<html>
<head>
    <title>Worker Profile</title>
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
<body>

<div class="menu">
    <a href="http://localhost/household_service_website/Worker_home.php">Profile</a>
    <a href="http://localhost/household_service_website/worker_hire_request.php">Hire Request</a>
    <a href="http://localhost/household_service_website/worker_payment.php">Payment</a>
    <a href="http://localhost/household_service_website/logout.php">Logout</a>
</div>

<div class="container">
    <h1>Welcome to Worker Home Page</h1>

    <!-- First block showing worker ID and type with update button -->
    <div class="block">
        <h2>Worker ID and Type</h2>
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

        $worker_id = $_SESSION['id'];
        $sql_worker = "SELECT Worker_ID, Type FROM Worker WHERE Worker_ID = '$worker_id'";
        $result_worker = $conn->query($sql_worker);

        if ($result_worker->num_rows > 0) {
            $row_worker = $result_worker->fetch_assoc();
            echo "<p>Worker ID: " . $row_worker['Worker_ID'] . "</p>";
            echo "<p>Type: " . $row_worker['Type'] . "</p>";
            echo '<a href="http://localhost/household_service_website/worker_basic_update.php"><button class="update-button">Update</button></a>';
        } else {
            echo "No worker found.";
        }
        ?>
    </div>

    <!-- Second block showing worker details with update button -->
    <div class="block">
        <h2>Worker Details</h2>
        <?php
        $sql_worker_details = "SELECT Name, Age, Gender, Status, Rating, Experience_year FROM Worker WHERE Worker_ID = '$worker_id'";
        $result_worker_details = $conn->query($sql_worker_details);

        if ($result_worker_details->num_rows > 0) {
            $row_worker_details = $result_worker_details->fetch_assoc();
            echo "<p>Name: " . $row_worker_details['Name'] . "</p>";
            echo "<p>Age: " . $row_worker_details['Age'] . "</p>";
            echo "<p>Gender: " . $row_worker_details['Gender'] . "</p>";
            echo "<p>Status: " . $row_worker_details['Status'] . "</p>";
            echo "<p>Rating: " . $row_worker_details['Rating'] . "</p>";
            echo "<p>Experience years: " . $row_worker_details['Experience_year'] . "</p>";
            echo '<a href="http://localhost/household_service_website/worker_details_update.php"><button class="update-button">Update</button></a>';
        } else {
            echo "No worker details found.";
        }
        ?>
    </div>

    <!-- Third block showing worker type-based information with update button -->
    <div class="block">
        <h2>Type-based Information</h2>
        <?php
        $worker_type = $row_worker['Type'];

        switch ($worker_type) {
            case "Driver":
                $sql_driver = "SELECT Licence, Vehicle FROM Driver WHERE Driver_ID = '$worker_id'";
                $result_driver = $conn->query($sql_driver);
                if ($result_driver->num_rows > 0) {
                    $row_driver = $result_driver->fetch_assoc();
                    echo "<p>Licence: " . $row_driver['Licence'] . "</p>";
                    echo "<p>Vehicle: " . $row_driver['Vehicle'] . "</p>";
                    echo '<a href="http://localhost/household_service_website/worker_driver_update.php"><button class="update-button">Update</button></a>';
                } else {
                    echo "No driver information found.";
                }
                break;
            case "Nanny":
                $sql_nanny = "SELECT Skill1, Skill2, Skill3 FROM Nanny WHERE Nanny_ID = '$worker_id'";
                $result_nanny = $conn->query($sql_nanny);
                if ($result_nanny->num_rows > 0) {
                    $row_nanny = $result_nanny->fetch_assoc();
                    echo "<p>Skill 1: " . $row_nanny['Skill1'] . "</p>";
                    echo "<p>Skill 2: " . $row_nanny['Skill2'] . "</p>";
                    echo "<p>Skill 3: " . $row_nanny['Skill3'] . "</p>";
                    echo '<a href="http://localhost/household_service_website/worker_nanny_update.php"><button class="update-button">Update</button></a>';
                } else {
                    echo "No nanny information found.";
                }
                break;
            case "Security Guard":
                $sql_security_guard = "SELECT Shift, Location FROM Security_guard WHERE Security_guard_ID = '$worker_id'";
                $result_security_guard = $conn->query($sql_security_guard);
                if ($result_security_guard->num_rows > 0) {
                    $row_security_guard = $result_security_guard->fetch_assoc();
                    echo "<p>Shift: " . $row_security_guard['Shift'] . "</p>";
                    echo "<p>Location: " . $row_security_guard['Location'] . "</p>";
                    echo '<a href="http://localhost/household_service_website/worker_sg_update.php"><button class="update-button">Update</button></a>';
                } else {
                    echo "No security guard information found.";
                }
                break;
            case "Cook":
                $sql_cook = "SELECT Food_type1, Food_type2, Food_type3 FROM Cook WHERE Cook_ID = '$worker_id'";
                $result_cook = $conn->query($sql_cook);
                if ($result_cook->num_rows > 0) {
                    $row_cook = $result_cook->fetch_assoc();
                    echo "<p>Food Type 1: " . $row_cook['Food_type1'] . "</p>";
                    echo "<p>Food Type 2: " . $row_cook['Food_type2'] . "</p>";
                    echo "<p>Food Type 3: " . $row_cook['Food_type3'] . "</p>";
                    echo '<a href="http://localhost/household_service_website/worker_cook_update.php"><button class="update-button">Update</button></a>';
                } else {
                    echo "No cook information found.";
                }
                break;
            default:
                echo "Please update previous info.";
                break;
        }

        $conn->close();
        ?>
    </div>
</div>
</body>
</html>