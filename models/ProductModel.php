<?php
class ProductModel {
    private $conn;
    private $table = 'Products';

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Lấy tất cả sản phẩm cùng với thông tin danh mục, kích thước và khuyến mãi
    public function getAllProducts() {
        $query = "SELECT p.*, c.category_name, s.size_name, d.discount_code
              FROM " . $this->table . " p
              LEFT JOIN categories c ON p.category_id = c.category_id
              LEFT JOIN sizes s ON p.size_id = s.size_id
              LEFT JOIN discounts d ON p.discount_id = d.discount_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Lặp qua từng sản phẩm để lấy màu sắc
        foreach ($products as &$product) {
            $product['colors'] = $this->getProductColors($product['product_id']);
        }

        return $products;
    }


    // Lấy chi tiết sản phẩm theo ID
    public function getProductById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE product_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Lấy màu sắc cho sản phẩm này
        if ($product) {
            $product['colors'] = $this->getProductColors($id);
        }

        return $product;
    }

    // Tạo sản phẩm mới
    public function createProduct($name, $description, $price, $category_id, $size_id, $discount_id, $image_urls) {
        // Kiểm tra giá trị của discount_id
        if (empty($discount_id)) {
            $discount_id = null;
        }

        // In thông tin chi tiết để gỡ lỗi
        error_log("Creating product: Name: $name, Description: $description, Price: $price, Category ID: $category_id, Size ID: $size_id, Discount ID: $discount_id, Image URLs: $image_urls");

        $query = "INSERT INTO " . $this->table . " 
      (product_name, description, price, category_id, size_id, discount_id, image_urls)
      VALUES (:name, :description, :price, :category_id, :size_id, :discount_id, :image_urls)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':size_id', $size_id);
        $stmt->bindParam(':discount_id', $discount_id, PDO::PARAM_INT); // Chỉ định kiểu số nguyên
        $stmt->bindParam(':image_urls', $image_urls);

        return $stmt->execute();
    }


    // Chỉnh sửa sản phẩm
    public function editProduct($id, $name, $description, $price, $category_id, $size_id, $discount_id, $image_urls)
    {
        $query = "UPDATE " . $this->table . " 
              SET product_name = :name, description = :description, price = :price, 
                  category_id = :category_id, size_id = :size_id, discount_id = :discount_id, 
                  image_urls = :image_urls
              WHERE product_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':size_id', $size_id);
        $stmt->bindParam(':discount_id', $discount_id);
        $stmt->bindParam(':image_urls', $image_urls);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }


    // Xóa sản phẩm
    public function deleteProduct($id) {
        // Xóa sản phẩm trong bảng products
        $query = "DELETE FROM " . $this->table . " WHERE product_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        // Xóa các liên kết màu sắc trong bảng product_colors
        if ($stmt->execute()) {
            $this->deleteProductColors($id);
            return true;
        }
        return false;
    }

    // Lấy danh sách màu sắc của sản phẩm từ bảng product_colors
    public function getProductColors($productId) {
        $query = "SELECT c.id, c.name 
              FROM colors c 
              JOIN product_colors pc ON c.id = pc.color_id 
              WHERE pc.product_id = :productId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':productId', $productId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật màu sắc của sản phẩm
    private function updateProductColors($product_id, $color_ids) {
        // Xóa các màu sắc hiện tại của sản phẩm
        $this->deleteProductColors($product_id);

        // Chèn lại các màu sắc mới
        if (!empty($color_ids)) {
            $query = "INSERT INTO product_colors (product_id, color_id) VALUES (:product_id, :color_id)";
            $stmt = $this->conn->prepare($query);

            foreach ($color_ids as $color_id) {
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':color_id', $color_id);
                $stmt->execute();
            }
        }
    }

    // Xóa các liên kết màu sắc của sản phẩm
    private function deleteProductColors($product_id) {
        $query = "DELETE FROM product_colors WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $product_id);
        $stmt->execute();
    }
}
