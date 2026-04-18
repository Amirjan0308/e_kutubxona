<?php
session_start();
if(!isset($_SESSION['admin_auth'])) {
    header("Location: login.php");
    exit();
}
include 'includes/db.php';
?>

<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <title>Admin - Kitob Qo'shish</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0">📚 Yangi kitob yuklash tizimi</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="upload_logic.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kitob nomi:</label>
                                <input type="text" name="title" class="form-control" placeholder="Masalan: Sariq devni minib" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Muallif:</label>
                                <input type="text" name="author" class="form-control" placeholder="Xudoyberdi To'xtaboyev" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategoriya:</label>
                                <select name="category_id" class="form-select">
                                    <?php
                                    $res = $conn->query("SELECT * FROM categories");
                                    if($res->num_rows > 0) {
                                        while($row = $res->fetch_assoc()) {
                                            echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                        }
                                    } else {
                                        echo "<option>Kategoriyalar yo'q!</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Muqova (Rasm):</label>
                                    <input type="file" name="cover" class="form-control" accept="image/*" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Kitob fayli (PDF):</label>
                                    <input type="file" name="pdf" class="form-control" accept=".pdf" required>
                                </div>
                            </div>
                            <hr>
                            <button type="submit" name="save_book" class="btn btn-success w-100 py-2">Bazaga saqlash va yuklash</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>