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
$query = "SELECT id, product_code, name, stock, price FROM products WHERE stock > 0 ORDER BY name ASC";
$stmt = $db->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Render header
$header = new Header('Tambah Transaksi Baru');
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
                <h2>Tambah Transaksi Baru</h2>
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
                    <form action="create.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product_id" class="form-label">Produk</label>
                                <select class="form-select" id="product_id" name="product_id" required>
                                    <option value="">Pilih Produk</option>
                                    <?php foreach($products as $product): ?>
                                    <option value="<?php echo $product['id']; ?>" 
                                            data-price="<?php echo $product['price']; ?>"
                                            data-stock="<?php echo $product['stock']; ?>">
                                        <?php echo htmlspecialchars($product['product_code'] . ' - ' . $product['name']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customer_name" class="form-label">Nama Pembeli</label>
                                <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                                <small class="text-muted">Stok tersedia: <span id="available_stock">0</span></small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="price" class="form-label">Harga Satuan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="price" name="price" readonly>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="total_amount" class="form-label">Total</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="total_amount" name="total_amount" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="payment_method" class="form-label">Metode Pembayaran</label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option value="">Pilih Metode Pembayaran</option>
                                    <option value="cash">Cash</option>
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="qris">QRIS</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="payment_status" class="form-label">Status Pembayaran</label>
                                <select class="form-select" id="payment_status" name="payment_status" required>
                                    <option value="paid">Lunas</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const priceInput = document.getElementById('price');
    const totalInput = document.getElementById('total_amount');
    const availableStockSpan = document.getElementById('available_stock');

    function updateTotal() {
        const quantity = parseInt(quantityInput.value) || 0;
        const price = parseInt(priceInput.value) || 0;
        totalInput.value = quantity * price;
    }

    function updateProductInfo() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        if (selectedOption.value) {
            const price = selectedOption.dataset.price;
            const stock = selectedOption.dataset.stock;
            priceInput.value = price;
            availableStockSpan.textContent = stock;
            quantityInput.max = stock;
            updateTotal();
        } else {
            priceInput.value = '';
            totalInput.value = '';
            availableStockSpan.textContent = '0';
        }
    }

    productSelect.addEventListener('change', updateProductInfo);
    quantityInput.addEventListener('input', function() {
        const max = parseInt(this.max);
        if (this.value > max) {
            this.value = max;
        }
        updateTotal();
    });
});
</script>

<?php
// Render footer
$footer = new Footer();
$footer->render();
?> 