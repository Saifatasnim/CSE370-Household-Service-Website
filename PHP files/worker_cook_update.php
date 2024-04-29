<!DOCTYPE html>
<html>
<head>
    <title>Update Cook Food Types</title>
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
            <h2>Update Food Types</h2>

            <div class="back">
            <a href="http://localhost/household_service_website/worker_home.php">Back to home</a>       
            </div>

            <form method="post" action="">
                <label for="foodtype1">Food Type 1:</label>
                <input type="text" id="foodtype1" name="foodtype1" required>
                <label for="foodtype2">Food Type 2:</label>
                <input type="text" id="foodtype2" name="foodtype2" required>
                <label for="foodtype3">Food Type 3:</label>
                <input type="text" id="foodtype3" name="foodtype3" required>
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
                $foodtype1 = $_POST['foodtype1'];
                $foodtype2 = $_POST['foodtype2'];
                $foodtype3 = $_POST['foodtype3'];

                $sql_update = "UPDATE Cook SET Food_type1='$foodtype1', Food_type2='$foodtype2', Food_type3='$foodtype3' WHERE Cook_ID='$worker_id'";

                if ($conn->query($sql_update) === TRUE) {
                    echo '<div class="success-message">Cook food types updated successfully!</div>';
                } else {
                    echo '<div class="error-message">Error updating cook food types: ' . $conn->error . '</div>';
                }
            }
?>
    </div>
</body>
</html>
