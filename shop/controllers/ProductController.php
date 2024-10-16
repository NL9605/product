<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "./configs/database.php"; // Kết nối cơ sở dữ liệu
include_once "./models/ProductModel.php"; // Mô hình sản phẩm

class ProductController
{
    private $productModel;

    public function __construct()
    {
        $conn = database(); // Kết nối cơ sở dữ liệu
        $this->productModel = new ProductModel($conn);
    }

    public function showProducts()
    {
        // Thiết lập phân trang
        $limit = 5; // Số sản phẩm trên mỗi trang
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // Lấy từ khóa tìm kiếm
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Lấy tổng số sản phẩm
        $totalProducts = $this->productModel->getTotalProducts($search);
        $totalPages = ceil($totalProducts / $limit);

        // Lấy sản phẩm cho trang hiện tại
        $products = $this->productModel->getProductsByPage($limit, $offset, $search);

        // Dữ liệu cần truyền vào view
        $data = [
            'products' => $products,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];

        // Truyền dữ liệu vào view
        extract($data);
        include './views/product/product.php'; // Đảm bảo đường dẫn đúng
    }


    public function showProductDetails($id){
        $product = $this->productModel->getProductById($id);
        if($product){
            include "./views/product/product_detail.php";
        } else {
            echo "<p>Can't find products.</p>";
        }
    }
}

// Khởi tạo và gọi controller
$controller = new ProductController();
$controller->showProducts();
?>
