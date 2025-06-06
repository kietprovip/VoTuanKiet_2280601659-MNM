<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once('app/helper/SessionHelper.php');

class AccountController
{
    private $accountModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->save();
        } else {
            include_once 'app/views/account/register.php';
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->checkLogin();
        } else {
            include_once 'app/views/account/login.php';
        }
    }

    public function save()
    {
        $username = $_POST['username'] ?? '';
        $fullName = $_POST['fullname'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? ''; // Sửa tên field này
        $role = $_POST['role'] ?? 'user';
        
        $errors = [];
        
        // Validation
        if (empty($username)) {
            $errors['username'] = "Vui lòng nhập tên đăng nhập!";
        }
        if (empty($fullName)) {
            $errors['fullname'] = "Vui lòng nhập họ và tên!";
        }
        if (empty($email)) {
            $errors['email'] = "Vui lòng nhập email!";
        }
        if (empty($password)) {
            $errors['password'] = "Vui lòng nhập mật khẩu!";
        }
        if ($password != $confirmPassword) {
            $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ!";
        }
        
        // Kiểm tra username đã tồn tại
        if ($this->accountModel->getAccountByUsername($username)) {
            $errors['username'] = "Tên đăng nhập này đã được sử dụng!";
        }
        
        // Kiểm tra email đã tồn tại
        if ($this->accountModel->getAccountByEmail($email)) {
            $errors['email'] = "Email này đã được sử dụng!";
        }
        
        if (count($errors) > 0) {
            $error = implode('<br>', $errors);
            include_once 'app/views/account/register.php';
        } else {
            $result = $this->accountModel->save($username, $fullName, $email, $password, $role);
            
            if ($result) {
                $success = "Đăng ký thành công! Bạn có thể đăng nhập ngay.";
                include_once 'app/views/account/register.php';
            } else {
                $error = "Có lỗi xảy ra khi đăng ký. Vui lòng thử lại!";
                include_once 'app/views/account/register.php';
            }
        }
    }

    public function logout()
    {
        SessionHelper::start();
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        session_destroy();
        header('Location: /VoTuanKiet/product');
        exit;
    }

    public function checkLogin()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $error = "Vui lòng nhập đầy đủ thông tin đăng nhập!";
            include_once 'app/views/account/login.php';
            return;
        }
        
        $account = $this->accountModel->getAccountByUsername($username);
        
        if ($account && password_verify($password, $account->password)) {
            SessionHelper::start();
            $_SESSION['username'] = $account->username;
            $_SESSION['role'] = $account->role;
            $_SESSION['user_id'] = $account->id;
            
            header('Location: /VoTuanKiet/product');
            exit;
        } else {
            $error = $account ? "Mật khẩu không đúng!" : "Không tìm thấy tài khoản!";
            include_once 'app/views/account/login.php';
        }
    }

    public function profile()
    {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /VoTuanKiet/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->updateProfile();
        } else {
            $user = $this->accountModel->getAccountByUsername($_SESSION['username']);
            include_once 'app/views/Account/profile.php';
        }
    }

    public function settings()
    {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /VoTuanKiet/account/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->updateSettings();
        } else {
            $user = $this->accountModel->getAccountByUsername($_SESSION['username']);
            include_once 'app/views/Account/settings.php';
        }
    }

    private function updateProfile()
    {
        $fullname = $_POST['fullname'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';

        $errors = [];

        if (empty($fullname)) {
            $errors['fullname'] = "Vui lòng nhập họ và tên!";
        }
        if (empty($email)) {
            $errors['email'] = "Vui lòng nhập email!";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ!";
        }

        // Kiểm tra email đã tồn tại (trừ email hiện tại)
        $existingUser = $this->accountModel->getAccountByEmail($email);
        if ($existingUser && $existingUser->username !== $_SESSION['username']) {
            $errors['email'] = "Email này đã được sử dụng!";
        }

        if (count($errors) > 0) {
            $error = implode('<br>', $errors);
            $user = $this->accountModel->getAccountByUsername($_SESSION['username']);
            include_once 'app/views/Account/profile.php';
        } else {
            $result = $this->accountModel->updateProfile($_SESSION['username'], $fullname, $email, $phone, $address);
            
            if ($result) {
                $success = "Cập nhật thông tin thành công!";
                $user = $this->accountModel->getAccountByUsername($_SESSION['username']);
                include_once 'app/views/Account/profile.php';
            } else {
                $error = "Có lỗi xảy ra khi cập nhật. Vui lòng thử lại!";
                $user = $this->accountModel->getAccountByUsername($_SESSION['username']);
                include_once 'app/views/Account/profile.php';
            }
        }
    }

    private function updateSettings()
    {
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        $errors = [];
        $user = $this->accountModel->getAccountByUsername($_SESSION['username']);

        if (!empty($new_password)) {
            if (empty($current_password)) {
                $errors['current_password'] = "Vui lòng nhập mật khẩu hiện tại!";
            } elseif (!password_verify($current_password, $user->password)) {
                $errors['current_password'] = "Mật khẩu hiện tại không đúng!";
            }

            if (strlen($new_password) < 6) {
                $errors['new_password'] = "Mật khẩu mới phải có ít nhất 6 ký tự!";
            }

            if ($new_password !== $confirm_password) {
                $errors['confirm_password'] = "Xác nhận mật khẩu không khớp!";
            }
        }

        if (count($errors) > 0) {
            $error = implode('<br>', $errors);
            include_once 'app/views/Account/settings.php';
        } else {
            if (!empty($new_password)) {
                $result = $this->accountModel->updatePassword($_SESSION['username'], $new_password);
                
                if ($result) {
                    $success = "Đổi mật khẩu thành công!";
                } else {
                    $error = "Có lỗi xảy ra khi đổi mật khẩu!";
                }
            } else {
                $success = "Không có thay đổi nào!";
            }
            
            include_once 'app/views/Account/settings.php';
        }
    }
}