<?php
class Footer {
    public function render() {
        ?>
        <!-- Bootstrap 5.2 JS Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Chart.js untuk grafik -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Toggle sidebar functionality
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');
                const toggleBtn = document.getElementById('toggleSidebar');
                const logoText = document.getElementById('logoText');
                
                toggleBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                    
                    if (sidebar.classList.contains('collapsed')) {
                        logoText.style.display = 'none';
                    } else {
                        logoText.style.display = 'block';
                    }
                });
            });

            // Fungsi untuk menampilkan alert
            function showAlert(message, type) {
                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
                alertDiv.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                
                const activeContent = document.querySelector('[id$="Content"]:not([style*="display: none"])');
                activeContent.insertBefore(alertDiv, activeContent.firstChild);
                
                setTimeout(() => {
                    alertDiv.remove();
                }, 5000);
            }
        </script>
        </body>
        </html>
        <?php
    }
}
?> 