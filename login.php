<?php
ob_start();
include 'helpers/functions.php';
template('header.php');

use Aries\MiniFrameworkStore\Models\User;

$user = new User();

if(isset($_POST['submit'])) {
    $user_info = $user->login([
        'email' => $_POST['email'],
    ]);

    if($user_info && password_verify($_POST['password'], $user_info['password'])) {
        $_SESSION['user'] = $user_info;
        if (isset($user_info['role_id']) && $user_info['role_id'] == 1) {
            header('Location: dashboard.php');
        } else {
            header('Location: my-account.php');
        }
        exit;
    } else {
        $message = 'Invalid username or password';
    }
}

if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    header('Location: my-account.php');
    exit;
}
?>

<style>
  body {
    background: linear-gradient(135deg, #4e1f1f, #f9e79f); /* Gryffindor Red to Gold */
    min-height: 100vh;
    color: #f5f5f7;
    font-family: 'Montserrat', sans-serif;
  }
  .container {
    max-width: 600px;
  }
  h1 {
    color: #f1c40f; /* Gryffindor Gold */
  }
  h3 {
    color: #ff4d4d; /* Red for error messages */
  }
  .form-control {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid #f1c40f; /* Gold border */
    color: #ddd;
  }
  .form-control::placeholder {
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
</style>

<div class="container">
    <div class="row align-items-center">
        <div class="col mt-5 mb-5">
            <h1 class="text-center">Login</h1>
            <h3 class="text-center"><?php echo isset($message) ? $message : ''; ?></h3>
            <form style="margin: auto;" action="login.php" method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your email">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter your password">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Remember me</label>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</div>

<?php template('footer.php'); ?>