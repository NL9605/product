<?php
class ProductModel
{
    private $conn;
    private $table = 'Products';

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllProducts()
    {
        $sql = "SELECT p.product_id, p.product_name, p.price, p.image_urls, p.description, GROUP_CONCAT(c.name) AS colors
        FROM products p
        LEFT JOIN product_colors pc ON p.product_id = pc.product_id
        LEFT JOIN colors c ON pc.color_id = c.id
        GROUP BY p.product_id";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProductById($id){
        $query = "SELECT p.product_id, p.product_name, p.price, p.image_urls, p.description, 
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
