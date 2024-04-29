<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Payment</title>
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
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .pay-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        .pay-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
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

<div class="container">
    <h1>Client Payment</h1>
    <table>
        <thead>
        <tr>
            <th>Worker Name</th>
            <th>Cost</th>
            <th>Status</th>
            <th>Payment Method</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
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

        $client_id = $_SESSION['id'];

        $sql = "SELECT * FROM Payment WHERE Payment_Clientid='$client_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $worker_id = $row['Payment_Workerid'];
                $status = $row['Status'];
                $sql_worker = "SELECT * FROM Worker WHERE Worker_ID='$worker_id'";
                $result_worker = $conn->query($sql_worker);
                $worker_data = $result_worker->fetch_assoc();
                ?>
                <tr>
                    <td><?php echo $worker_data['Name']; ?></td>
                    <td><?php echo $row['Cost']; ?></td>
                    <td><?php echo $status; ?></td>
                    <td>
                        <form id="paymentMethodForm_<?php echo $row['Payment_Workerid']; ?>" method="post" action="">
                            <input type="hidden" name="payment_id" value="<?php echo $row['Payment_Workerid']; ?>">
                            <select name="payment_method">
                                <option value="Mobile banking">Mobile banking</option>
                                <option value="Card">Card</option>
                                <option value="Cash">Cash</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <?php if ($status == 'unpaid') { ?>
                            <form method="post" action="">
                                <input type="hidden" name="payment_id" value="<?php echo $row['Payment_Workerid']; ?>">
                                <input type="submit" class="pay-btn" value="Pay Now" onclick="submitPaymentMethodForm(<?php echo $row['Payment_Workerid']; ?>)">
                            </form>
                        <?php } else {
                            echo 'Paid';
                        } ?>
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='4'>No payments found.</td></tr>";
        }

        $conn->close();
        ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "household_service_database";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $payment_id = $_POST['payment_id'];
    $payment_method = $_POST['payment_method'];

    $sql_update = "UPDATE Payment SET Status='paid', Method='$payment_method' WHERE Payment_Workerid='$payment_id'";

    if ($conn->query($sql_update) === TRUE) {
        $sql_cost = "SELECT Cost FROM Payment WHERE Payment_Workerid='$payment_id'";
        $result_cost = $conn->query($sql_cost);
        $row_cost = $result_cost->fetch_assoc();
        $cost = $row_cost['Cost'];

        $client_id = $_SESSION['id'];
        $sql_deduct = "UPDATE Client SET Total_due = Total_due - $cost WHERE Client_ID='$client_id'";

        if ($conn->query($sql_deduct) === TRUE) {
            echo "<script>alert('Payment successful!')</script>";
            echo "<script>window.location.href='http://localhost/household_service_website/client_payment.php';</script>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
?>

<script>
    function submitPaymentMethodForm(paymentId) {
        var paymentForm = document.getElementById("paymentForm_" + paymentId);
        var paymentMethodForm = document.getElementById("paymentMethodForm_" + paymentId);
        paymentForm.elements["payment_method"].value = paymentMethodForm_.elements["payment_method"].value;

        paymentMethodForm.submit();
        paymentForm.submit();
    }
</script>
