<?php 
include 'helpers/functions.php'; 
template('header.php'); 

use Aries\MiniFrameworkStore\Models\User;
use Aries\MiniFrameworkStore\Models\Checkout;
use Carbon\Carbon;

session_start();

if(!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$userModel = new User();
$checkout = new Checkout();
$userId = $_SESSION['user']['id'];

// Handle form submission
if(isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $birthdate = $_POST['birthdate'] ?? null;

    // Validate birthdate format or set null
    if ($birthdate) {
        try {
            $birthdateFormatted = Carbon::createFromFormat('Y-m-d', $birthdate)->format('Y-m-d');
        } catch (Exception $e) {
            $birthdateFormatted = null;
        }
    } else {
        $birthdateFormatted = null;
    }

    $userModel->update([
        'id' => $userId,
        'name' => $name,
        'email' => $email,
        'address' => $address ?: null,
        'phone' => $phone ?: null,
        'birthdate' => $birthdateFormatted
    ]);

    // Update session info immediately
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['address'] = $address;
    $_SESSION['user']['phone'] = $phone;
    $_SESSION['user']['birthdate'] = $birthdate;

    echo "<script>alert('Account details updated successfully!');</script>";
}

// Get orders for current user by user ID
$userOrders = $checkout->getAllOrders();
$userOrders = array_filter($userOrders, fn($order) => $order['user_id'] == $userId);
?>

<style>
  body {
    background: linear-gradient(135deg, #4e1f1f, #f9e79f); /* Gryffindor Red to Gold */
    color: #f5f5f7;
    font-family: 'Montserrat', sans-serif;
  }
  .container {
    max-width: 1140px;
  }
  h1, h2 {
    color: #f1c40f; /* Gryffindor Gold */
  }
  .bg-white {
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    padding: 20px;
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
  .table {
    background: rgba(255, 255, 255, 0.1);
    color: #ddd;
  }
  .table-dark {
    background-color: #9b1e1e;
    color: #f5f5f7;
  }
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-md-4 mb-4">
            <h1>My Account</h1>
            <p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['user']['name']); ?></strong></p>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <div class="col-md-8 bg-white p-4 rounded shadow-sm">
            <h2>Edit Account Details</h2>
            <form action="my-account.php" method="POST" novalidate>
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['user']['name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['user']['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label fw-semibold">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($_SESSION['user']['address'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label fw-semibold">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($_SESSION['user']['phone'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label for="birthdate" class="form-label fw-semibold">Birthdate</label>
                    <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($_SESSION['user']['birthdate'] ?? ''); ?>">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Save Changes</button>
            </form>

            <h2 class="mt-5">My Orders</h2>
            <?php if (count($userOrders) === 0): ?>
                <p>You have no orders yet.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Order ID</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($userOrders as $order): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['product_name']); ?></td>
                                    <td><?php echo htmlspecialchars($order['quantity']); ?></td>
                                    <td><?php echo htmlspecialchars(number_format($order['total_price'], 2)); ?></td>
                                    <td><?php echo htmlspecialchars(date('M d, Y', strtotime($order['order_date']))); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php template('footer.php'); ?>