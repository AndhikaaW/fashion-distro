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

// Query untuk mengambil semua penjualan
$querysale = "SELECT * FROM sales ORDER BY created_at ASC";
$sales = $db->prepare($querysale);
$sales->execute();

// Render header
$header = new Header('Daftar Penjualan');
$header->render();

// Render sidebar
$sidebar = new Sidebar('sales');
$sidebar->render();
?>

<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Daftar Penjualan</h2>
                <div class="d-flex">
                    <a href="create.php" class="btn btn-primary me-2">
                        <i class="fas fa-plus"></i> Tambah Transaksi
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
                                    <th>Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Produk</th>
                                    <th>Pembeli</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                    <th>Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $sales->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['invoice_number']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                    <td>
                                        <?php 
                                        // Ambil data produk dari tabel products berdasarkan product_id
                                        $product_query = "SELECT product_code, name FROM products WHERE id = :product_id";
                                        $stmt = $db->prepare($product_query);
                                        $stmt->bindParam(':product_id', $row['product_id']);
                                        $stmt->execute();
                                        $product_data = $stmt->fetch(PDO::FETCH_ASSOC);
                                        
                                        if ($product_data) {
                                            echo htmlspecialchars($product_data['product_code']) . ' - ';
                                            echo htmlspecialchars($product_data['name']);
                                        } else {
                                            echo "Produk tidak ditemukan";
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                    <td>Rp <?php echo number_format($row['total_amount'], 0, ',', '.'); ?></td>
                                    <td>
                                        <?php
                                        $payment_methods = [
                                            'cash' => 'Cash',
                                            'transfer' => 'Transfer Bank',
                                            'qris' => 'QRIS'
                                        ];
                                        echo $payment_methods[$row['payment_method']] ?? $row['payment_method'];
                                        ?>
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