<?php
class Sidebar {
    private $activePage;
    
    public function __construct($activePage = 'dashboard') {
        $this->activePage = $activePage;
    }
    
    public function render() {
        ?>
        <div class="sidebar" id="sidebar">
            <div class="logo">
                <h4 id="logoText">Fashion Inventory</h4>
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="mt-4">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $this->activePage === 'dashboard' ? 'active' : ''; ?>" href="/dashboard.php">
                            <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $this->activePage === 'products' ? 'active' : ''; ?>" href="/products/index.php">
                            <i class="fas fa-tshirt"></i> <span>Produk</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $this->activePage === 'sales' ? 'active' : ''; ?>" href="/sales/index.php">
                            <i class="fas fa-shopping-cart"></i> <span>Penjualan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $this->activePage === 'reports' ? 'active' : ''; ?>" href="reports/index.php">
                            <i class="fas fa-chart-bar"></i> <span>Laporan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $this->activePage === 'settings' ? 'active' : ''; ?>" href="settings/index.php">
                            <i class="fas fa-cog"></i> <span>Pengaturan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <?php
    }
}
?> 