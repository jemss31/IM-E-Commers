<?php 
include 'helpers/functions.php'; 
template('header.php'); 
?>

<?php

use Aries\MiniFrameworkStore\Models\Category;
use Aries\MiniFrameworkStore\Models\Product;
use Carbon\Carbon;

$categories = new Category();
$product = new Product();

if (isset($_POST['submit'])) {
    if (!isLoggedIn()) {
        $message = "Guests are not allowed to add products. Please log in.";
        $messageType = "danger";
    } else {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $image = $_FILES['image'];

        // Validate and process the image file
        if ($image['error'] === UPLOAD_ERR_OK) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($image["name"]);
            move_uploaded_file($image["tmp_name"], $targetFile);
        } else {
            $targetFile = null;
        }

        // Insert the product into the database
        $product->insert([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'slug' => strtolower(str_replace(' ', '-', $name)),
            'image_path' => $targetFile,
            'category_id' => $category,
            'created_at' => Carbon::now('Asia/Manila'),
            'updated_at' => Carbon::now()
        ]);

        $message = "Product added successfully!";
        $messageType = "success";
    }
}
?>

<style>
  body {
    background: linear-gradient(135deg, #4e1f1f, #f9e79f); /* Gryffindor Red to Gold */
    color: #f5f5f7;
    font-family: 'Montserrat', sans-serif;
  }
  .container {
    max-width: 600px;
  }
  h1 {
    font-family: 'Lora', serif;
    font-weight: 700;
    font-size: 2.8rem;
    margin-bottom: 1rem;
    text-align: center;
    color: #f1c40f; /* Gryffindor Gold */
    text-shadow: 0 2px 6px rgba(0,0,0,0.8);
  }
  p {
    text-align: center;
    font-size: 1.2rem;
    color: #ccc;
    margin-bottom: 2rem;
  }
  form {
    background: rgba(30, 30, 50, 0.85); /* Dark background for form */
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.7);
  }
  label {
    font-weight: 600;
    color: #d1d1d1;
  }
  input.form-control, textarea.form-control, select.form-select {
    background: #2a293c; /* Dark input background */
    border: none;
    border-radius: 8px;
    color: #eee;
    padding: 12px;
    box-shadow: inset 0 3px 6px rgba(0,0,0,0.5);
    transition: background-color 0.3s ease;
  }
  input.form-control:focus, textarea.form-control:focus, select.form-select:focus {
    background: #3b3a55; /* Lighter on focus */
    outline: none;
    color: #fff;
  }
  .btn-primary {
    background: linear-gradient(45deg, #9b1e1e, #f9e79f); /* Gryffindor colors */
    border: none;
    padding: 14px 0;
    font-size: 1.25rem;
    font-weight: 700;
    border-radius: 12px;
    box-shadow: 0 8px 20px #341f9780;
    transition: background 0.3s ease;
  }
  .btn-primary:hover {
    background: linear-gradient(45deg, #f9e79f, #9b1e1e);
    box-shadow: 0 10px 30px #6c5ce780;
  }
  .alert {
    font-size: 1.1rem;
    border-radius: 12px;
    padding: 15px 20px;
    margin-bottom: 25px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.5);
  }
</style>

<div class="container my-5">
    <h1>Add Product</h1>
    <p>Fill in the details below to add a new product.</p>

    <?php if (isset($message)): ?>
        <div class="alert alert-<?php echo $messageType; ?>" role="alert">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form action="add-product.php" method="POST" enctype="multipart/form-data" novalidate>
        <div class="mb-4">
            <label for="product-name">Product Name</label>
            <input type="text" class="form-control" id="product-name" name="name" required>
        </div>
        <div class="mb-4">
            <label for="product-description">Description</label>
            <textarea class="form-control" id="product-description" name="description" rows="6"></textarea>
        </div>
        <div class="mb-4">
            <label for="product-price">Price</label>
            <input type="text" class="form-control" id="product-price" name="price" required>
        </div>
        <div class="mb-4">
            <label for="product-category">Category</label>
            <select class="form-select" id="product-category" name="category" required>
                <option value="" disabled selected>Select category</option>
                <?php foreach($categories->getAll() as $category): ?>
                <option value="<?php echo htmlspecialchars($category['id']); ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-4">
            <label for="formFile" class="form-label">Image</label>
            <input class="form-control" type="file" id="formFile" name="image" accept="image/*">
        </div>
        <div class="d-grid">
            <button class="btn btn-primary" type="submit" name="submit">Add Product</button>
        </div>
    </form>
</div>

<?php template('footer.php'); ?>