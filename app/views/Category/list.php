<?php include 'app/views/shares/header.php'; ?>

<div class="min-h-screen bg-image relative">
    <div class="container mx-auto px-6 sm:px-8 lg:px-10 py-12">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-10">
                <h1 class="text-3xl font-extrabold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                    📂 Quản Lý Danh Mục
                </h1>
                <a href="/VoTuanKiet/Category/add"
                   class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 focus:ring-2 focus:ring-indigo-500">
                    <i class="fas fa-plus-circle mr-2"></i> Thêm Danh Mục Mới
                </a>
            </div>

            <!-- Messages -->
            <?php if (isset($_SESSION['message'])): ?>
                <?php
                    $message_type = $_SESSION['message']['type'];
                    $message_text = $_SESSION['message']['text'];
                    $color_class = $message_type === 'success' ? 'bg-green-50 border-green-600 text-green-700' : 'bg-red-50 border-red-600 text-red-700';
                ?>
                <div class="glass-effect <?= $color_class ?> border-l-4 p-4 mb-8 rounded-lg shadow-md flex items-center" role="alert">
                    <i class="fas <?= $message_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle' ?> text-base mr-3"></i>
                    <div>
                        <p class="font-semibold text-sm">Thông báo</p>
                        <p class="text-sm"><?= htmlspecialchars($message_text, ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>

            <!-- Category Table or Empty State -->
            <?php if (empty($categories)): ?>
                <div class="glass-effect bg-indigo-50 border-l-4 border-indigo-600 text-indigo-700 p-8 rounded-lg shadow-md text-center">
                    <i class="fas fa-info-circle text-4xl text-indigo-600 mb-4"></i>
                    <p class="text-xl font-semibold">Chưa có danh mục nào.</p>
                    <p class="mt-2 text-gray-600 text-sm">Hãy thêm danh mục đầu tiên của bạn ngay bây giờ!</p>
                </div>
            <?php else: ?>
                <div class="glass-effect bg-white/90 shadow-xl rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-indigo-100 text-indigo-700 uppercase text-xs font-bold tracking-wide">
                                <tr>
                                    <th class="py-4 px-6 text-left">ID</th>
                                    <th class="py-4 px-6 text-left">Tên Danh Mục</th>
                                    <th class="py-4 px-6 text-left">Mô Tả</th>
                                    <th class="py-4 px-6 text-center">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                <?php foreach ($categories as $category): ?>
                                    <tr class="border-t border-gray-200 hover:bg-indigo-50/50 transition-all duration-200">
                                        <td class="py-4 px-6 font-semibold"><?= htmlspecialchars($category->id, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="py-4 px-6 text-indigo-600 font-medium"><?= htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="py-4 px-6 max-w-xs break-words text-gray-600 text-sm">
                                            <?= htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8'); ?>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="/VoTuanKiet/Category/edit/<?= $category->id; ?>"
                                                   class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center hover:bg-indigo-200 transition-all duration-200 hover:scale-105"
                                                   title="Sửa">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </a>
                                                <a href="/VoTuanKiet/Category/delete/<?= $category->id; ?>"
                                                   class="w-9 h-9 rounded-full bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-200 transition-all duration-200 hover:scale-105"
                                                   onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');"
                                                   title="Xóa">
                                                    <i class="fas fa-trash-alt text-sm"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .glass-effect {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .bg-image {
        background-image: url('/VoTuanKiet/public/img.png');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    
    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .text-3xl {
            font-size: 1.75rem;
        }
        .overflow-x-auto {
            margin-left: -1rem;
            margin-right: -1rem;
        }
        table {
            font-size: 0.75rem;
        }
        th, td {
            padding: 0.75rem 1rem;
        }
    }
</style>

<script>
    // Add hover effects for table rows
    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.classList.add('shadow-sm');
            });
            row.addEventListener('mouseleave', () => {
                row.classList.remove('shadow-sm');
            });
        });
    });
</script>

<?php include 'app/views/shares/footer.php'; ?>