<?php
class SizeModel {
    private $conn;
    private $table = 'Sizes'; // Tên bảng 'Sizes'

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Tạo kích thước mới
    public function createSize($name) {
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " (size_name) VALUES (?)");
        return $stmt->execute([$name]);
    }

    // Lấy tất cả kích thước
    public function getAllSizes() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy kích thước theo ID
    public function getSizeById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE size_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật kích thước
    public function editSize($id, $name) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET size_name = ? WHERE size_id = ?");
        return $stmt->execute([$name, $id]);
    }

    // Xóa kích thước
    public function deleteSize($id) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE size_id = ?");
        return $stmt->execute([$id]);
    }
}
