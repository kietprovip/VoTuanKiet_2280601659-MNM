<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Đăng ký - Quản lý sản phẩm</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <style>
    .glass-effect {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .floating {
      animation: floating 6s ease-in-out infinite;
    }

    @keyframes floating {
      0%, 100% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(-20px);
      }
    }

    .gradient-text {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .input-group:focus-within .input-icon {
      color: #667eea;
      transform: scale(1.1);
    }

    .input-icon {
      transition: all 0.3s ease;
    }

    .bg-pattern {
      background-image:
        radial-gradient(at 40% 20%, hsla(28, 100%, 74%, 1) 0px, transparent 50%),
        radial-gradient(at 80% 0%, hsla(189, 100%, 56%, 1) 0px, transparent 50%),
        radial-gradient(at 0% 50%, hsla(355, 100%, 93%, 1) 0px, transparent 50%),
        radial-gradient(at 80% 50%, hsla(340, 100%, 76%, 1) 0px, transparent 50%),
        radial-gradient(at 0% 100%, hsla(22, 100%, 77%, 1) 0px, transparent 50%),
        radial-gradient(at 80% 100%, hsla(242, 100%, 70%, 1) 0px, transparent 50%),
        radial-gradient(at 0% 0%, hsla(343, 100%, 76%, 1) 0px, transparent 50%);
    }
  </style>
</head>

<body class="min-h-screen h-auto bg-cover bg-center relative overflow-y-auto" style="background-image: url('/VoTuanKiet/public/images/1.png');">

  <!-- Floating Background Elements -->
  <div class="absolute inset-0 overflow-hidden">
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 floating"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 floating" style="animation-delay: 2s;"></div>
    <div class="absolute top-40 left-40 w-80 h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 floating" style="animation-delay: 4s;"></div>
  </div>

  <div class="min-h-screen flex items-center justify-center px-4 py-8 relative z-10">
    <div class="max-w-sm w-full space-y-6">
      <!-- Header -->
      <div class="text-center">
       
        <h2 class="text-3xl font-extrabold text-purple-800 mb-2"">Tạo tài khoản mới!</h2>
      </div>

      <!-- Form Container -->
      <div class="glass-effect rounded-xl shadow-2xl p-6 space-y-5">
        <!-- PHP messages -->
        <?php if (isset($error)): ?>
          <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
            <div class="flex">
              <i class="fas fa-exclamation-triangle text-red-500 text-sm mr-2 mt-1"></i>
              <p class="text-sm text-red-700"><?php echo $error; ?></p>
            </div>
          </div>
        <?php endif; ?>
        <?php if (isset($success)): ?>
          <div class="bg-green-50 border-l-4 border-green-500 p-3 rounded-lg">
            <div class="flex">
              <i class="fas fa-check-circle text-green-500 text-sm mr-2 mt-1"></i>
              <p class="text-sm text-green-700"><?php echo $success; ?></p>
            </div>
          </div>
        <?php endif; ?>

        <!-- Form -->
        <form action="/VoTuanKiet/account/register" method="POST" class="space-y-4">
          <!-- Họ tên -->
          <div class="input-group">
            <label for="fullname" class="block text-sm font-semibold text-gray-700 mb-1">Họ và tên</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <i class="fas fa-user-circle input-icon text-gray-400"></i>
              </span>
              <input type="text" id="fullname" name="fullname" required placeholder="Nhập họ và tên"
                class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 bg-white/50 text-sm" />
            </div>
          </div>

          <!-- Username -->
          <div class="input-group">
            <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">Tên đăng nhập</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <i class="fas fa-user input-icon text-gray-400"></i>
              </span>
              <input type="text" id="username" name="username" required placeholder="Nhập tên đăng nhập"
                class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 bg-white/50 text-sm" />
            </div>
          </div>

          <!-- Email -->
          <div class="input-group">
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <i class="fas fa-envelope input-icon text-gray-400"></i>
              </span>
              <input type="email" id="email" name="email" required placeholder="Nhập email"
                class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 bg-white/50 text-sm" />
            </div>
          </div>

          <!-- Mật khẩu -->
          <div class="input-group">
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Mật khẩu</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <i class="fas fa-lock input-icon text-gray-400"></i>
              </span>
              <input type="password" id="password" name="password" required placeholder="Nhập mật khẩu"
                class="block w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 bg-white/50 text-sm" />
              <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                <button type="button" onclick="togglePassword('password', 'toggleIcon1')" class="text-gray-400 hover:text-purple-500">
                  <i class="fas fa-eye text-sm" id="toggleIcon1"></i>
                </button>
              </span>
            </div>
          </div>

          <!-- Xác nhận mật khẩu -->
          <div class="input-group">
            <label for="confirm_password" class="block text-sm font-semibold text-gray-700 mb-1">Xác nhận mật khẩu</label>
            <div class="relative">
              <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <i class="fas fa-lock input-icon text-gray-400"></i>
              </span>
              <input type="password" id="confirm_password" name="confirm_password" required placeholder="Nhập lại mật khẩu"
                class="block w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-purple-500 bg-white/50 text-sm" />
              <span class="absolute inset-y-0 right-0 pr-3 flex items-center">
                <button type="button" onclick="togglePassword('confirm_password', 'toggleIcon2')" class="text-gray-400 hover:text-purple-500">
                  <i class="fas fa-eye text-sm" id="toggleIcon2"></i>
                </button>
              </span>
            </div>
          </div>

          <!-- Nút đăng ký -->
          <button type="submit"
            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-base font-semibold rounded-lg text-white bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-700 hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <i class="fas fa-user-plus group-hover:translate-x-1 transition-transform text-sm"></i>
            </span>
            Đăng ký ngay
          </button>
        </form>

        <!-- Đường kẻ chia -->
        <div class="relative">
          <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200"></div>
          </div>
          <div class="relative flex justify-center text-sm">
            <span class="px-3 bg-white text-gray-500 rounded-full text-xs">hoặc</span>
          </div>
        </div>

        <!-- Liên kết đăng nhập và trang chủ -->
        <div class="text-center">
          <p class="text-sm text-gray-600">Đã có tài khoản?
            <a href="/VoTuanKiet/account/login" class="text-purple-600 hover:text-purple-800 hover:underline">Đăng nhập ngay!</a>
          </p>
          <a href="/VoTuanKiet/Product" class="inline-flex items-center text-white/80 hover:text-white transition-colors group text-sm mt-2">
            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform text-sm"></i>
            Quay lại trang chủ
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Script xử lý hiển thị mật khẩu -->
  <script>
    function togglePassword(fieldId, iconId) {
      const field = document.getElementById(fieldId);
      const icon = document.getElementById(iconId);
      if (field.type === "password") {
        field.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        field.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }

    // Kiểm tra xác nhận mật khẩu
    document.getElementById("confirm_password").addEventListener("input", function () {
      const pw = document.getElementById("password").value;
      if (this.value !== pw) {
        this.setCustomValidity("Mật khẩu không khớp");
        this.reportValidity();
      } else {
        this.setCustomValidity("");
      }
    });
  </script>
</body>

</html>
