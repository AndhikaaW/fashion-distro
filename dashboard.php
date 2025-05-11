<?php
session_start();
require_once 'config/database.php';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';
require_once 'includes/footer.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();

// Query untuk mengambil semua produk
$query = "SELECT * FROM products ORDER BY created_at ASC";
$product = $db->prepare($query);
$product->execute();

$querysale = "SELECT * FROM sales ORDER BY created_at ASC";
$sales = $db->prepare($querysale);
$sales->execute();

// Render header
$header = new Header();
$header->render();

// Render sidebar
$sidebar = new Sidebar('dashboard');
$sidebar->render();
?>

<div class="container-fluid">
    <div class="row">
        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Dashboard Inventaris</h2>
                <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                <div class="d-flex">
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="auth/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card card-stats">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">Total Produk</h6>
                                <h3>248</h3>
                            </div>
                            <div class="icon">
                                <i class="fas fa-tshirt"></i>
                            </div>
                        </div>
                        <p class="text-success mt-2 mb-0"><i class="fas fa-arrow-up"></i> 12% dari bulan lalu</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card card-stats">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">Stok Rendah</h6>
                                <h3>15</h3>
                            </div>
                            <div class="icon">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                        <p class="text-danger mt-2 mb-0"><i class="fas fa-arrow-up"></i> 5% dari bulan lalu</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card card-stats">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">Penjualan Bulan Ini</h6>
                                <h3>Rp 15,2 Jt</h3>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <p class="text-success mt-2 mb-0"><i class="fas fa-arrow-up"></i> 8% dari bulan lalu</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 mb-3">
                    <div class="card card-stats">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted">Nilai Inventaris</h6>
                                <h3>Rp 85,7 Jt</h3>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                        <p class="text-success mt-2 mb-0"><i class="fas fa-arrow-up"></i> 3% dari bulan lalu</p>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Aksi Cepat</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="products/create.php" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Produk
                                </a>
                                <button class="btn btn-success"><i class="fas fa-file-import"></i> Update Stok</button>
                                <button class="btn btn-info text-white"><i class="fas fa-print"></i> Cetak Laporan</button>
                                <button class="btn btn-warning text-white"><i class="fas fa-tags"></i> Kelola Kategori</button>
                                <button class="btn btn-danger"><i class="fas fa-exclamation-circle"></i> Lihat Stok Rendah</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activities and Low Stock -->
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Aktivitas Terbaru</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0"><strong>Admin</strong> menambahkan stok Hoodie Distro</p>
                                        <small class="text-muted">Hari ini, 10:45</small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill">+10</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0"><strong>Admin</strong> mengubah harga Kaos Premium</p>
                                        <small class="text-muted">Hari ini, 09:30</small>
                                    </div>
                                    <span class="badge bg-warning text-dark rounded-pill">Edit</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0"><strong>Admin</strong> menambahkan produk baru</p>
                                        <small class="text-muted">Kemarin, 15:20</small>
                                    </div>
                                    <span class="badge bg-success rounded-pill">Baru</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0"><strong>Admin</strong> menghapus produk Topi Snapback</p>
                                        <small class="text-muted">Kemarin, 14:05</small>
                                    </div>
                                    <span class="badge bg-danger rounded-pill">Hapus</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Produk dengan Stok Rendah</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produk</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Hoodie Distro (Navy, XL)</td>
                                            <td><span class="badge bg-danger">5</span></td>
                                            <td><button class="btn btn-sm btn-primary">Restock</button></td>
                                        </tr>
                                        <tr>
                                            <td>Kemeja Flanel (Merah, L)</td>
                                            <td><span class="badge bg-danger">3</span></td>
                                            <td><button class="btn btn-sm btn-primary">Restock</button></td>
                                        </tr>
                                        <tr>
                                            <td>Topi Trucker (Hitam)</td>
                                            <td><span class="badge bg-danger">7</span></td>
                                            <td><button class="btn btn-sm btn-primary">Restock</button></td>
                                        </tr>
                                        <tr>
                                            <td>Kaos Lengan Panjang (Abu, M)</td>
                                            <td><span class="badge bg-danger">8</span></td>
                                            <td><button class="btn btn-sm btn-primary">Restock</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
