<?php include_once 'app/views/shares/header.php'; ?>

<div class="min-h-screen bg-image relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="glass-effect rounded-xl shadow-xl p-6 mb-8 backdrop-blur-lg">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div>
                        <h1 class="text-2xl font-extrabold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                            Quản lý Người dùng
                        </h1>
                        <p class="text-gray-600 text-sm mt-1">Quản lý tài khoản người dùng trong hệ thống</p>
                    </div>
                    <a href="/VoTuanKiet/user/create" 
                       class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 focus:ring-2 focus:ring-indigo-500">
                        <i class="fas fa-plus mr-2"></i>
                        Thêm người dùng
                    </a>
                </div>
            </div>

            <!-- Messages -->
            <?php if (isset($_GET['success'])): ?>
                <div class="glass-effect bg-green-50 border-l-4 border-green-600 p-4 mb-8 rounded-lg shadow-md flex items-center">
                    <i class="fas fa-check-circle text-green-600 text-base mr-3"></i>
                    <p class="text-sm font-semibold text-green-700"><?php echo htmlspecialchars($_GET['success']); ?></p>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="glass-effect bg-red-50 border-l-4 border-red-600 p-4 mb-8 rounded-lg shadow-md flex items-center">
                    <i class="fas fa-exclamation-circle text-red-600 text-base mr-3"></i>
                    <p class="text-sm font-semibold text-red-700"><?php echo htmlspecialchars($_GET['error']); ?></p>
                </div>
            <?php endif; ?>

            <!-- Users Table -->
            <div class="glass-effect bg-white/90 rounded-xl shadow-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-indigo-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                                    Người dùng
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                                    Vai trò
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase tracking-wider">
                                    Thao tác
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white/90 divide-y divide-gray-200">
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr class="hover:bg-indigo-50/50 transition-all duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mr-3 shadow-sm">
                                                    <i class="fas fa-user text-white text-sm"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-semibold text-gray-900">
                                                        <?php echo htmlspecialchars($user->fullname); ?>
                                                    </div>
                                                    <div class="text-sm text-gray-600">
                                                        @<?php echo htmlspecialchars($user->username); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($user->email); ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php if ($user->role === 'admin'): ?>
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 shadow-sm">
                                                    <i class="fas fa-crown mr-1"></i>
                                                    Quản trị viên
                                                </span>
                                            <?php else: ?>
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 shadow-sm">
                                                    <i class="fas fa-user mr-1"></i>
                                                    Người dùng
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="/VoTuanKiet/user/edit/<?php echo $user->id; ?>" 
                                                   class="inline-flex items-center px-3 py-1.5 text-indigo-600 bg-indigo-100 hover:bg-indigo-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105 focus:ring-2 focus:ring-indigo-500">
                                                    <i class="fas fa-edit mr-1"></i>
                                                    Sửa
                                                </a>
                                                <?php if ($user->username !== $_SESSION['username']): ?>
                                                    <button onclick="confirmDelete(<?php echo $user->id; ?>, '<?php echo htmlspecialchars($user->username); ?>')" 
                                                            class="inline-flex items-center px-3 py-1.5 text-red-600 bg-red-100 hover:bg-red-200 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105 focus:ring-2 focus:ring-red-500">
                                                        <i class="fas fa-trash mr-1"></i>
                                                        Xóa
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-600">
                                        <i class="fas fa-users text-4xl mb-3 text-indigo-600 animate-pulse"></i>
                                        <p class="text-base font-semibold">Không có người dùng nào trong hệ thống</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full hidden z-50 transition-opacity duration-300">
    <div class="relative top-20 mx-auto p-6 w-full max-w-md glass-effect rounded-xl shadow-2xl">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mt-3">Xác nhận xóa</h3>
            <div class="mt-2 px-4 py-3">
                <p class="text-sm text-gray-600">
                    Bạn có chắc chắn muốn xóa người dùng <span id="deleteUsername" class="font-semibold text-gray-900"></span>?
                    <br>Hành động này không thể hoàn tác.
                </p>
            </div>
            <div class="flex justify-center gap-3 px-4 py-3">
                <button id="confirmDeleteBtn" onclick="deleteUser()" 
                        class="px-5 py-2 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition-all duration-300 transform hover:-translate-y-1 focus:ring-2 focus:ring-red-500">
                    Xóa
                </button>
                <button onclick="closeDeleteModal()" 
                        class="px-5 py-2 bg-gray-100 text-gray-800 font-semibold rounded-lg shadow-md hover:bg-gray-200 transition-all duration-300 transform hover:-translate-y-1 focus:ring-2 focus:ring-gray-300">
                    Hủy
                </button>
            </div>
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
        .text-2xl {
            font-size: 1.5rem;
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
let deleteUserId = null;

function confirmDelete(userId, username) {
    deleteUserId = userId;
    document.getElementById('deleteUsername').textContent = username;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('opacity-100');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('opacity-100');
    deleteUserId = null;
}

function deleteUser() {
    if (deleteUserId) {
        window.location.href = `/VoTuanKiet/user/delete/${deleteUserId}`;
    }
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

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

<?php include_once 'app/views/shares/footer.php'; ?>