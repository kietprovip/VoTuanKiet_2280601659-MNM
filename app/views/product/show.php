<?php include 'app/views/shares/header.php'; ?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300">
        <div class="bg-emerald-600 text-white py-5 px-8 text-center rounded-t-xl">
            <h2 class="text-3xl font-extrabold tracking-wide">Chi tiết sản phẩm</h2>
        </div>
        
        <?php if (isset($product) && is_object($product)): ?>
            <div class="md:flex">
                <div class="md:w-1/2 p-6 flex items-center justify-center">
                    <?php if (isset($product->image) && $product->image): ?>
                        <img src="/VoTuanKiet/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                             alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                             class="rounded-lg object-cover max-h-96 w-full transition-transform duration-300 ease-in-out hover:scale-105 shadow-md"
                        >
                    <?php else: ?>
                        <div class="w-full aspect-video bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="md:w-1/2 p-8 flex flex-col justify-between">
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-6 transition-colors duration-300 hover:text-emerald-600 cursor-default">
                        <?php echo htmlspecialchars($product->name ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </h3>
                    
                    <div class="prose max-w-none text-gray-700 mb-8 whitespace-pre-line">
                        <?php echo nl2br(htmlspecialchars($product->description ?? '', ENT_QUOTES, 'UTF-8')); ?>
                    </div>
                    
                    <div class="mb-8">
                        <span class="text-4xl font-extrabold text-red-600 drop-shadow-lg">
                            <?php echo number_format($product->price ?? 0, 0, ',', '.'); ?> VND
                        </span>
                    </div>
                    
                    <div class="mb-8">
                        <span class="text-sm font-semibold text-gray-700">Danh mục:</span>
                        <span class="ml-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 select-none">
                            <?php echo isset($product->category_name) && !empty($product->category_name) 
                                ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') 
                                : 'Chưa có danh mục'; 
                            ?>
                        </span>
                    </div>
                    
                    <div class="flex flex-wrap gap-4">
                        <a href="/VoTuanKiet/Product/addToCart/<?php echo $product->id ?? ''; ?>"
                           class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 active:bg-green-800 text-white font-semibold rounded-lg shadow-lg transition-transform duration-200 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                                <circle cx="7" cy="21" r="1" />
                                <circle cx="17" cy="21" r="1" />
                            </svg>
                            Thêm vào giỏ hàng
                        </a>
                        
                        <a href="/VoTuanKiet/Product/list"
                           class="inline-flex items-center px-6 py-3 bg-gray-200 hover:bg-gray-300 active:bg-gray-400 text-gray-800 font-semibold rounded-lg shadow-lg transition-transform duration-200 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-red-50 border-l-4 border-red-600 text-red-700 p-6 m-6 rounded-lg text-center shadow-md">
                <h4 class="text-xl font-semibold">Không tìm thấy sản phẩm!</h4>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>
