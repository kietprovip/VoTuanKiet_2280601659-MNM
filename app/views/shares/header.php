<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        /* Custom styles for header */
        .nav-gradient {
            background: linear-gradient(90deg, #4F46E5 0%, #7C3AED 100%);
            transition: all 0.3s ease;
        }
        
        .nav-item {
            transition: all 0.3s ease;
        }
        
        .nav-item:hover {
            transform: translateY(-2px);
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        /* Mobile menu styles */
        @media (max-width: 1023px) {
            .mobile-menu {
                display: none;
                transition: all 0.3s ease;
            }
            .mobile-menu.active {
                display: block;
                animation: slideIn 0.3s ease-in-out;
            }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav class="nav-gradient p-4 shadow-xl">
        <div class="container mx-auto flex flex-wrap items-center justify-between">
            <a class="text-white text-2xl font-extrabold tracking-tight hover:text-yellow-200 transition-colors duration-300" href="/VoTuanKiet/Product">
                Quản lý sản phẩm
            </a>

            <!-- Mobile menu button -->
            <button class="lg:hidden text-white hover:text-yellow-200 focus:outline-none transform transition-transform duration-300 hover:scale-110" onclick="toggleMobileMenu()">
                <i class="fas fa-bars text-2xl"></i>
            </button>

            <div class="w-full lg:flex lg:items-center lg:w-auto mobile-menu" id="navbarNav">
                <ul class="lg:flex items-center justify-between text-base text-gray-100 pt-4 lg:pt-0">
                    <?php if (SessionHelper::isLoggedIn()): ?>
                        <li>
                            <a class="nav-item block px-4 py-2 lg:p-4 rounded-lg hover:text-white transition-colors" href="/VoTuanKiet/Product/">
                                <i class="fas fa-list mr-2"></i>Danh sách sản phẩm
                            </a>
                        </li>
                        <?php if (SessionHelper::isAdmin()): ?>
                        <li>
                            <a class="nav-item block px-4 py-2 lg:p-4 rounded-lg hover:text-white transition-colors" href="/VoTuanKiet/Category/">
                                <i class="fas fa-folder mr-2"></i>Quản lý Danh mục
                            </a>
                        </li>
                        <li>
                            <a class="nav-item block px-4 py-2 lg:p-4 rounded-lg hover:text-white transition-colors" href="/VoTuanKiet/User/">
                                <i class="fas fa-users mr-2"></i>Quản lý Người dùng
                            </a>
                        </li>
                        <?php endif; ?>
                        <li>
                            <a class="nav-item block px-4 py-2 lg:p-4 rounded-lg hover:text-white relative transition-colors" href="/VoTuanKiet/Product/cart">
                                <i class="fas fa-shopping-cart mr-2"></i>Giỏ hàng
                                <?php
                                $cart_item_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                                if ($cart_item_count > 0): ?>
                                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-500 rounded-full transform translate-x-1/2 -translate-y-1/2"><?php echo $cart_item_count; ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li class="relative dropdown">
                            <button class="nav-item block px-4 py-2 lg:p-4 rounded-lg hover:text-white transition-colors cursor-pointer flex items-center focus:outline-none" onclick="toggleDropdown(event)">
                                <i class="fas fa-user-circle mr-2"></i>
                                <span class="font-medium"><?php echo $_SESSION['username']; ?></span>
                                <i class="fas fa-chevron-down ml-2 transform transition-transform duration-300" id="dropdownIcon"></i>
                            </button>
                            <div class="dropdown-menu absolute right-0 mt-2 w-56 rounded-xl shadow-2xl border border-gray-100 z-50" id="dropdownMenu">
                                <div class="py-2">
                                    <a href="/VoTuanKiet/account/profile" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                        <i class="fas fa-user mr-3 text-indigo-500"></i>Thông tin cá nhân
                                    </a>
                                    <a href="/VoTuanKiet/account/settings" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                        <i class="fas fa-cog mr-3 text-indigo-500"></i>Cài đặt
                                    </a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <a href="/VoTuanKiet/account/logout" class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-3 text-red-500"></i>Đăng xuất
                                    </a>
                                </div>
                            </div>
                        </li>
                    <?php else: ?>
                        <li>
                            <a class="nav-item block px-4 py-2 lg:p-4 rounded-lg hover:text-white transition-colors" href="/VoTuanKiet/account/login">
                                <i class="fas fa-sign-in-alt mr-2"></i>Đăng nhập
                            </a>
                        </li>
                        <li>
                            <a class="nav-item block px-4 py-2 lg:p-4 rounded-lg hover:text-white transition-colors" href="/VoTuanKiet/account/register">
                                <i class="fas fa-user-plus mr-2"></i>Đăng ký
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <script>
        function toggleDropdown(event) {
            event.stopPropagation();
            const dropdownMenu = document.getElementById('dropdownMenu');
            const dropdownIcon = document.getElementById('dropdownIcon');
            
            if (dropdownMenu.classList.contains('opacity-0')) {
                dropdownMenu.classList.remove('opacity-0', 'invisible', '-translate-y-10');
                dropdownMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
                dropdownIcon.classList.add('rotate-180');
            } else {
                dropdownMenu.classList.add('opacity-0', 'invisible', '-translate-y-10');
                dropdownMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                dropdownIcon.classList.remove('rotate-180');
            }
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.querySelector('.dropdown');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const dropdownIcon = document.getElementById('dropdownIcon');
            
            if (dropdown && !dropdown.contains(event.target)) {
                dropdownMenu.classList.add('opacity-0', 'invisible', '-translate-y-10');
                dropdownMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                dropdownIcon.classList.remove('rotate-180');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const dropdownMenu = document.getElementById('dropdownMenu');
            if (dropdownMenu) {
                dropdownMenu.classList.add('opacity-0', 'invisible', '-translate-y-10');
            }
        });

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('navbarNav');
            mobileMenu.classList.toggle('active');
        }
    </script>
</body>
</html>