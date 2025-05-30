<?php include 'app/views/shares/header.php'; ?>

<style>
    /* Custom keyframes for fade-in and slide-up animation */
    @keyframes fadeInSlideUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInScale {
        0% {
            opacity: 0;
            transform: scale(0.95);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* Apply animation to product cards with staggered delay */
    .product-card {
        animation: fadeInSlideUp 0.6s ease-out forwards;
    }
    .product-card:nth-child(1) { animation-delay: 0.1s; }
    .product-card:nth-child(2) { animation-delay: 0.2s; }
    .product-card:nth-child(3) { animation-delay: 0.3s; }
    .product-card:nth-child(4) { animation-delay: 0.4s; }
    .product-card:nth-child(5) { animation-delay: 0.5s; }
    /* Continue for more items if needed, or use JavaScript for dynamic delays */

    /* Apply animation to empty state */
    .empty-state {
        animation: fadeInScale 0.5s ease-out forwards;
    }


    .btn-bounce:hover {
        animation: bounce 0.3s ease-in-out;
    }

    @keyframes bounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
</style>

<div class="mb-8 flex justify-center">
    <div class="flex flex-col sm:flex-row justify-center items-center space-y-4 sm:space-y-0 sm:space-x-6">
        <h1 class="text-3xl font-bold text-gray-900 transition-all duration-500 hover:text-primary-700">Danh sách sản phẩm</h1>
    </div>
</div>

<?php if (empty($products)): ?>
    <div class="bg-primary-50 border-l-4 border-primary-500 text-primary-700 p-6 rounded-lg shadow-md empty-state" role="alert">
        <p class="font-bold text-lg">Không có sản phẩm</p>
        <p class="mt-2">Hiện tại chưa có sản phẩm nào trong cửa hàng. <a href="/VoTuanKiet/Product/add" class="underline hover:text-primary-600 transition-colors duration-300">Thêm sản phẩm mới</a> ngay!</p>
    </div>
<?php else: ?>
    <div class="flex justify-center">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-6 max-w-full">
            <?php foreach ($products as $product): ?>
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-500 product-card">
                    <a href="/VoTuanKiet/Product/show/<?php echo $product->id; ?>">
                        <?php if ($product->image): ?>
                            <img src="/VoTuanKiet/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" class="w-full h-48 object-cover transition-transform duration-500 hover:scale-105">
                        <?php else: ?>
                            <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400 transition-opacity duration-300 hover:opacity-80">
                                <i class="fas fa-image fa-2x"></i>
                            </div>
                        <?php endif; ?>
                    </a>
                    <div class="p-5">
                        <h2 class="text-xl font-semibold text-primary-700 mb-2">
                            <a href="/VoTuanKiet/Product/show/<?php echo $product->id; ?>" class="hover:text-primary-500 transition-colors duration-300"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></a>
                        </h2>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2 transition-opacity duration-300 hover:opacity-90"><?php echo htmlspecialchars(strip_tags($product->description), ENT_QUOTES, 'UTF-8'); ?></p>
                        <p class="text-xl font-bold text-green-600 mb-3 transition-transform duration-300 hover:scale-105">
                            <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                        </p>
                        <p class="text-gray-500 text-sm mb-4">Danh mục: 
                            <span class="font-medium text-primary-600 transition-colors duration-300 hover:text-primary-500"><?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?></span>
                        </p>
                        <div class="flex justify-center space-x-2">
                            <a href="/VoTuanKiet/Product/addToCart/<?php echo $product->id; ?>" 
                               class="inline-flex items-center px-3 py-1.5 bg-primary-500 hover:bg-primary-600 text-white text-sm font-medium rounded-md shadow-sm hover:shadow-md transition-all duration-300 btn-bounce">
                                <i class="fas fa-cart-plus mr-1"></i>
                                <span class="hidden sm:inline">Thêm vào giỏ</span>
                                <span class="sm:hidden">Giỏ</span>
                            </a>
                            <a href="/VoTuanKiet/Product/edit/<?php echo $product->id; ?>" 
                               class="inline-flex items-center px-3 py-1.5 bg-yellow-400 hover:bg-yellow-500 text-gray-800 text-sm font-medium rounded-md shadow-sm hover:shadow-md transition-all duration-300 btn-bounce">
                                <i class="fas fa-edit mr-1"></i>
                                <span class="hidden sm:inline">Sửa</span>
                            </a>
                            <a href="/VoTuanKiet/Product/delete/<?php echo $product->id; ?>" 
                               onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');" 
                               class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md shadow-sm hover:shadow-md transition-all duration-300 btn-bounce">
                                <i class="fas fa-trash-alt mr-1"></i>
                                <span class="hidden sm:inline">Xóa</span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?php include 'app/views/shares/footer.php'; ?>