<?php include 'app/views/shares/header.php'; ?>

<div class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Danh sách sản phẩm</h1>
        <a href="/VoTuanKiet/Product/add" 
           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-400 text-white font-semibold px-5 py-3 rounded-xl shadow-lg transition transform hover:scale-105 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Thêm sản phẩm mới
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($products as $product): ?>
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-1">
                <div class="relative aspect-[3/2] overflow-hidden">
                    <?php if ($product->image && file_exists($_SERVER['DOCUMENT_ROOT'] . '/VoTuanKiet/' . $product->image)): ?>
                        <img 
                            src="/VoTuanKiet/<?php echo $product->image; ?>" 
                            alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
                            class="w-full h-full object-cover object-center transition-transform duration-300 ease-in-out hover:scale-110"
                        >
                    <?php else: ?>
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="p-5 flex flex-col justify-between h-[230px]">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <a href="/VoTuanKiet/Product/show/<?php echo $product->id; ?>" 
                               class="text-xl font-semibold text-gray-800 hover:text-emerald-600 transition duration-300 hover:underline">
                                <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                            <span class="bg-emerald-100 text-emerald-700 text-xs font-semibold px-3 py-1 rounded-full">
                                <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </div>

                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">
                            <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    </div>

                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-2xl font-extrabold text-rose-600">
                            <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                        </span>

                        <div class="flex space-x-3">
                            <a href="/VoTuanKiet/Product/edit/<?php echo $product->id; ?>" 
                               class="flex items-center gap-1 bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-md transition transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Sửa
                            </a>

                            <a href="/VoTuanKiet/Product/delete/<?php echo $product->id; ?>" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');" 
                               class="flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow-md transition transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Xóa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
