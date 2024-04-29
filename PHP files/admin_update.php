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
        label, input[type="text"], input[type="password"], input[type="submit"] {
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
        <h1>Update Profile</h1>
        <form method="post" action="admin_process_update.php">
            <label for="admin_name">Name:</label>
            <input type="text" id="admin_name" name="admin_name" required>

            <input type="submit" value="Update Profile">
        </form>
    </div>
</body>
</html>
