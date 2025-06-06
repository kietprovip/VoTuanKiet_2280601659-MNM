<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductController
{
    private $productModel;
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
        $this->categoryModel = new CategoryModel($this->db);
    }

    // Kiểm tra quyền Admin
    private function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function index()
    {
        $products = $this->productModel->getProducts();
        $categories = $this->categoryModel->getCategories();
        include_once 'app/views/Product/list.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include_once 'app/views/Product/show.php';
        } else {
            // Product not found, redirect or show error
            header('Location: /VoTuanKiet/Product/');
            exit;
        }
    }

    public function add()
    {
        if (!$this->isAdmin()) {
            header('Location: /VoTuanKiet/');
            exit;
        }
        
        $categories = $this->categoryModel->getCategories(); // Thêm dòng này
        include_once 'app/views/Product/add.php';
    }

    public function save()
    {
        if (!$this->isAdmin()) {
            header('Location: /VoTuanKiet/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $category_id = $_POST['category_id'] ?? 0;
            
            // Handle file upload
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $uploadDir = 'uploads/products/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = time() . '_' . $_FILES['image']['name'];
                $uploadFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $image = $uploadFile;
                }
            }
            
            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);
            
            if ($result) {
                header('Location: /VoTuanKiet/Product/?success=Product added successfully');
                exit;
            } else {
                $error = "Có lỗi xảy ra khi thêm sản phẩm";
                $categories = $this->categoryModel->getCategories();
                include_once 'app/views/Product/add.php';
            }
        }
    }

    public function edit($id)
    {
        if (!$this->isAdmin()) {
            header('Location: /VoTuanKiet/');
            exit;
        }

        $product = $this->productModel->getProductById($id);
        $categories = $this->categoryModel->getCategories(); // Thêm dòng này
        
        if ($product) {
            include_once 'app/views/Product/edit.php';
        } else {
            header('Location: /VoTuanKiet/Product/?error=Product not found');
            exit;
        }
    }

    public function update()
    {
        if (!$this->isAdmin()) {
            header('Location: /VoTuanKiet/');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'] ?? 0;
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? 0;
            $category_id = $_POST['category_id'] ?? 0;
            
            // Handle file upload
            $image = $_POST['current_image'] ?? '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $uploadDir = 'uploads/products/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = time() . '_' . $_FILES['image']['name'];
                $uploadFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    // Delete old image if exists
                    if (!empty($image) && file_exists($image)) {
                        unlink($image);
                    }
                    $image = $uploadFile;
                }
            }
            
            $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
            
            if ($result) {
                header('Location: /VoTuanKiet/Product/?success=Product updated successfully');
                exit;
            } else {
                $error = "Có lỗi xảy ra khi cập nhật sản phẩm";
                $product = $this->productModel->getProductById($id);
                $categories = $this->categoryModel->getCategories();
                include_once 'app/views/Product/edit.php';
            }
        }
    }

    public function delete($id)
    {
        if (!$this->isAdmin()) {
            header('Location: /VoTuanKiet/');
            exit;
        }

        $product = $this->productModel->getProductById($id);
        
        if ($product) {
            // Delete image file if exists
            if (!empty($product->image) && file_exists($product->image)) {
                unlink($product->image);
            }
            
            $result = $this->productModel->deleteProduct($id);
            
            if ($result) {
                header('Location: /VoTuanKiet/Product/?success=Product deleted successfully');
            } else {
                header('Location: /VoTuanKiet/Product/?error=Failed to delete product');
            }
        } else {
            header('Location: /VoTuanKiet/Product/?error=Product not found');
        }
        exit;
    }

     public function addToCart($id)
    {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Sản phẩm không tìm thấy.']);
                exit;
            }
            echo "Không tìm thấy sản phẩm.";
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }

        if ($this->isAjaxRequest()) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Đã thêm vào giỏ hàng!',
                'cartItemCount' => count($_SESSION['cart']),
                'cartTotal' => $this->calculateCartTotal()
            ]);
            exit;
        }
        header('Location: /VoTuanKiet/Product/cart');
        exit;
    }

    public function cart()
    {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $cartTotalPrice = $this->calculateCartTotal();
        include 'app/views/product/cart.php';
    }

    private function calculateCartTotal()
    {
        $total = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $total += $item['price'] * $item['quantity'];
            }
        }
        return $total;
    }
    private function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
    public function increaseQuantity($id)
    {
        $response = ['success' => false, 'message' => 'Lỗi cập nhật giỏ hàng.'];
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
            $response = [
                'success' => true,
                'newQuantity' => $_SESSION['cart'][$id]['quantity'],
                'itemTotalPrice' => $_SESSION['cart'][$id]['price'] * $_SESSION['cart'][$id]['quantity'],
                'cartTotalPrice' => $this->calculateCartTotal(),
                'cartItemCount' => count($_SESSION['cart'])
            ];
        } else {
            $response['message'] = 'Sản phẩm không có trong giỏ hàng.';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    public function decreaseQuantity($id)
    {
        $response = ['success' => false, 'message' => 'Lỗi cập nhật giỏ hàng.'];
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']--;
            if ($_SESSION['cart'][$id]['quantity'] <= 0) {
                unset($_SESSION['cart'][$id]);
                $response = [
                    'success' => true,
                    'itemRemoved' => true,
                    'productId' => $id,
                    'cartTotalPrice' => $this->calculateCartTotal(),
                    'cartItemCount' => count($_SESSION['cart'])
                ];
            } else {
                $response = [
                    'success' => true,
                    'newQuantity' => $_SESSION['cart'][$id]['quantity'],
                    'itemTotalPrice' => $_SESSION['cart'][$id]['price'] * $_SESSION['cart'][$id]['quantity'],
                    'cartTotalPrice' => $this->calculateCartTotal(),
                    'cartItemCount' => count($_SESSION['cart'])
                ];
            }
        } else {
            $response['message'] = 'Sản phẩm không có trong giỏ hàng.';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    public function removeFromCart($id)
    {
        $response = ['success' => false, 'message' => 'Lỗi xóa sản phẩm.'];
        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            $response = [
                'success' => true,
                'itemRemoved' => true,
                'productId' => $id,
                'cartTotalPrice' => $this->calculateCartTotal(),
                'cartItemCount' => count($_SESSION['cart'])
            ];
        } else {
            $response['message'] = 'Sản phẩm không có trong giỏ hàng.';
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
     public function checkout()
    {
        if (empty($_SESSION['cart'])) {
            header('Location: /VoTuanKiet/Product/cart');
            exit;
        }
        include 'app/views/product/checkout.php';
    }

    public function processCheckout()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            header('Location: /VoTuanKiet/Product/cart?error=emptycart');
            exit;
        }

        // Validate input fields
        $name = $_POST['name'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $address = $_POST['address'] ?? '';

        // Check for required fields
        if (empty($name) || empty($phone) || empty($address)) {
            echo "Vui lòng điền đầy đủ thông tin: Họ tên, Số điện thoại, và Địa chỉ.";
            return;
        }

        $this->db->beginTransaction();
        try {
            $query = "INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->execute();
            $order_id = $this->db->lastInsertId();

            $cart = $_SESSION['cart'];
            foreach ($cart as $product_id => $item) {
                $query = "INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':order_id', $order_id);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':quantity', $item['quantity']);
                $stmt->bindParam(':price', $item['price']);
                $stmt->execute();
            }
            unset($_SESSION['cart']);
            $this->db->commit();
            header('Location: /VoTuanKiet/Product/orderConfirmation');
            exit;
        } catch (Exception $e) {
            $this->db->rollBack();
            echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
        }
    }
}

    public function orderConfirmation()
    {
        include 'app/views/product/OrderConfirm.php';
    }
}