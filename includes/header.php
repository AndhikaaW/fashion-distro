<?php
class Header {
    private $title;
    
    public function __construct($title = 'Dashboard Inventaris Fashion') {
        $this->title = $title;
    }
    
    public function render() {
        ?>
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo $this->title; ?></title>
            <!-- Bootstrap 5.2 CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
            <!-- Font Awesome untuk ikon -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
            <style>
                :root {
                    --primary-color: #6c63ff;
                    --secondary-color: #f8f9fa;
                    --accent-color: #ff6b6b;
                }
                
                body {
                    background-color: #f5f5f5;
                    font-family: 'Poppins', sans-serif;
                    overflow-x: hidden;
                    position: relative;
                    width: 100%;
                }
                
                .sidebar {
                    background-color: #ffffff;
                    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
                    height: 100vh;
                    position: fixed;
                    width: 250px;
                    z-index: 1000;
                    transition: all 0.3s ease;
                    left: 0;
                    overflow-y: auto;
                }
                
                .sidebar.collapsed {
                    width: 70px;
                }
                
                .sidebar .logo {
                    padding: 20px;
                    border-bottom: 1px solid #eee;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }
                
                .sidebar.collapsed .logo h4 {
                    display: none;
                }
                
                .sidebar .nav-link {
                    color: #333;
                    padding: 12px 20px;
                    margin: 5px 0;
                    border-radius: 5px;
                    transition: all 0.3s;
                    white-space: nowrap;
                    overflow: hidden;
                }
                
                .sidebar .nav-link:hover, .sidebar .nav-link.active {
                    background-color: var(--primary-color);
                    color: white;
                }
                
                .sidebar .nav-link i {
                    margin-right: 10px;
                    min-width: 20px;
                    text-align: center;
                }
                
                .sidebar.collapsed .nav-link span {
                    display: none;
                }
                
                .main-content {
                    margin-left: 250px;
                    padding: 20px;
                    transition: all 0.3s ease;
                    width: calc(100% - 250px);
                    overflow-x: hidden;
                }
                
                .main-content.expanded {
                    margin-left: 70px;
                    width: calc(100% - 70px);
                }
                
                .toggle-sidebar {
                    background: none;
                    border: none;
                    color: #333;
                    cursor: pointer;
                    font-size: 20px;
                }
                
                .card {
                    border: none;
                    border-radius: 10px;
                    box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
                    transition: transform 0.3s;
                }
                
                .card:hover {
                    transform: translateY(-5px);
                }
                
                .btn-primary {
                    background-color: var(--primary-color);
                    border: none;
                }
                
                .btn-primary:hover {
                    background-color: #5a52d5;
                }
            </style>
        </head>
        <body>
        <?php
    }
}
?> 