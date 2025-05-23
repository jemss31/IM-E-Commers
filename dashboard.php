<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>

<?php

use Aries\MiniFrameworkStore\Models\Checkout;

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] != 1) {
    header('Location: login.php');
    exit();
}

$orders = new Checkout();

?>

<style>
  /* Harry Potter-themed styling */
  body {
    background: linear-gradient(135deg, #4e1f1f, #f9e79f); /* Gryffindor Red and Gold */
    color: #f5f5f7;
    font-family: 'Montserrat', sans-serif;
  }
  .container {
    max-width: 1140px;
  }
  h2 {
    font-family: 'Lora', serif;
    color: #f1c40f; /* Gryffindor Gold */
    text-shadow: 0 1px 4px rgba(0,0,0,0.7);
  }
  .table {
    background: rgba(255, 255, 255, 0.1);
    color: #ddd;
    border-radius: 10px;
    overflow: hidden;
  }
  .table th, .table td {
    border: 1px solid #f1c40f; /* Gold borders */
  }
  .btn-primary {
    background: linear-gradient(45deg, #9b1e1e, #f9e79f); /* Gryffindor colors */
    border: none;
    font-weight: 600;
    transition: background 0.3s ease;
  }
  .btn-primary:hover {
    background: linear-gradient(45deg, #f9e79f, #9b1e1e);
  }
</style>

<div class="container my-5">
    <h2>Recent Orders</h2>
    <p>Here are the most recent orders made on the site:</p>
    <a href="my-account.php" class="btn btn-primary mb-3">View My Profile</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($orders->getRecentOrders(10) as $order) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($order['id']) . '</td>';
                echo '<td>' . htmlspecialchars($order['user_name']) . '</td>';
                echo '<td>' . htmlspecialchars($order['product_name']) . '</td>';
                echo '<td>' . htmlspecialchars($order['quantity']) . '</td>';
                echo '<td>' . htmlspecialchars($order['total_price']) . '</td>';
                echo '<td>' . htmlspecialchars($order['order_date']) . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</div>

<?php template('footer.php'); ?>