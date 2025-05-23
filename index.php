<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'vendor/autoload.php';

include 'helpers/functions.php';
template('header.php');

use Aries\MiniFrameworkStore\Models\Product;

$products = new Product();

$amounLocale = 'en_PH';
$pesoFormatter = new NumberFormatter($amounLocale, NumberFormatter::CURRENCY);

// Fetch all products
$allProducts = $products->getAll();

// Debugging output
if (empty($allProducts)) {
    echo "<p>No products found in the database.</p>";
    echo "<p>Please check your database connection and data.</p>";
} else {
    // Uncomment for detailed debugging
    // var_dump($allProducts);
}
?>

<style>
  /* Harry Potter-themed background */
  body {
    background: linear-gradient(135deg, #4e1f1f, #f9e79f); /* Gryffindor Red and Gold */
    color: #f5f5f7;
    font-family: 'Montserrat', sans-serif;
  }
  .container {
    max-width: 1140px;
  }
  h1, h2 {
    font-family: 'Lora', serif;
    text-shadow: 0 1px 4px rgba(0,0,0,0.7);
  }
  .fade-in-section {
    padding: 40px 15px;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.6);
  }
  .card {
    background: rgba(255, 255, 255, 0.12);
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.4);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.8);
  }
  .card-img-top {
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    max-height: 200px;
    object-fit: cover;
  }
  .card-title {
    font-weight: 700;
    font-size: 1.25rem;
  }
  .card-subtitle {
    font-weight: 600;
    font-size: 1.1rem;
    color: #f1c40f; /* Gryffindor Gold */
    text-shadow: 0 0 3px #f1c40f99;
  }
  .card-text {
    font-size: 0.95rem;
    color: #ddd;
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
  .btn-success {
    background: linear-gradient(45deg, #f1c40f, #d4ac0d); /* Hufflepuff colors */
    border: none;
    font-weight: 600;
  }
  .btn-success:hover {
    background: linear-gradient(45deg, #d4ac0d, #f1c40f);
  }
  .text-primary {
    color: #9b1e1e; /* Gryffindor Red */
  }
  .lead {
    color: #ccc;
  }
</style>

<div class="container my-5 fade-in-section">
    <div class="row align-items-center mb-4">
        <div class="col-md-12">
            <h1 class="text-center display-4 fw-bold mb-3">Welcome to the Ansali Store</h1>
            <p class="text-center lead">What you need is everything here</p>
        </div>
    </div>
    <div class="row">
        <h2 class="mb-4 fw-semibold text-primary">Products</h2>
        <?php if (!empty($allProducts)): ?>
            <?php foreach($allProducts as $product): ?>
            <div class="col-12 col-sm-6 col-md-4 mb-4 d-flex align-items-stretch">
                <div class="card w-100 animate-card">
                    <img src="<?php echo htmlspecialchars($product['image_path']) ?>" class="card-img-top" alt="Product Image">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-2"><?php echo htmlspecialchars($product['name']) ?></h5>
                        <h6 class="card-subtitle mb-2"><?php echo $pesoFormatter->formatCurrency($product['price'], 'PHP') ?></h6>
                        <p class="card-text flex-grow-1"><?php echo htmlspecialchars($product['description']) ?></p>
                        <div class="mt-3 d-flex gap-2">
                            <a href="product.php?id=<?php echo $product['id'] ?>" class="btn btn-primary flex-fill">View Product</a>
                            <a href="#" class="btn btn-success add-to-cart flex-fill" data-productid="<?php echo $product['id'] ?>" data-quantity="1">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products available.</p>
        <?php endif; ?>
    </div>
</div>

<script src="assets/js/bootstrap.bundle.min.js"></script>
<script>
    // Add to Cart functionality
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-productid');
            const quantity = this.getAttribute('data-quantity');
            
            // Perform AJAX request to add to cart
            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ productId, quantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Item added to cart!');
                } else {
                    alert('Error adding item to cart.');
                }
            });
        });
    });
</script>

<?php template('footer.php'); ?>