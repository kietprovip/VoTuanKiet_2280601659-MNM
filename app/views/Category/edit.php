<?php include 'app/views/shares/header.php'; ?>

<div class="max-w-2xl mx-auto bg-white p-10 rounded-2xl shadow-2xl mt-12">
    <h1 class="text-4xl font-extrabold text-center text-purple-600 mb-10">Sửa Thông Tin Danh Mục</h1>

    <?php if (!empty($errors)): ?>
        <div class="bg-red-50 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-6 shadow-sm">
            <p class="font-semibold mb-2">Vui lòng sửa các lỗi sau:</p>
            <ul class="list-disc list-inside space-y-1">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/VoTuanKiet/Category/update" class="space-y-6">
        <input type="hidden" name="id" value="<?= htmlspecialchars($category->id ?? '', ENT_QUOTES, 'UTF-8'); ?>">

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Tên Danh Mục:</label>
            <input type="text" id="name" name="name" required
                   class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-800 focus:ring-2 focus:ring-purple-500 focus:outline-none shadow-sm transition"
                   value="<?= htmlspecialchars($category->name ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Mô Tả:</label>
            <textarea id="description" name="description" rows="4" required
                      class="w-full border border-gray-300 rounded-lg py-3 px-4 text-gray-800 focus:ring-2 focus:ring-purple-500 focus:outline-none shadow-sm transition"><?= htmlspecialchars($category->description ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="flex justify-between items-center pt-4">
            <a href="/VoTuanKiet/Category/"
               class="inline-flex items-center text-purple-600 hover:text-purple-800 font-semibold transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Quay lại
            </a>
            <button type="submit"
                    class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50">
                <i class="fas fa-save mr-2"></i> Lưu Thay Đổi
            </button>
        </div>
    </form>
</div>

<?php include 'app/views/shares/footer.php'; ?>
