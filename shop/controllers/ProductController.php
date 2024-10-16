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
        $products = $this->productModel->getAllProducts(); // Lấy danh sách sản phẩm
        include './views/product/product.php'; // Đảm bảo đường dẫn đúng
    }
    public function showProductDetails($id){
        $product = $this->model->getProductById($id);
        if($product){
            include "./views/product/product_detail.php";
        } else {
            echo "<p>Không tìm thấy sản phẩm.</p>";
        }
    }
}

$controller = new ProductController();
$controller->showProducts();
?>
