<?php include 'helpers/functions.php'; ?>
<?php

if(!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

?>
<?php template('header.php'); ?>
<?php

use Aries\MiniFrameworkStore\Models\Product;

$productId = $_GET['id'];
$products = new Product();
$product = $products->getById($productId);

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
    margin-bottom: 0.75rem;
    text-shadow: 0 2px 6px rgba(0,0,0,0.8);
    color: #f1c40f; /* Gryffindor Gold */
  }
  h4 {
    font-weight: 600;
    color: #f1c40f; /* Gryffindor Gold */
    text-shadow: 0 0 5px #f1c40faa;
    margin-bottom: 1.2rem;
  }
  p {
    font-size: 1.1rem;
    line-height: 1.5;
    color: #ccc;
    margin-bottom: 2rem;
  }
  .img-fluid {
    border-radius: 20px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.6);
    max-height: 400px;
    width: 100%;
    object-fit: cover;
  }
  .btn-success {
    background: linear-gradient(45deg, #00b894, #00876c); /* Hufflepuff colors */
    border: none;
    font-weight: 600;
    padding: 12px 25px;
    font-size: 1.1rem;
    border-radius: 12px;
    transition: background 0.3s ease;
    box-shadow: 0 6px 15px #00876caa;
  }
  .btn-success:hover {
    background: linear-gradient(45deg, #00876c, #00b894);
    box-shadow: 0 8px 25px #00b894cc;
  }
  .d-flex {
    gap: 15px;
  }
  /* Responsive tweak */
  @media (max-width: 767px) {
    .container {
      padding: 0 1rem;
    }
    .img-fluid {
      max-height: 300px;
    }
  }
</style>

<div class="container my-5">
    <div class="row g-4">
        <div class="col-md-6">
            <img src="<?php echo htmlspecialchars($product['image_path']) ?>" alt="<?php echo htmlspecialchars($product['name']) ?>" class="img-fluid">
        </div>
        <div class="col-md-6 d-flex flex-column justify-content-center">
            <h1><?php echo htmlspecialchars($product['name']) ?></h1>
            <h4><?php echo $pesoFormatter->formatCurrency($product['price'], 'PHP'); ?></h4>
            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            <div class="d-flex">
                <a href="#" class="btn btn-success add-to-cart" data-productid="<?php echo $product['id'] ?>" data-quantity="1">Add to Cart</a>
            </div>
        </div>
    </div>
</div>

<?php template('footer.php'); ?>