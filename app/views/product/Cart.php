<?php include 'app/views/shares/header.php'; ?>

<div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold text-primary-700 mb-10 text-center">Giỏ hàng của bạn</h1>

    <div id="cart-container">
        <?php if (!empty($cart)): ?>
            <div class="bg-white rounded-2xl shadow-lg p-4 sm:p-6 border border-gray-100">
                <ul class="divide-y divide-gray-200" id="cart-item-list">
                    <?php 
                    foreach ($cart as $id => $item): 
                        $item_total = $item['price'] * $item['quantity'];
                    ?>
                        <li class="py-5 flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-6" id="cart-item-<?php echo $id; ?>">
                            <?php if ($item['image']): ?>
                                <img src="/VoTuanKiet/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>" class="w-24 h-24 sm:w-28 sm:h-28 object-cover rounded-lg shadow-sm self-center sm:self-auto">
                            <?php else: ?>
                                <div class="w-24 h-24 sm:w-28 sm:h-28 bg-gray-100 flex items-center justify-center text-gray-400 rounded-lg shadow-sm self-center sm:self-auto">
                                    <i class="fas fa-image fa-2x"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex-grow w-full">
                                <h2 class="text-lg font-semibold text-primary-700 hover:text-primary-600 transition-colors">
                                    <a href="/VoTuanKiet/Product/show/<?php echo $id; ?>"><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></a>
                                </h2>
                                <p class="text-sm text-gray-500 mt-1">Đơn giá: <span class="item-price"><?php echo number_format($item['price'], 0, ',', '.'); ?></span> VND</p>
                                
                                <div class="mt-3 flex items-center justify-between flex-col sm:flex-row space-y-3 sm:space-y-0">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-gray-700">Số lượng:</span>
                                        <div class="flex items-center border border-gray-300 rounded-md shadow-sm">
                                            <button type="button" data-id="<?php echo $id; ?>" 
                                                    class="quantity-decrease p-2 text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-l-md transition-all duration-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                            <span id="quantity-<?php echo $id; ?>" 
                                                  class="item-quantity px-4 py-1.5 text-center text-gray-700 border-l border-r border-gray-300 text-sm font-medium w-12">
                                                <?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                            <button type="button" data-id="<?php echo $id; ?>" 
                                                    class="quantity-increase p-2 text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500 rounded-r-md transition-all duration-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-lg font-bold text-green-600">
                                        <span id="item-total-<?php echo $id; ?>"><?php echo number_format($item_total, 0, ',', '.'); ?></span> VND
                                    </p>
                                </div>
                            </div>
                            <button type="button" data-id="<?php echo $id; ?>" 
                                    class="remove-item inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-md shadow-sm hover:shadow-md transition-all duration-300 self-end sm:self-center mt-2 sm:mt-0">
                                <i class="fas fa-trash-alt mr-1"></i>Xóa
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center text-xl font-semibold text-gray-800 bg-gray-50 p-4 rounded-lg">
                        <span>Tổng cộng:</span>
                        <span id="cart-total-price" class="text-green-600"><?php echo number_format($cartTotalPrice ?? 0, 0, ',', '.'); ?> VND</span>
                    </div>
                </div>
                <div class="mt-8 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="/VoTuanKiet/Product/" class="w-full sm:w-auto text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 ease-in-out">
                        <i class="fas fa-shopping-bag mr-2"></i>Tiếp tục mua sắm
                    </a>
                    <a href="/VoTuanKiet/Product/checkout" id="checkout-button" class="w-full sm:w-auto text-center bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1">
                        <i class="fas fa-credit-card mr-2"></i>Tiến hành Thanh Toán
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div id="empty-cart-message" class="bg-primary-50 border-l-4 border-primary-500 text-primary-700 p-6 rounded-lg shadow-md text-center">
                <i class="fas fa-shopping-cart fa-3x text-primary-500 mb-4"></i>
                <p class="text-xl font-semibold">Giỏ hàng của bạn đang trống.</p>
                <p class="mt-2 text-gray-600">Hãy thêm sản phẩm vào giỏ để tiếp tục mua sắm nhé!</p>
                <a href="/VoTuanKiet/Product/" class="mt-6 inline-block bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    Khám phá sản phẩm
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartContainer = document.getElementById('cart-container');

    cartContainer.addEventListener('click', function(event) {
        const targetButton = event.target.closest('button'); 
        if (!targetButton) return;

        const productId = targetButton.dataset.id;

        if (targetButton.classList.contains('quantity-increase')) {
            updateCartQuantity(`/VoTuanKiet/Product/increaseQuantity/${productId}`, productId);
        } else if (targetButton.classList.contains('quantity-decrease')) {
            updateCartQuantity(`/VoTuanKiet/Product/decreaseQuantity/${productId}`, productId);
        } else if (targetButton.classList.contains('remove-item')) {
            if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                updateCartQuantity(`/VoTuanKiet/Product/removeFromCart/${productId}`, productId, true);
            }
        }
    });

    function updateCartQuantity(url, productId, isRemoving = false) {
        fetch(url, {
            method: 'POST', 
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const quantityElement = document.getElementById(`quantity-${productId}`);
                const itemTotalElement = document.getElementById(`item-total-${productId}`);
                const cartTotalPriceElement = document.getElementById('cart-total-price');
                
                const navbarCartCountElement = document.getElementById('navbar-cart-count');

                if (data.itemRemoved) {
                    const itemElement = document.getElementById(`cart-item-${productId}`);
                    if (itemElement) {
                        itemElement.remove();
                    }
                } else if (quantityElement && itemTotalElement) {
                    quantityElement.textContent = data.newQuantity;
                    itemTotalElement.textContent = formatCurrency(data.itemTotalPrice);
                }

                if (cartTotalPriceElement) {
                    cartTotalPriceElement.textContent = formatCurrency(data.cartTotalPrice) + ' VND';
                }
                
                if (navbarCartCountElement) {
                    if (data.cartItemCount > 0) {
                        navbarCartCountElement.textContent = data.cartItemCount;
                        navbarCartCountElement.classList.remove('hidden');
                    } else {
                        navbarCartCountElement.textContent = '0'; 
                        navbarCartCountElement.classList.add('hidden');
                    }
                }

                if (data.cartItemCount === 0 || (document.getElementById('cart-item-list') && document.getElementById('cart-item-list').children.length === 0)) {
                    showEmptyCartMessage();
                }
            } else {
                alert('Lỗi: ' + (data.message || 'Không thể cập nhật giỏ hàng.'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã xảy ra lỗi. Vui lòng thử lại.');
        });
    }
    
    function formatCurrency(number) {
        return new Intl.NumberFormat('vi-VN').format(number);
    }

    function showEmptyCartMessage() {
        const cartContentDiv = document.querySelector('#cart-container > .bg-white');

        if (cartContentDiv) {
            cartContentDiv.remove();
        }

        let emptyCartMessageEl = document.getElementById('empty-cart-message');
        if (emptyCartMessageEl) { 
            emptyCartMessageEl.classList.remove('hidden'); 
        } else { 
            const newEmptyCartHTML = `
                <div id="empty-cart-message" class="bg-primary-50 border-l-4 border-primary-500 text-primary-700 p-6 rounded-lg shadow-md text-center">
                    <i class="fas fa-shopping-cart fa-3x text-primary-500 mb-4"></i>
                    <p class="text-xl font-semibold">Giỏ hàng của bạn đang trống.</p>
                    <p class="mt-2 text-gray-600">Hãy thêm sản phẩm vào giỏ để tiếp tục mua sắm nhé!</p>
                    <a href="/VoTuanKiet/Product/" class="mt-6 inline-block bg-primary-500 hover:bg-primary-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                        Khám phá sản phẩm
                    </a>
                </div>`;
            document.getElementById('cart-container').insertAdjacentHTML('afterbegin', newEmptyCartHTML);
        }
    }
});
</script>

<?php include 'app/views/shares/footer.php'; ?>