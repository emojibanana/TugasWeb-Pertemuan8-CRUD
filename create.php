<?php
require_once 'config/database.php';
$pdo = Database::getInstance()->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $categoryid = (int) $_POST['category_id'];
    $supplierid = (int) $_POST['supplier_id'];
    $price = (float) $_POST['price'];
    $stock = (int) $_POST['stock'];

    $sql = "INSERT INTO product (name, category_id, supplier_id, price, stock)
    VALUES (?,?,?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $name, $categoryid, $supplierid, $price, $stock
    ]);

    header('Location: index.php?msg=Tebuat coy');
    exit;
}

// Fetch Kategori & Supplier untuk bagian dropdown (disembunyikan untuk ringkasnya)
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$suppliers = $pdo->query("SELECT * FROM suppliers")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 w-full max-w-xl">
        <div class="mb-8 border-b border-slate-100 pb-4">
            <h2 class="text-2xl font-bold text-slate-800">Tambah Produk Baru</h2>
            <p class="text-slate-500 text-sm mt-1">Lengkapi form di bawah untuk menambah data ke inventaris.</p>
        </div>

        <form method="POST" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Produk</label>
                <input type="text" name="name" required class="w-full border border-slate-300 rounded-lg px-4 py-2.5 
                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow" placeholder="Masukkan Nama Produk......">
            </div>

            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                    <select name="category_id" required class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none
                    focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <!-- Placeholder diletakkan di luar foreach -->
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        <?php foreach($categories as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Supplier</label>
                    <select name="supplier_id" required class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none
                    focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <!-- Placeholder diletakkan di luar foreach -->
                        <option value="" disabled selected>-- Pilih Supplier --</option>
                        <?php foreach($suppliers as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Harga (Rp)</label>
                    <input type="number" step="0.01" name="price" required class="w-full border border-slate-300 rounded-lg px-4 py-2.5
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="0">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Stok Awal</label>
                    <input type="number" name="stock" required class="w-full border border-slate-300 rounded-lg px-4 py-2.5 
                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="0">
                </div>

                <div class="flex items-center gap-4 pt-4 mt-6 border-t border-slate-100">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-6 
                    rounded-lg transition-colors w-full sm:w-auto">Simpan</button>
                    <a href="index.php" class="text-slate-500 hover:text-slate-800 font-medium transition-colors">
                        Batal
                    </a>
                </div>
            </div>
        </form>    
    </div>
</body>
</html>