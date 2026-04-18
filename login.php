<?php
session_start();
include 'includes/db.php';

if(isset($_POST['login_btn'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $res = $conn->query("SELECT * FROM users WHERE username='$user' AND password='$pass'");
    if($res->num_rows > 0) {
        $_SESSION['admin_auth'] = true;
        header("Location: admin.php");
    } else {
        $error = "Login yoki parol xato!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-secondary">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4 mt-5">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="text-center mb-4">Admin Kirish</h4>
                        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                        <form method="POST">
                            <input type="text" name="username" class="form-control mb-3" placeholder="Login" required>
                            <input type="password" name="password" class="form-control mb-3" placeholder="Parol" required>
                            <button name="login_btn" class="btn btn-primary w-100">Kirish</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>