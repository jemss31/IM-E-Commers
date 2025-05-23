<?php include 'helpers/functions.php'; ?>
<?php template('header.php'); ?>
<?php

use Aries\MiniFrameworkStore\Models\Product;

$products = new Product();
$category = $_GET['name'];

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
    max-width: 1140px;
  }
  h1 {
    font-family: 'Lora', serif;
    font-weight: 700;
    font-size: 2.75rem;
    margin-bottom: 1rem;
    text-align: center;
    text-shadow: 0 2px 6px rgba(0,0,0,0.8);
    color: #f1c40f; /* Gryffindor Gold */
  }
  h2 {
    font-family: 'Lora', serif;
    font-weight: 600;
    font-size: 1.8rem;
    color: #f1c40f; /* Gryffindor Gold */
    margin-bottom: 1.5rem;
    text-shadow: 0 0 5px #f1c40faa;
    text-align: center;
  }
  .row {
    margin-bottom: 40px;
  }
  .card {
    background: rgba(255, 255, 255, 0.12);
    border: none;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.4);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    color: #f0f0f0;
    display: flex;
    flex-direction: column;
    height: 100%;
  }
  .card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 50px rgba(0,0,0,0.75);
  }
  .card-img-top {
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    max-height: 200px;
    object-fit: cover;
  }
  .card-body {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }
  .card-title {
    font-weight: 700;
    font-size: 1.3rem;
    margin-bottom: 0.5rem;
  }
  .card-subtitle {
    font-weight: 600;
    font-size: 1.1rem;
    color: #00d97e; /* Premium green */
    text-shadow: 0 0 4px #00d97eaa;
    margin-bottom: 1rem;
  }
  .card-text {
    flex-grow: 1;
    color: #ccc;
    font-size: 0.95rem;
    margin-bottom: 1.2rem;
  }
  .btn-primary {
    background: linear-gradient(45deg, #9b1e1e, #f9e79f); /* Gryffindor colors */
    border: none;
    font-weight: 600;
    transition: background 0.3s ease;
    flex: 1;
  }
  .btn-primary:hover {
    background: linear-gradient(45deg, #f9e79f, #9b1e1e);
  }
  .btn-success {
    background: linear-gradient(45deg, #00b894, #00876c); /* Hufflepuff colors */
    border: none;
    font-weight: 600;
    transition: background 0.3s ease;
    flex: 1;
  }
  .btn-success:hover {
    background: linear-gradient(45deg, #00876c, #00b894);
  }
  .d-flex.gap-2 {
    display: flex;
    gap: 10px;
  }
  /* Make sure cards fill height for consistent button alignment */
  .col-md-4 {
    margin-bottom: 30px;
    display: flex;
  }
</style>

<div class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-12">
            <h1><?php echo htmlspecialchars($category) ?></h1>
        </div>
    </div>
    <div class="row">
        <h2>Products</h2>
        <?php foreach($products->getByCategory($category) as $product): ?>
        <div class="col-md-4 d-flex">
            <div class="card w-100">
                <img src="<?php echo htmlspecialchars($product['image_path']) ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['name']) ?>">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo htmlspecialchars($product['name']) ?></h5>
                    <h6 class="card-subtitle mb-2"><?php echo $pesoFormatter->formatCurrency($product['price'], 'PHP') ?></h6>
                    <p class="card-text"><?php echo htmlspecialchars($product['description']) ?></p>
                    <div class="d-flex gap-2 mt-auto">
                        <a href="product.php?id=<?php echo $product['id'] ?>" class="btn btn-primary">View Product</a>
                        <a href="cart.php?product_id=<?php echo $product['id'] ?>" class="btn btn-success">Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php template('footer.php'); ?>