<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');

class ProductController
{
    private $productModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index()
    {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add()
    {
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }
            $result = $this->productModel->addProduct(
                $name,
                $description,
                $price,
                $category_id,
                $image
            );
            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /VoTuanKiet/Product');
            }
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }
            $edit = $this->productModel->updateProduct(
                $id,
                $name,
                $description,
                $price,
                $category_id,
                $image
            );
            if ($edit) {
                header('Location: /VoTuanKiet/Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id)
    {
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /VoTuanKiet/Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file)
    {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType !=
            "jpeg" && $imageFileType != "gif"
        ) {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $target_file;
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
