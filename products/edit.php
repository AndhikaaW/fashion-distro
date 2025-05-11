<?php
session_start();
require_once '../config/database.php';
require_once '../includes/header.php';
require_once '../includes/sidebar.php';
require_once '../includes/footer.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

// Ambil data produk berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        $_SESSION['error'] = "Produk tidak ditemukan!";
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

// Render header
$header = new Header('Edit Produk');
$header->render();

// Render sidebar
$sidebar = new Sidebar('products');
$sidebar->render();
?>

<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Edit Produk</h2>
                <div class="d-flex">
                    <a href="index.php" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../auth/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form action="edit.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product_code" class="form-label">Kode Produk</label>
                                <input type="text" class="form-control" id="product_code" name="product_code" value="<?php echo htmlspecialchars($product['product_code']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="T-Shirt" <?php echo $product['category'] == 'T-Shirt' ? 'selected' : ''; ?>>T-Shirt</option>
                                    <option value="Hoodie" <?php echo $product['category'] == 'Hoodie' ? 'selected' : ''; ?>>Hoodie</option>
                                    <option value="Jaket" <?php echo $product['category'] == 'Jaket' ? 'selected' : ''; ?>>Jaket</option>
                                    <option value="Celana" <?php echo $product['category'] == 'Celana' ? 'selected' : ''; ?>>Celana</option>
                                    <option value="Aksesoris" <?php echo $product['category'] == 'Aksesoris' ? 'selected' : ''; ?>>Aksesoris</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="size" class="form-label">Ukuran</label>
                                <select class="form-select" id="size" name="size">
                                    <option value="">Pilih Ukuran</option>
                                    <option value="S" <?php echo $product['size'] == 'S' ? 'selected' : ''; ?>>S</option>
                                    <option value="M" <?php echo $product['size'] == 'M' ? 'selected' : ''; ?>>M</option>
                                    <option value="L" <?php echo $product['size'] == 'L' ? 'selected' : ''; ?>>L</option>
                                    <option value="XL" <?php echo $product['size'] == 'XL' ? 'selected' : ''; ?>>XL</option>
                                    <option value="XXL" <?php echo $product['size'] == 'XXL' ? 'selected' : ''; ?>>XXL</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="color" class="form-label">Warna</label>
                                <input type="text" class="form-control" id="color" name="color" value="<?php echo htmlspecialchars($product['color']); ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="stock" name="stock" min="0" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="price" name="price" min="0" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Gambar Produk</label>
                            <?php if($product['image']): ?>
                            <div class="mb-2">
                                <img src="../uploads/products/<?php echo htmlspecialchars($product['image']); ?>" alt="Current Image" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Render footer
$footer = new Footer();
$footer->render();
?> 