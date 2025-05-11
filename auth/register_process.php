<?php
session_start();
require_once '../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_var($_POST['username']);
    $email = filter_var($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi input
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "Semua field harus diisi.";
        header("Location: ../register.php");
        exit();
    }
    
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Password dan konfirmasi password tidak cocok.";
        header("Location: ../register.php");
        exit();
    }
    
    $database = new Database();
    $db = $database->getConnection();
    
    // Cek apakah email sudah terdaftar
    $query = "SELECT id FROM users WHERE email = :email LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $_SESSION['error'] = "Email sudah terdaftar.";
        header("Location: ../register.php");
        exit();
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert user baru
    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $db->prepare($query);
    
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hashed_password);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Registrasi berhasil! Silakan login.";
        header("Location: ../login.php");
        exit();
    } else {
        $_SESSION['error'] = "Terjadi kesalahan. Silakan coba lagi.";
        header("Location: ../register.php");
        exit();
    }
} else {
    header("Location: ../register.php");
    exit();
} 