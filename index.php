<?php include 'includes/db.php'; ?>
<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Kutubxona | Asosiy Sahifa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root { --primary-color: #003366; --accent-color: #f39c12; }
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background-color: white !important; border-bottom: 3px solid var(--primary-color); }
        .book-card { border: none; border-radius: 12px; transition: 0.3s; height: 100%; }
        .book-card:hover { transform: translateY(-7px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .book-img { height: 280px; object-fit: cover; border-radius: 12px 12px 0 0; }
        .search-section { background: var(--primary-color); color: white; padding: 40px 0; border-radius: 0 0 30px 30px; }
        .category-link { text-decoration: none; color: #555; padding: 8px 15px; border-radius: 20px; background: white; display: inline-block; margin: 5px; border: 1px solid #ddd; transition: 0.3s; }
        .category-link:hover, .category-link.active { background: var(--primary-color); color: white; border-color: var(--primary-color); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-uppercase" href="index.php" style="color: var(--primary-color);">
            <i class="fas fa-book-reader me-2"></i> Tuit Library
        </a>
        <a href="login.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-lock me-1"></i> Admin</a>
    </div>
</nav>

<section class="search-section shadow-sm">
    <div class="container text-center">
        <h2 class="mb-4 fw-bold">Raqamli kutubxonaga xush kelibsiz</h2>
        <form action="index.php" method="GET" class="row justify-content-center">
            <div class="col-md-6">
                <div class="input-group input-group-lg">
                    <input type="text" name="s" class="form-control border-0 shadow-none" placeholder="Kitob nomi yoki muallif..." value="<?php echo $_GET['s'] ?? ''; ?>">
                    <button class="btn btn-warning px-4" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
</section>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <h5 class="fw-bold mb-3 border-start border-4 border-warning ps-2">Kategoriyalar</h5>
            <div class="category-list">
                <a href="index.php" class="category-link <?php echo !isset($_GET['cat']) ? 'active' : ''; ?>">Hammasi</a>
                <?php
                $cats = $conn->query("SELECT * FROM categories");
                while($c = $cats->fetch_assoc()):
                ?>
                <a href="index.php?cat=<?php echo $c['id']; ?>" class="category-link <?php echo (isset($_GET['cat']) && $_GET['cat'] == $c['id']) ? 'active' : ''; ?>">
                    <?php echo $c['name']; ?>
                </a>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                <?php
                $where = "WHERE 1=1";
                if(isset($_GET['s'])) {
                    $s = mysqli_real_escape_string($conn, $_GET['s']);
                    $where .= " AND (title LIKE '%$s%' OR author LIKE '%$s%')";
                }
                if(isset($_GET['cat'])) {
                    $cat = (int)$_GET['cat'];
                    $where .= " AND category_id = $cat";
                }

                $query = "SELECT b.*, c.name as cat_name FROM books b 
                          LEFT JOIN categories c ON b.category_id = c.id 
                          $where ORDER BY b.id DESC";
                $res = $conn->query($query);

                if($res->num_rows > 0):
                    while($row = $res->fetch_assoc()):
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card book-card shadow-sm">
                        <img src="uploads/covers/<?php echo $row['cover_image']; ?>" class="card-img-top book-img" alt="Muqova">
                        <div class="card-body">
                            <small class="text-warning fw-bold text-uppercase"><?php echo $row['cat_name']; ?></small>
                            <h6 class="card-title fw-bold mt-1 text-truncate" title="<?php echo $row['title']; ?>"><?php echo $row['title']; ?></h6>
                            <p class="card-text text-muted small"><i class="fas fa-pen-nib me-1"></i> <?php echo $row['author']; ?></p>
                            <div class="d-grid mt-3">
                                <a href="uploads/pdfs/<?php echo $row['pdf_file']; ?>" target="_blank" class="btn btn-primary rounded-pill">
                                    <i class="fas fa-eye me-2"></i> Mutolaa qilish
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; else: ?>
                <div class="col-12 text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Hech qanday kitob topilmadi.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<footer class="bg-white py-4 mt-5 border-top">
    <div class="container text-center">
        <p class="text-muted mb-0">© 2026 E-Kutubxona Tizimi. Individual loyiha ishi.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>