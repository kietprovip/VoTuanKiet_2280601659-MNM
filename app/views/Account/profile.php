<?php include_once 'app/views/shares/header.php'; ?>

<div class="min-h-screen bg-image relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="glass-effect rounded-xl shadow-xl p-6 mb-8 backdrop-blur-lg">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mr-6">
                        <i class="fas fa-user text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                            Thông tin cá nhân
                        </h1>
                        <p class="text-gray-600 text-sm">Quản lý thông tin tài khoản của bạn</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="glass-effect rounded-xl shadow-xl p-6 backdrop-blur-lg">
                        <nav class="space-y-2">
                            <a href="/VoTuanKiet/account/profile" class="flex items-center px-4 py-2.5 text-indigo-600 bg-indigo-50 rounded-lg transition-all duration-200 hover:bg-indigo-100">
                                <i class="fas fa-user mr-3"></i>
                                Thông tin cá nhân
                            </a>
                            <a href="/VoTuanKiet/account/settings" class="flex items-center px-4 py-2.5 text-gray-700 hover:bg-gray-50 rounded-lg transition-all duration-200">
                                <i class="fas fa-cog mr-3"></i>
                                Cài đặt
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="glass-effect rounded-xl shadow-xl p-8 backdrop-blur-lg">
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

                        <form action="/VoTuanKiet/account/profile" method="POST" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="username" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Tên đăng nhập
                                    </label>
                                    <input type="text" id="username" value="<?php echo htmlspecialchars($user->username ?? ''); ?>" disabled
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed text-sm">
                                    <p class="text-xs text-gray-500 mt-1">Tên đăng nhập không thể thay đổi</p>
                                </div>

                                <div>
                                    <label for="fullname" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Họ và tên *
                                    </label>
                                    <input type="text" id="fullname" name="fullname" required
                                        value="<?php echo htmlspecialchars($user->fullname ?? ''); ?>"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 bg-white/70 text-gray-900 placeholder-gray-500 text-sm">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                                        Email *
                                    </label>
                                    <input type="email" id="email" name="email" required
                                        value="<?php echo htmlspecialchars($user->email ?? ''); ?>"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-300 bg-white/70 text-gray-900 placeholder-gray-500 text-sm">
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="window.history.back()" 
                                    class="px-5 py-2.5 border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-100 transition-all duration-300 shadow-sm hover:shadow-md">
                                    Hủy
                                </button>
                                <button type="submit" 
                                    class="px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 focus:ring-2 focus:ring-indigo-500">
                                    Cập nhật thông tin
                                </button>
                            </div>
                        </form>
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
    // Add focus effects
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input:not([disabled])');
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