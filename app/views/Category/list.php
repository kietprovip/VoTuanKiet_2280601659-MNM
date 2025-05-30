<?php include 'app/views/shares/header.php'; ?>

<div class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-900">📂 Quản Lý Danh Mục</h1>
        <a href="/VoTuanKiet/Category/add"
           class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition transform hover:-translate-y-1 flex items-center">
            <i class="fas fa-plus-circle mr-2"></i> Thêm Danh Mục Mới
        </a>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
        <?php
            $message_type = $_SESSION['message']['type'];
            $message_text = $_SESSION['message']['text'];
            $color_class = $message_type === 'success'
                ? 'bg-green-100 border-green-500 text-green-700'
                : 'bg-red-100 border-red-500 text-red-700';
        ?>
        <div class="<?= $color_class ?> border-l-4 p-4 mb-8 rounded-md shadow-md" role="alert">
            <p class="font-bold">Thông báo</p>
            <p><?= htmlspecialchars($message_text, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (empty($categories)): ?>
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-8 rounded-md shadow text-center">
            <i class="fas fa-info-circle text-4xl text-blue-500 mb-4"></i>
            <p class="text-xl font-semibold">Chưa có danh mục nào.</p>
            <p class="mt-2 text-gray-600">Hãy thêm danh mục đầu tiên của bạn ngay bây giờ!</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto bg-white shadow-xl rounded-2xl">
            <table class="min-w-full text-sm">
                <thead class="bg-purple-100 text-purple-700 uppercase text-xs font-bold tracking-wide">
                    <tr>
                        <th class="py-4 px-6 text-left">ID</th>
                        <th class="py-4 px-6 text-left">Tên Danh Mục</th>
                        <th class="py-4 px-6 text-left">Mô Tả</th>
                        <th class="py-4 px-6 text-center">Sửa/Xóa</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php foreach ($categories as $category): ?>
                        <tr class="border-t border-gray-200 hover:bg-gray-50 transition duration-200">
                            <td class="py-4 px-6 font-semibold"><?= htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-4 px-6 text-purple-700 font-medium"><?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td class="py-4 px-6 max-w-xs break-words text-gray-600">
                                <?= htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="/VoTuanKiet/Category/edit/<?= $category->id; ?>"
                                       class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition"
                                       title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="/VoTuanKiet/Category/delete/<?= $category->id; ?>"
                                       class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-200 transition"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');"
                                       title="Xoá">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php include 'app/views/shares/footer.php'; ?>
