<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <!-- Replace Bootstrap with Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom configurations for Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Navigation bar with Tailwind -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/VoTuanKiet/product/" class="text-2xl font-bold text-primary-600">
                            Quản lý sản phẩm
                        </a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="/VoTuanKiet/Product/" 
                           class="border-transparent text-gray-500 hover:border-primary-500 hover:text-primary-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Danh sách sản phẩm
                        </a>
                        <a href="/VoTuanKiet/Product/add"
                           class="border-transparent text-gray-500 hover:border-primary-500 hover:text-primary-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Thêm sản phẩm
                        </a>
                    </div>
                </div>
                <div class="-mr-2 flex items-center sm:hidden">
                    <!-- Mobile menu button -->
                    <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                        <span class="sr-only">Open main menu</span>
                        <!-- Icon when menu is closed -->
                        <svg id="menu-closed-icon" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Icon when menu is open -->
                        <svg id="menu-open-icon" class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state -->
        <div id="mobile-menu" class="sm:hidden hidden">
            <div class="pt-2 pb-3 space-y-1">
                <a href="/VoTuanKiet/Product/" class="bg-gray-50 border-primary-500 text-primary-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Danh sách sản phẩm
                </a>
                <a href="/VoTuanKiet/Product/add" class="border-transparent text-gray-500 hover:bg-gray-50 hover:border-primary-500 hover:text-primary-700 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">
                    Thêm sản phẩm
                </a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Your page content will go here -->

    <script>
        // Mobile menu toggle functionality
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            const openIcon = document.getElementById('menu-open-icon');
            const closedIcon = document.getElementById('menu-closed-icon');
            
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                openIcon.classList.remove('hidden');
                closedIcon.classList.add('hidden');
            } else {
                mobileMenu.classList.add('hidden');
                openIcon.classList.add('hidden');
                closedIcon.classList.remove('hidden');
            }
        });
    </script>