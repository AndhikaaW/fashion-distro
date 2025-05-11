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

// Query untuk mengambil semua produk
$query = "SELECT * FROM products ORDER BY created_at ASC";
$product = $db->prepare($query);
$product->execute();

// Render header
$header = new Header('Daftar Produk');
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
                <h2>Daftar Produk</h2>
                <div class="d-flex">
                    <a href="create.php" class="btn btn-primary me-2">
                        <i class="fas fa-plus"></i> Tambah Produk
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

            <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Ukuran</th>
                                    <th>Warna</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $product->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['product_code']); ?></td>
                                    <td>
                                        <?php if($row['image']): ?>
                                        <img src="../uploads/products/<?php echo htmlspecialchars($row['image']); ?>" class="product-image" alt="<?php echo htmlspecialchars($row['name']); ?>">
                                        <?php else: ?>
                                        <img src="../assets/img/no-image.png" class="product-image" alt="No Image">
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['category']); ?></td>
                                    <td><?php echo htmlspecialchars($row['size']); ?></td>
                                    <td><?php echo htmlspecialchars($row['color']); ?></td>
                                    <td><?php echo htmlspecialchars($row['stock']); ?></td>
                                    <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php
                                        if ($row['stock'] > 20) {
                                            echo '<span class="stock-status stock-high">Stok Tinggi</span>';
                                        } elseif ($row['stock'] > 10) {
                                            echo '<span class="stock-status stock-medium">Stok Sedang</span>';
                                        } else {
                                            echo '<span class="stock-status stock-low">Stok Rendah</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
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