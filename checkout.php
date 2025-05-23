<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>
<?php

use Aries\MiniFrameworkStore\Models\Checkout;

$checkout = new Checkout();

$superTotal = 0;
$orderId = null;

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $superTotal += $item['total'] * $item['quantity'];
    }
}

$amounLocale = 'en_PH';
$pesoFormatter = new NumberFormatter($amounLocale, NumberFormatter::CURRENCY);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    if (isset($_SESSION['user'])) {
        $orderId = $checkout->userCheckout([
            'user_id' => $_SESSION['user']['id'],
            'total' => $superTotal
        ]);
    } else {
        $orderId = $checkout->guestCheckout([
            'name' => $name,
            'address' => $address,
            'phone' => $phone,
            'total' => $superTotal
        ]);
    }

    foreach ($_SESSION['cart'] as $item) {
        $checkout->saveOrderDetails([
            'order_id' => $orderId,
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'subtotal' => $item['total'] * $item['quantity']
        ]);
    }

    unset($_SESSION['cart']);

    echo "<script>alert('Order placed successfully!'); window.location.href='index.php'</script>";
}

?>

<style>
  body {
    background: linear-gradient(135deg, #4e1f1f, #f9e79f); /* Gryffindor Red to Gold */
    color: #f5f5f7;
    font-family: 'Montserrat', sans-serif;
  }
  .container {
    max-width: 960px;
  }
  h1, h2 {
    text-align: center;
    color: #f1c40f; /* Gryffindor Gold */
  }
  .table {
    background: rgba(255, 255, 255, 0.1); /* Light background for table */
    color: #ddd;
  }
  .btn-primary {
    background: linear-gradient(45deg, #9b1e1e, #f9e79f); /* Gryffindor colors */
    border: none;
    transition: background 0.3s ease;
  }
  .btn-primary:hover {
    background: linear-gradient(45deg, #f9e79f, #9b1e1e);
  }
  .btn-success {
    background: linear-gradient(45deg, #00b894, #00876c); /* Hufflepuff colors */
    border: none;
    transition: background 0.3s ease;
  }
  .btn-success:hover {
    background: linear-gradient(45deg, #00876c, #00b894);
  }
</style>

<div class="container my-5">
    <div class="row">
        <h1>Checkout</h1>
        <h2>Cart Details</h2>
        <table class="table table-bordered">
            <?php if (countCart() > 0): ?>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']) ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']) ?></td>
                        <td><?php echo $pesoFormatter->formatCurrency($item['price'], 'PHP') ?></td>
                        <td><?php echo $pesoFormatter->formatCurrency($item['total'], 'PHP') ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-end"><strong>Total</strong></td>
                    <td><strong><?php echo $pesoFormatter->formatCurrency($superTotal, 'PHP') ?></strong></td>
                </tr>
            </tbody>
            <?php else: ?>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4" class="text-center">Your cart is empty.</td>
                </tr>
            </tbody>
            <?php endif; ?>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2>Shipping Information</h2>
            <?php if (countCart() == 0): ?>
                <p>Your cart is empty.</p>
                <a href="index.php" class="btn btn-primary">Continue Shopping</a>
            <?php else: ?>
                <form action="checkout.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="submit">Place Order</button>
                    <a href="cart.php" class="btn btn-primary">View Cart</a>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php template('footer.php'); ?>