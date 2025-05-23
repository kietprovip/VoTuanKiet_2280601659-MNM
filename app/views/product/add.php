<?php include 'app/views/shares/header.php'; ?>

<div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-lg mt-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">🛒 Thêm sản phẩm mới</h1>

    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg">
            <strong class="font-semibold">Lỗi:</strong>
            <ul class="list-disc list-inside mt-2">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/VoTuanKiet/Product/save" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên sản phẩm</label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Giá sản phẩm (VND)</label>
                <input type="number" id="price" name="price" step="0.01" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            <div class="sm:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả sản phẩm</label>
                <textarea id="description" name="description" rows="4" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:outline-none resize-none"></textarea>
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Danh mục</label>
                <select id="category_id" name="category_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200 focus:outline-none">
                    <option value="">-- Chọn danh mục --</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category->id); ?>">
                            <?php echo htmlspecialchars($category->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Hình ảnh sản phẩm</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-1">Chỉ chấp nhận PNG, JPG, GIF. Tối đa 2MB.</p>
                <div class="mt-3">
                    <img id="image-preview" class="hidden w-32 h-32 object-cover rounded-lg border" />
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-center gap-4">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 shadow-md">
                ✅ Thêm sản phẩm
            </button>
            <a href="/VoTuanKiet/Product/list"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg transition duration-200 shadow-md">
                ⬅️ Quay lại danh sách
            </a>
        </div>
    </form>
</div>

<script>
document.getElementById('image').addEventListener('change', function (e) {
    const preview = document.getElementById('image-preview');
    const file = e.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('hidden');
    }
});

function validateForm() {
    const name = document.getElementById('name').value.trim();
    const description = document.getElementById('description').value.trim();
    const price = parseFloat(document.getElementById('price').value);
    const category = document.getElementById('category_id').value;

    if (!name || !description || isNaN(price) || price < 0 || !category) {
        alert("Vui lòng điền đầy đủ thông tin và kiểm tra giá sản phẩm.");
        return false;
    }

    return true;
}
</script>

<?php include 'app/views/shares/footer.php'; ?>
