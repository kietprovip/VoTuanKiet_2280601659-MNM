<?php include 'app/views/shares/header.php'; ?>

<div class="max-w-2xl mx-auto bg-white p-10 rounded-2xl shadow-2xl mt-12">
    <h1 class="text-4xl font-extrabold text-purple-700 mb-10 text-center">➕ Thêm Danh Mục Mới</h1>

    <?php if (!empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-8 shadow-md">
            <div class="flex items-start space-x-3">
                <svg class="w-6 h-6 text-red-500 flex-shrink-0 mt-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.054 0 1.636-1.14 1.057-2.038L13.057 4.962c-.527-.793-1.586-.793-2.113 0L3.025 16.962c-.58.898.003 2.038 1.057 2.038z" />
                </svg>
                <div>
                    <p class="font-semibold mb-1">Vui lòng sửa các lỗi sau:</p>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <form method="POST" action="/VoTuanKiet/Category/save" class="space-y-6">
        <div>
            <label for="name" class="block text-gray-800 font-semibold mb-2">Tên Danh Mục:</label>
            <input type="text" id="name" name="name"
                   class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                   value="<?php echo htmlspecialchars($old_input['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div>
            <label for="description" class="block text-gray-800 font-semibold mb-2">Mô Tả:</label>
            <textarea id="description" name="description" rows="4"
                      class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                      required><?php echo htmlspecialchars($old_input['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <div class="flex items-center justify-between mt-8">
            <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-purple-500">
                <i class="fas fa-save mr-2"></i> Thêm Danh Mục
            </button>
            <a href="/VoTuanKiet/Category/"
               class="text-sm font-semibold text-blue-500 hover:text-blue-700 transition-colors">
                <i class="fas fa-arrow-left mr-1"></i> Quay lại Danh sách
            </a>
        </div>
    </form>
</div>

<?php include 'app/views/shares/footer.php'; ?>
