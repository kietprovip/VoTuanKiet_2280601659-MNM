<?php include 'app/views/shares/header.php'; ?>

<div class="max-w-lg mx-auto bg-gradient-to-br from-white to-gray-50 p-8 rounded-xl shadow-2xl border border-gray-100">
    <h1 class="text-3xl font-bold text-primary-700 mb-8 text-center">Thông tin Thanh toán</h1>

    <form method="POST" action="/VoTuanKiet/Product/processCheckout">
        <div class="mb-6">
            <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">Họ tên người nhận:</label>
            <input type="text" id="name" name="name" class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300 hover:border-gray-400" required placeholder="Nhập họ tên (ví dụ: Nguyễn Văn A)">
        </div>

        <div class="mb-6">
            <label for="phone" class="block text-gray-700 text-sm font-semibold mb-2">Số điện thoại:</label>
            <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300 hover:border-gray-400" required placeholder="Nhập số điện thoại (ví dụ: 0901234567)">
        </div>

        <div class="mb-8">
            <label for="address" class="block text-gray-700 text-sm font-semibold mb-2">Địa chỉ nhận hàng:</label>
            <textarea id="address" name="address" class="w-full px-4 py-3 rounded-lg border border-gray-300 bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300 hover:border-gray-400" rows="4" required placeholder="Nhập địa chỉ (ví dụ: 123 Đường ABC, Phường XYZ, Quận 1, TP. HCM)"></textarea>
        </div>
        
        <?php 
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        if (!empty($cart)) {
            $total_price = 0;
            echo '<div class="mb-6 p-5 bg-gray-50 rounded-xl border border-gray-200 shadow-md">';
            echo '<h3 class="text-lg font-semibold text-primary-700 mb-3">Đơn hàng của bạn:</h3>';
            echo '<ul class="list-disc list-inside text-sm text-gray-600 space-y-1">';
            foreach ($cart as $item) {
                $total_price += $item['price'] * $item['quantity'];
                echo '<li>' . htmlspecialchars($item['name']) . ' x ' . $item['quantity'] . '</li>';
            }
            echo '</ul>';
            echo '<p class="mt-4 font-bold text-lg text-green-600">Tổng cộng: ' . number_format($total_price, 0, ',', '.') . ' VND</p>';
            echo '</div>';
        }
        ?>

        <div class="flex flex-col sm:flex-row items-center justify-between mt-8 space-y-4 sm:space-y-0 sm:space-x-6">
            <a href="/VoTuanKiet/Product/cart" class="inline-flex items-center text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors duration-300">
                <i class="fas fa-arrow-left mr-1"></i> Quay lại giỏ hàng
            </a>
            <button type="submit" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                <i class="fas fa-check-circle mr-2"></i> Hoàn tất Đặt hàng
            </button>
        </div>
    </form>
</div>

<?php include 'app/views/shares/footer.php'; ?>