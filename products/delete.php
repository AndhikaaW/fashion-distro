<?php
session_start();
require_once '../config/database.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    
    // Ambil informasi gambar sebelum menghapus
    $query = "SELECT image FROM products WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Hapus data dari database
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            // Hapus file gambar jika ada
            if ($product['image'] && file_exists('../uploads/products/' . $product['image'])) {
                unlink('../uploads/products/' . $product['image']);
            }
            
            $_SESSION['success'] = "Produk berhasil dihapus!";
        } else {
            $_SESSION['error'] = "Gagal menghapus produk.";
        }
    } else {
        $_SESSION['error'] = "Produk tidak ditemukan.";
    }
}

header("Location: index.php");
exit(); 