<?php include_once 'app/views/shares/header.php'; ?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-user-edit text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Sửa thông tin người dùng</h1>
                    <p class="text-gray-600">Cập nhật thông tin tài khoản người dùng</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <?php if (isset($error)): ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700"><?php echo $error; ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form action="/VoTuanKiet/user/edit/<?php echo $user->id; ?>" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                            Tên đăng nhập
                        </label>
                        <input type="text" id="username" name="username" disabled
                            value="<?php echo htmlspecialchars($user->username ?? ''); ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed">
                        <p class="text-xs text-gray-500 mt-1">Tên đăng nhập không thể thay đổi</p>
                    </div>

                    <div>
                        <label for="fullname" class="block text-sm font-medium text-gray-700 mb-2">
                            Họ và tên *
                        </label>
                        <input type="text" id="fullname" name="fullname" required
                            value="<?php echo htmlspecialchars($user->fullname ?? ''); ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email *
                        </label>
                        <input type="email" id="email" name="email" required
                            value="<?php echo htmlspecialchars($user->email ?? ''); ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Vai trò *
                    </label>
                    <select id="role" name="role" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="user" <?php echo ($user->role === 'user') ? 'selected' : ''; ?>>Người dùng</option>
                        <option value="admin" <?php echo ($user->role === 'admin') ? 'selected' : ''; ?>>Quản trị viên</option>
                    </select>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Mật khẩu mới (để trống nếu không đổi)
                    </label>
                    <input type="password" id="password" name="password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <p class="text-xs text-gray-500 mt-1">Chỉ nhập nếu muốn thay đổi mật khẩu</p>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="/VoTuanKiet/user"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Hủy
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg hover:from-purple-700 hover:to-indigo-700 transition-colors">
                        Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once 'app/views/shares/footer.php'; ?>