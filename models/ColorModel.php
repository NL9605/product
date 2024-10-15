<?php
class ColorModel {
    private $conn;
    private $table = 'colors';

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllColors() {
        $query = "SELECT * FROM " . $this->table; // Sử dụng biến $table
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return []; // Trả về mảng rỗng nếu không có dữ liệu
        }
    }

    public function createColor($colorName) {
        $query = "INSERT INTO " . $this->table . " (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $colorName);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId(); // Trả về ID của màu sắc vừa tạo
        }
        return false; // Trả về false nếu không thành công
    }

    public function updateColor($id, $colorName) {
        $query = "UPDATE " . $this->table . " SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $colorName);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteColor($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getColorById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return null; // Trả về null nếu không tìm thấy màu sắc
    }
}
