<?php
include 'includes/db.php';

if(isset($_POST['save_book'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $cat_id = $_POST['category_id'];

    // Fayllarga vaqt tamg'asi bilan nom beramiz (nomlar bir xil bo'lib qolmasligi uchun)
    $cover_name = time() . "_" . $_FILES['cover']['name'];
    $pdf_name = time() . "_" . $_FILES['pdf']['name'];

    // Yuklash manzillari
    $target_cover = "uploads/covers/" . $cover_name;
    $target_pdf = "uploads/pdfs/" . $pdf_name;

    if(move_uploaded_file($_FILES['cover']['tmp_name'], $target_cover) && 
       move_uploaded_file($_FILES['pdf']['tmp_name'], $target_pdf)) {
        
        $sql = "INSERT INTO books (title, author, category_id, cover_image, pdf_file) 
                VALUES ('$title', '$author', '$cat_id', '$cover_name', '$pdf_name')";
        
        if($conn->query($sql)) {
            echo "<script>alert('Kitob muvaffaqiyatli qo\'shildi!'); window.location='index.php';</script>";
        } else {
            echo "Baza bilan bog'liq xatolik: " . $conn->error;
        }
    } else {
        echo "Fayllarni serverga yuklashda xatolik! Papkalar mavjudligini tekshiring.";
    }
}
?>