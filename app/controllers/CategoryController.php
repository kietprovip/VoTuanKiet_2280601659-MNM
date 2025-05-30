<?php
require_once('app/config/database.php'); //
require_once('app/models/CategoryModel.php'); //

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection(); //
        $this->categoryModel = new CategoryModel($this->db); //
    }

    public function index()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    public function add()
    {
        $errors = $_SESSION['errors'] ?? [];
        $old_input = $_SESSION['old_input'] ?? [];
        unset($_SESSION['errors'], $_SESSION['old_input']);

        include 'app/views/category/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            $result = $this->categoryModel->addCategory($name, $description);

            if ($result === true) {
                $_SESSION['message'] = ['type' => 'success', 'text' => 'Thêm danh mục thành công!'];
                header('Location: /VoTuanKiet/category/index');
                exit;
            } else if (is_array($result)) { // Validation errors
                $_SESSION['errors'] = $result;
                $_SESSION['old_input'] = ['name' => $name, 'description' => $description];
                $errors = $result;
                $old_input = ['name' => $name, 'description' => $description];
                include 'app/views/category/add.php';
            } else {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'Lỗi: Không thể thêm danh mục.'];
                $errors['general'] = 'Không thể thêm danh mục do lỗi hệ thống.';
                $old_input = ['name' => $name, 'description' => $description];
                include 'app/views/category/add.php';

            }
        } else {
            header('Location: /VoTuanKiet/category/add');
            exit;
        }
    }

    public function edit($id)
    {
        if (empty($id)) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'ID danh mục không hợp lệ.'];
            header('Location: /VoTuanKiet/category/index');
            exit;
        }

        $category = $this->categoryModel->getCategoryById($id);

        if (!$category) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Không tìm thấy danh mục.'];
            header('Location: /VoTuanKiet/category/index');
            exit;
        }
        
        $errors = $_SESSION['errors'] ?? [];
        $old_input = $_SESSION['old_input'] ?? []; // For re-populating form on error
        unset($_SESSION['errors'], $_SESSION['old_input']);

        include 'app/views/category/edit.php'; // This view will be created
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if (empty($id)) {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'ID danh mục không hợp lệ.'];
                header('Location: /VoTuanKiet/category/index');
                exit;
            }

            $result = $this->categoryModel->updateCategory($id, $name, $description);

            if ($result === true) {
                header('Location: /VoTuanKiet/category/index');
                exit;
            } else if (is_array($result)) {
                 $errors = $result;
                 $category = (object)['id' => $id, 'name' => $name, 'description' => $description];
                 include 'app/views/category/edit.php';

            } else {
                $errors['general'] = 'Không thể cập nhật danh mục do lỗi hệ thống.';
                $category = (object)['id' => $id, 'name' => $name, 'description' => $description];
                include 'app/views/category/edit.php';
            }
        } else {
            header('Location: /VoTuanKiet/category/index');
            exit;
        }
    }
    
    public function delete($id) {
        if (empty($id)) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'ID danh mục không hợp lệ.'];
            header('Location: /VoTuanKiet/category/index');
            exit;
        }
        
        $result = $this->categoryModel->deleteCategory($id);

        if ($result === true) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Xóa danh mục thành công!'];
        } else if (is_array($result) && isset($result['error'])) {
            $_SESSION['message'] = ['type' => 'error', 'text' => $result['error']];
        } else if ($result === false) {
             $_SESSION['message'] = ['type' => 'error', 'text' => 'Lỗi: Không thể xóa danh mục hoặc danh mục không tồn tại.'];
        }
        
        header('Location: /VoTuanKiet/category/index');
        exit;
    }
}