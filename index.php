<?php
require_once 'config/database.php';
$pdo = Database::getInstance()->getConnection();

$sql = "SELECT p.id, p.name, p.price, p.stock, c.name AS category, s.name AS supplier
FROM product p
JOIN categories c ON p.category_id = c.id
JOIN suppliers s ON p.supplier_id = s.id
ORDER BY p.name";

$stmt = $pdo->query($sql);
$product = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-slate-800">Data Inventaris</h1>
            <a href="create.php" class="bg-blue-400 hover:bg-blue-700 text-white 
            px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm">
                + Tambah Produk
            </a>
        </div>
            <!-- UI Flash Message -->
        <?php if (isset($_GET['msg'])): ?>
            <div class="bg-emerald-100 border-l-4 border-emerald-500 
            text-emerald-800 p-4 mb-6 rounded shadow-sm" role="alert">
            <?= htmlspecialchars($_GET['msg']) ?></div>
        <?php endif; ?>

        <!-- Tabel Data -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-slate-200">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 uppercase text-sm tracking-wider">
                        <th class="p-4 font-semibold">Nama</th>
                        <th class="p-4 font-semibold">Kategori</th>
                        <th class="p-4 font-semibold">Supplier</th>
                        <th class="p-4 font-semibold">Harga</th>
                        <th class="p-4 font-semibold">Stok</th>
                        <th class="p-4 font-semibold">Aksi</th>
                    </tr>
                </thead>  
                <tbody class="divide-y divide-slate-200">  
                    <?php foreach ($product as $p): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <!-- Wajib sanitasi output -->
                            <td class="p-4 text-slate-800 font-medium"><?= htmlspecialchars($p['name']) ?></td>
                            <td class="p-4 text-slate-800 font-medium"><?= htmlspecialchars($p['category']) ?></td>
                            <td class="p-4 text-slate-800 font-medium"><?= htmlspecialchars($p['supplier']) ?></td>
                            <td class="p-4 text-slate-800 font-medium">Rp <?= number_format($p['price'],0,',','.') ?></td>
                            <td class="p-4 text-slate-800 font-medium"><?= (int)$p['stock'] ?></td>
                            <td class="p-4 flex justify-center gap-2">
                                <a href="edit.php?id=<?= $p['id'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white 
                                px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm">Edit</a>
                                <!-- Konfirmasi hapus langsung di formulir (menggunakan onsubmit) -->
                                <form method="POST" action="delete.php" style="display:inline;" onsubmit="return confirm('Hapus produk ini?')">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white 
                                    px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>