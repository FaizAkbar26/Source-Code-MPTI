<?php

$log_dir = __DIR__ . '/../logs';
if (!is_dir($log_dir)) {
    mkdir($log_dir, 0777, true);
}
$log_file = $log_dir . '/error.log';

// Error handling
set_error_handler(function($errno, $errstr, $errfile, $errline) use ($log_file) {
    error_log("Error [$errno]: $errstr in $errfile on line $errline", 3, $log_file);
    header("Location: /error.php");
    exit();
});

set_exception_handler(function($exception) use ($log_file) {
    error_log("Exception: " . $exception->getMessage(), 3, $log_file);
    header("Location: /error.php");
    exit();
});

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit();
}

if (isset($_POST['update_payment'])) {
    if (isset($_POST['order_id']) && isset($_POST['payment_status'])) {
        $order_id = $_POST['order_id'];
        $payment_status = $_POST['payment_status'];
        $payment_status = filter_var($payment_status, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        try {
            $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
            $update_payment->execute([$payment_status, $order_id]);
            $message[] = 'Payment status updated!';
        } catch (PDOException $e) {
            error_log("PDOException: " . $e->getMessage(), 3, $log_file);
        }
    } else {
        error_log("POST data missing: order_id or payment_status", 3, $log_file);
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    try {
        $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
        $delete_order->execute([$delete_id]);
        header('location:placed_orders.php');
        exit();
    } catch (PDOException $e) {
        error_log("PDOException: " . $e->getMessage(), 3, $log_file);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placed Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
    <style type="text/css">
        .button-container {
            display: flex;
            justify-content: flex-start;
            margin-top: 10px;
        }

        .button-container a {
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            border: 1px solid #fff;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 16px;
        }

        .button-container a:hover {
            font-weight: 900;
            background: transparent;
            color: #007bff;
            border-color: #007bff;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="orders">

<h1 class="heading">Placed Orders</h1>

<div class="box-container">

    <?php
    try {
        $select_orders = $conn->prepare("SELECT * FROM `orders`");
        $select_orders->execute();
        if ($select_orders->rowCount() > 0) {
            while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <div class="box">
        <p>Placed On : <span><?= htmlspecialchars($fetch_orders['placed_on']); ?></span></p>
        <p>Name : <span><?= htmlspecialchars($fetch_orders['name']); ?></span></p>
        <p>Number : <span><?= htmlspecialchars($fetch_orders['number']); ?></span></p>
        <p>Type : <span><?= htmlspecialchars($fetch_orders['label']); ?></span></p>
        <p>Address : <span><?= htmlspecialchars($fetch_orders['address']); ?></span></p>
        <p>Total products : <span><?= htmlspecialchars($fetch_orders['total_products']); ?></span></p>
        <p>Total price : <span>Rp. <?= htmlspecialchars($fetch_orders['total_price']); ?></span></p>
        <p>Payment method : <span><?= htmlspecialchars($fetch_orders['method']); ?></span></p>
        <p>Payment Proof :
            <?php if (!empty($fetch_orders['image_payment'])): ?>
                <div class="button-container">
                    <a data-fancybox="gallery" href="../uploads/<?= htmlspecialchars($fetch_orders['image_payment']); ?>" class="primary-btn">View Image</a>
                </div>
            <?php else: ?>
                <span>No payment proof uploaded.</span>
            <?php endif; ?>
        </p>
        <form action="" method="post">
            <input type="hidden" name="order_id" value="<?= htmlspecialchars($fetch_orders['id']); ?>">
            <select name="payment_status" class="select">
                <option selected disabled><?= htmlspecialchars($fetch_orders['payment_status']); ?></option>
                <option value="completed">Completed</option>
            </select>
            <div class="flex-btn">
                <input type="submit" value="update" class="option-btn" name="update_payment">
                <a href="placed_orders.php?delete=<?= htmlspecialchars($fetch_orders['id']); ?>" class="delete-btn" onclick="return confirm('delete this order?');">Delete</a>
            </div>
        </form>
    </div>
    <?php
            }
        } else {
            echo '<p class="empty">No orders placed yet!</p>';
        }
    } catch (PDOException $e) {
        error_log("PDOException: " . $e->getMessage(), 3, $log_file);
    }
    ?>

</div>

</section>

<script src="../js/admin_script.js"></script>
</body>
</html>
