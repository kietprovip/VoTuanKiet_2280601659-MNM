<?php include 'app/views/shares/header.php'; ?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white/90 backdrop-blur-lg border border-white/10 rounded-xl shadow-xl hover:shadow-2xl transition-all duration-300 glass-effect">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-6 px-8 text-center rounded-t-xl">
            <h2 class="text-3xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                Chi tiết sản phẩm
            </h2>
        </div>
        
        <?php if (isset($product) && is_object($product)): ?>
            <div class="md:flex">
                <div class="md:w-1/2 p-8 flex items-center justify-center">
                    <?php if (isset($product->image) && $product->image): ?>
                        <img src="/VoTuanKiet/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                             alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>"
                             class="rounded-lg object-cover max-h-80 w-full transition-transform duration-300 ease-in-out hover:scale-105 shadow-md"
                             loading="lazy">
                    <?php else: ?>
                        <div class="w-full aspect-[4/3] bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="md:w-1/2 p-8 flex flex-col justify-between">
                    <h3 class="text-2xl font-extrabold text-gray-900 mb-4 transition-colors duration-300 hover:text-indigo-600 cursor-default">
                        <?php echo htmlspecialchars($product->name ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </h3>
                    
                    <div class="prose prose-sm max-w-none text-gray-600 mb-6 whitespace-pre-line">
                        <?php echo nl2br(htmlspecialchars($product->description ?? '', ENT_QUOTES, 'UTF-8')); ?>
                    </div>
                    
                    <div class="mb-6">
                        <span class="text-3xl font-extrabold text-indigo-600 drop-shadow-md">
                            <?php echo number_format($product->price ?? 0, 0, ',', '.'); ?> VND
                        </span>
                    </div>
                    
                    <div class="mb-6">
                        <span class="text-sm font-semibold text-gray-700">Danh mục:</span>
                        <span class="ml-2 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 select-none">
                            <?php echo isset($product->category_name) && !empty($product->category_name) 
                                ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') 
                                : 'Chưa có danh mục'; 
                            ?>
                        </span>
                    </div>
                    
                    <div class="flex flex-wrap gap-3">
                        <a href="/VoTuanKiet/Product/addToCart/<?php echo $product->id ?? ''; ?>"
                           class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                                <circle cx="7" cy="21" r="1" />
                                <circle cx="17" cy="21" r="1" />
                            </svg>
                            Thêm vào giỏ hàng
                        </a>
                        
                        <a href="/VoTuanKiet/Product"
                           class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Quay lại danh sách
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-red-50 border-l-4 border-red-600 p-6 m-6 rounded-lg flex items-center justify-center shadow-md">
                <i class="fas fa-exclamation-circle text-red-600 text-xl mr-3"></i>
                <h4 class="text-lg font-semibold text-red-700">Không tìm thấy sản phẩm!</h4>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .glass-effect {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
    }
    
    img {
        image-rendering: -webkit-optimize-contrast;
        image-rendering: crisp-edges;
    }
    
    @media (max-width: 640px) {
        .md\:flex {
            flex-direction: column;
        }
        .md\:w-1\/2 {
            width: 100%;
        }
        .max-h-80 {
            max-height: 16rem;
        }
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>