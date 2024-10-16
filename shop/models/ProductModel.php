<?php
class ProductModel
{
    private $conn;
    private $table = 'Products';

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Lấy tất cả sản phẩm
    public function getAllProducts()
    {
        $sql = "SELECT p.product_id, p.product_name, p.price, p.image, p.description, GROUP_CONCAT(c.name) AS colors
                FROM products p
                LEFT JOIN product_colors pc ON p.product_id = pc.product_id
                LEFT JOIN colors c ON pc.color_id = c.id
                GROUP BY p.product_id";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm theo phân trang
    public function getProductsByPage($limit, $offset)
    {
        $sql = "SELECT p.product_id, p.product_name, p.price, p.image, p.description, GROUP_CONCAT(c.name) AS colors
                FROM products p
                LEFT JOIN product_colors pc ON p.product_id = pc.product_id
                LEFT JOIN colors c ON pc.color_id = c.id
                GROUP BY p.product_id
                ORDER BY p.product_id DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đếm tổng số sản phẩm
    public function getTotalProducts()
    {
        $sql = "SELECT COUNT(*) as total FROM products";
        $stmt = $this->conn->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // Lấy sản phẩm theo ID
    public function getProductById($id){
        $query = "SELECT p.product_id, p.product_name, p.price, p.image, p.description, 
                         GROUP_CONCAT(c.name SEPARATOR ', ') AS colors
                  FROM " . $this->table . " p
                  LEFT JOIN product_colors pc ON p.product_id = pc.product_id
                  LEFT JOIN colors c ON pc.color_id = c.id
                  WHERE p.product_id = :id
                  GROUP BY p.product_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
