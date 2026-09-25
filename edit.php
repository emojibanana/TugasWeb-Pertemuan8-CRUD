<?php
require_once 'config/database.php';
$pdo = Database::getInstance()->getConnection();

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

 // Ambil data lama untuk form
    $id = (int) $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM product WHERE id = ?");
    $stmt->execute([$id]); 
    $product = $stmt->fetch(); 

    // Proses update
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {    
        $stmt = $pdo->prepare(
            "UPDATE product
            SET name=?, category_id=?, supplier_id=?, price=?, stock=?         
            WHERE id=?"    
        );
        $stmt->execute([
            $_POST['name'],  
            (int)$_POST['category_id'],      
            (int)$_POST['supplier_id'],      
            (float)$_POST['price'],        
            (int)$_POST['stock'],        
            $id    
        ]);    
        
        header('Location: index.php?msg=Teganti coy');
        exit; 
    } 

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$suppliers = $pdo->query("SELECT * FROM suppliers")->fetchAll();
?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
 </head>
 <body class="bg-slate-100 min-h-screen flex items-center justify-center p-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8 w-full max-w-xl">
        <div class="mb-8 border-b border-slate-100 pb-4">
            <h2 class="text-2xl font-bold text-slate-800">Edit Produk</h2>
            <p class="text-slate-500 text-sm mt-1">Ubah form di bawah untuk mengedit data inventaris.</p>
        </div>

        <form method="POST" class="space-y-5">
            <!-- Value diisi dengan data lama -->
             <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Produk</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($product['name']) ?>" class="w-full border border-slate-300 rounded-lg px-4 py-2.5 
                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow" placeholder="Masukkan Nama Produk......">
            </div>
            
            <div class="grid grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                    <select name="category_id" required class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none
                    focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <?php foreach($categories as $c): ?>
                            <!-- Logika IF untuk menandai opsi yang aktif sebelumnya (selected) -->
                            <option value="<?= $c['id'] ?>" <?= ($c['id'] == $product['category_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Supplier</label>
                    <select name="supplier_id" required class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:outline-none
                    focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <?php foreach($suppliers as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= ($s['id'] == $product['supplier_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Harga (Rp)</label>
                        <input type="number" step="0.01" name="price" required class="w-full border border-slate-300 rounded-lg px-4 py-2.5
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="<?= $product['price'] ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Stok Awal</label>
                        <input type="number" name="stock" required class="w-full border border-slate-300 rounded-lg px-4 py-2.5 
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" value="<?= $product['stock'] ?>">
                    </div>
                    <div class="flex items-center gap-4 pt-4 mt-6 border-t border-slate-100">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-6 
                        rounded-lg transition-colors w-full sm:w-auto">Update</button>
                    </div>
            </div>
        </form>
    </div>
 </body>
 </html>