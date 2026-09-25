<?php
require_once 'config/database.php';
$pdo = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM product WHERE id = ?");
    $stmt->execute([$id]);
    
    header('Location: index.php?msg=Produknya terhapus coy');
    exit;
}
?>