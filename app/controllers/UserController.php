<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');
require_once('app/helper/SessionHelper.php');

class UserController
{
    private $accountModel;
    private $db;

    public function __construct()
    {
        // Kiểm tra quyền admin
        if (!SessionHelper::isAdmin()) {
            header('Location: /VoTuanKiet/account/login');
            exit;
        }

        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    public function index()
    {
        $users = $this->accountModel->getAllUsers();
        include_once 'app/views/User/list.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->store();
        } else {
            include_once 'app/views/User/add.php';
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->update($id);
        } else {
            $user = $this->accountModel->getUserById($id);
            if (!$user) {
                header('Location: /VoTuanKiet/user?error=User not found');
                exit;
            }
            include_once 'app/views/User/edit.php';
        }
    }

    public function delete($id)
    {
        $user = $this->accountModel->getUserById($id);
        if (!$user) {
            header('Location: /VoTuanKiet/user?error=User not found');
            exit;
        }

        // Không cho phép xóa chính mình
        if ($user->username === $_SESSION['username']) {
            header('Location: /VoTuanKiet/user?error=Cannot delete yourself');
            exit;
        }

        if ($this->accountModel->deleteUser($id)) {
            header('Location: /VoTuanKiet/user?success=User deleted successfully');
        } else {
            header('Location: /VoTuanKiet/user?error=Failed to delete user');
        }
        exit;
    }

    private function store()
    {
        $username = $_POST['username'] ?? '';
        $fullName = $_POST['fullname'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
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
            include_once 'app/views/User/add.php';
        } else {
            $result = $this->accountModel->createUser($username, $fullName, $email, $password, $role);
            
            if ($result) {
                header('Location: /VoTuanKiet/user?success=User created successfully');
                exit;
            } else {
                $error = "Có lỗi xảy ra khi tạo người dùng. Vui lòng thử lại!";
                include_once 'app/views/User/add.php';
            }
        }
    }

    private function update($id)
    {
        $fullName = $_POST['fullname'] ?? '';
        $email = $_POST['email'] ?? '';
        $role = $_POST['role'] ?? 'user';
        $password = $_POST['password'] ?? '';
        
        $errors = [];
        
        // Validation
        if (empty($fullName)) {
            $errors['fullname'] = "Vui lòng nhập họ và tên!";
        }
        if (empty($email)) {
            $errors['email'] = "Vui lòng nhập email!";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email không hợp lệ!";
        }
        
        // Kiểm tra email đã tồn tại (trừ user hiện tại)
        $existingUser = $this->accountModel->getAccountByEmail($email);
        if ($existingUser && $existingUser->id != $id) {
            $errors['email'] = "Email này đã được sử dụng!";
        }
        
        if (count($errors) > 0) {
            $error = implode('<br>', $errors);
            $user = $this->accountModel->getUserById($id);
            include_once 'app/views/User/edit.php';
        } else {
            $result = $this->accountModel->updateUser($id, $fullName, $email, $role,  $password);
            
            if ($result) {
                header('Location: /VoTuanKiet/user?success=User updated successfully');
                exit;
            } else {
                $error = "Có lỗi xảy ra khi cập nhật người dùng. Vui lòng thử lại!";
                $user = $this->accountModel->getUserById($id);
                include_once 'app/views/User/edit.php';
            }
        }
    }
}