<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login - Sistem Admin</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    </head>
    <body class="bg-gradient-primary">
        <div class="container">
            <div class="row justify-content-center vh-100 align-items-center">
                <div class="col-lg-5">
                    <div class="card border-0 shadow-lg rounded-4 my-5">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <i class="bi bi-shield-lock fs-1 text-primary"></i>
                                <h2 class="fw-bold mt-2">Selamat Datang</h2>
                                <p class="text-muted">Silakan masuk untuk melanjutkan</p>
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

                            <?php if(isset($_SESSION['success'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php 
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php endif; ?>

                            <form action="auth/login_process.php" method="POST">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
                                    <label for="floatingInput"><i class="bi bi-envelope me-1"></i> Alamat Email</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" required>
                                    <label for="floatingPassword"><i class="bi bi-key me-1"></i> Kata Sandi</label>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">
                                        Ingat saya
                                    </label>
                                    <a href="reset-password.php" class="float-end text-decoration-none">Lupa kata sandi?</a>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg text-white" type="submit">
                                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                                    </button>
                                </div>
                                <hr class="my-4">
                                <div class="d-grid">
                                    <a href="register.php" class="btn btn-outline-secondary">
                                        <i class="bi bi-person-plus me-1"></i> Buat Akun Baru
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="text-center text-white">
                        <small>Copyright &copy; Sistem Admin 2023</small>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
