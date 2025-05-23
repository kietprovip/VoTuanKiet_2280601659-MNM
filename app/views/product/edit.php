<?php include 'app/views/shares/header.php'; ?>

<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-lg mt-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">🛠️ Sửa thông tin sản phẩm</h1>

    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 border-l-4 border-red-600 text-red-800 p-4 rounded mb-6 shadow">
            <ul class="list-disc list-inside space-y-1 text-sm">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/VoTuanKiet/Product/update" enctype="multipart/form-data" onsubmit="return validateForm();" class="space-y-6">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($product->id ?? '', ENT_QUOTES, 'UTF-8'); ?>">

        <!-- Tên sản phẩm -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Tên sản phẩm</label>
            <input type="text" id="name" name="name"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                   value="<?php echo htmlspecialchars($product->name ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <!-- Mô tả -->
        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Mô tả sản phẩm</label>
            <textarea id="description" name="description" rows="4"
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                      required><?php echo htmlspecialchars($product->description ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <!-- Giá -->
        <div>
            <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Giá sản phẩm</label>
            <div class="relative rounded-lg shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="text-gray-500">₫</span>
                </div>
                <input type="number" id="price" name="price" step="0.01"
                       class="w-full pl-8 pr-12 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                       value="<?php echo htmlspecialchars($product->price ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <span class="text-gray-500 text-sm">VND</span>
                </div>
            </div>
        </div>

        <!-- Danh mục -->
        <div>
            <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Danh mục sản phẩm</label>
            <select id="category_id" name="category_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    required>
                <?php if (isset($categories) && is_array($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <?php if (is_object($category)): ?>
                            <option value="<?php echo htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?>"
                                <?php echo ($category->id == $product->category_id) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- Hình ảnh -->
        <div>
            <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">Cập nhật hình ảnh</label>
            <input type="file" id="image" name="image"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($product->image ?? '', ENT_QUOTES, 'UTF-8'); ?>">

            <?php if (!empty($product->image)): ?>
                <div class="mt-3 flex items-center space-x-4">
                    <img src="/VoTuanKiet/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                         alt="Ảnh sản phẩm"
                         class="h-24 w-24 rounded-lg object-cover border border-gray-300 shadow-sm">
                    <span class="text-sm text-gray-500">Ảnh hiện tại</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Buttons -->
        <div class="flex justify-between items-center pt-4">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition shadow">
                💾 Lưu thay đổi
            </button>
            <a href="/VoTuanKiet/Product/list"
               class="text-gray-600 bg-gray-100 hover:bg-gray-200 py-2 px-4 rounded-lg transition shadow border">
                ← Quay lại danh sách
            </a>
        </div>
    </form>
</div>

<script>
function validateForm() {
    const name = document.getElementById('name').value.trim();
    const description = document.getElementById('description').value.trim();
    const price = document.getElementById('price').value.trim();

    if (!name) {
        alert('Vui lòng nhập tên sản phẩm');
        return false;
    }

    if (!description) {
        alert('Vui lòng nhập mô tả sản phẩm');
        return false;
    }

    if (!price || isNaN(price) || parseFloat(price) < 0) {
        alert('Vui lòng nhập giá hợp lệ');
        return false;
    }

    return true;
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
