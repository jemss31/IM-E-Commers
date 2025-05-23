<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>
<?php

if (isset($_GET['remove'])) {
    $productId = $_GET['remove'];
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
        echo "<script>alert('Product removed from cart');</script>";
    }
}

$amounLocale = 'en_PH';
$pesoFormatter = new NumberFormatter($amounLocale, NumberFormatter::CURRENCY);

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
  h1 {
    font-family: 'Lora', serif;
    font-weight: 700;
    font-size: 2.5rem;
    margin-bottom: 1rem;
    text-align: center;
    color: #f1c40f; /* Gryffindor Gold */
  }
  .table {
    background: rgba(255, 255, 255, 0.1); /* Light background for table */
    color: #ddd;
  }
  .btn-danger {
    background-color: #dc3545; /* Danger button color */
  }
  .btn-danger:hover {
    background-color: #c82333; /* Darker on hover */
  }
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-md-12">
            <h1>Cart</h1>
            <?php if (countCart() == 0): ?>
                <p>Your cart is empty.</p>
                <a href="index.php" class="btn btn-primary">Continue Shopping</a>
            <?php else: ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']) ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']) ?></td>
                                <td><?php echo $pesoFormatter->formatCurrency($item['price'], 'PHP') ?></td>
                                <td><?php echo $pesoFormatter->formatCurrency($item['total'], 'PHP') ?></td>
                                <td>
                                    <a href="cart.php?remove=<?php echo $item['product_id'] ?>" class="btn btn-danger" onclick="setTimeout(function(){ location.reload(); }, 100); return true;">Remove</a>
                                </td>
                                <?php $superTotal = isset($superTotal) ? $superTotal + $item['total'] : $item['total']; ?>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total</strong></td>
                            <td colspan="2"><strong><?php echo $pesoFormatter->formatCurrency($superTotal, 'PHP') ?></strong></td>
                        </tr>
                    </tbody>
                </table>

                <a href="checkout.php" class="btn btn-success">Checkout</a>
                <a href="index.php" class="btn btn-primary">Continue Shopping</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php template('footer.php'); ?>