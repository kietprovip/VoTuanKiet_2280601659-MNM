<?php include_once 'app/views/shares/header.php'; ?>

<div class="min-h-screen bg-image relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="glass-effect rounded-xl shadow-xl p-6 mb-8 backdrop-blur-lg">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mr-6">
                        <i class="fas fa-cog text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                            Cài đặt tài khoản
                        </h1>
                        <p class="text-gray-600 text-sm">Quản lý bảo mật và cài đặt tài khoản</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="glass-effect rounded-xl shadow-xl p-6 backdrop-blur-lg">
                        <nav class="space-y-2">
                            <a href="/VoTuanKiet/account/profile" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-gray-50 rounded-lg transition-all duration-200">
                                <i class="fas fa-user mr-3"></i>
                                Thông tin cá nhân
                            </a>
                            <a href="/VoTuanKiet/account/settings" class="flex items-center px-4 py-2.5 text-indigo-600 bg-indigo-50 rounded-lg transition-all duration-200 hover:bg-indigo-100">
                                <i class="fas fa-cog mr-3"></i>
                                Cài đặt
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Change Password Section -->
                    <div class="glass-effect rounded-xl shadow-xl p-8 mb-6 backdrop-blur-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Đổi mật khẩu</h2>
                        
                        <?php if (isset($error)): ?>
                            <div class="bg-red-50 border-l-4 border-red-600 p-4 mb-6 rounded-lg flex items-center">
                                <i class="fas fa-exclamation-circle text-red-600 text-base mr-3"></i>
                                <p class="text-sm text-red-700"><?php echo htmlspecialchars($error); ?></p>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($success)): ?>
                            <div class="bg-green-50 border-l-4 border-green-600 p-4 mb-6 rounded-lg flex items-center">
                                <i class="fas fa-check-circle text-green-600 text-base mr-3"></i>
                                <p class="text-sm text-green-700"><?php echo htmlspecialchars($success); ?></p>
                            </div>
                        <?php endif; ?>

                        <form action="/VoTuanKiet/account/settings" method="POST" class="space-y-6">
                            <div>
                                <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Mật khẩu hiện tại
                                </label>
                                <div class="relative">
                                    <input type="password" id="current_password" name="current_password"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 bg-white/70 text-gray-900 pr-10 text-sm">
                                    <button type="button" onclick="togglePassword('current_password', 'toggleIcon1')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-eye text-gray-400 hover:text-indigo-600 text-sm" id="toggleIcon1"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Mật khẩu mới
                                </label>
                                <div class="relative">
                                    <input type="password" id="new_password" name="new_password"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 bg-white/70 text-gray-900 pr-10 text-sm">
                                    <button type="button" onclick="togglePassword('new_password', 'toggleIcon2')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-eye text-gray-400 hover:text-indigo-600 text-sm" id="toggleIcon2"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Mật khẩu phải có ít nhất 6 ký tự</p>
                            </div>

                            <div>
                                <label for="confirm_password" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Xác nhận mật khẩu mới
                                </label>
                                <div class="relative">
                                    <input type="password" id="confirm_password" name="confirm_password"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 bg-white/70 text-gray-900 pr-10 text-sm">
                                    <button type="button" onclick="togglePassword('confirm_password', 'toggleIcon3')" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="fas fa-eye text-gray-400 hover:text-indigo-600 text-sm" id="toggleIcon3"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="resetForm()" 
                                    class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-300 shadow-sm hover:shadow-md">
                                    Hủy
                                </button>
                                <button type="submit" 
                                    class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 focus:ring-2 focus:ring-indigo-500">
                                    Đổi mật khẩu
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Account Information -->
                    <div class="glass-effect rounded-xl shadow-xl p-8 backdrop-blur-lg">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Thông tin tài khoản</h2>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                <div>
                                    <p class="font-medium text-gray-800">Tên đăng nhập</p>
                                    <p class="text-sm text-gray-600"><?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between py-3 border-b border-gray-200">
                                <div>
                                    <p class="font-medium text-gray-800">Vai trò</p>
                                    <p class="text-sm text-gray-600">
                                        <?php echo SessionHelper::isAdmin() ? 'Quản trị viên' : 'Người dùng'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
    
    input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .text-2xl {
            font-size: 1.5rem;
        }
    }
</style>

<script>
function togglePassword(fieldId, iconId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

function resetForm() {
    document.querySelector('form').reset();
    const confirmPassword = document.getElementById('confirm_password');
    confirmPassword.setCustomValidity('');
    confirmPassword.style.borderColor = '#d1d5db';
}

// Password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = this.value;
    
    if (newPassword !== confirmPassword) {
        this.setCustomValidity('Mật khẩu không khớp');
        this.style.borderColor = '#ef4444';
    } else {
        this.setCustomValidity('');
        this.style.borderColor = '#d1d5db';
    }
});

// Add focus effects
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('scale-105', 'shadow-md');
        });
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('scale-105', 'shadow-md');
        });
    });
});
</script>

<?php include_once 'app/views/shares/footer.php'; ?>