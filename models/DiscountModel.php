<?php
class DiscountModel
{
    private $conn;
    private $table = 'Discounts'; // Đặt tên bảng trong cơ sở dữ liệu

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createDiscount($code, $percentage, $startDate, $endDate)
    {
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " (discount_code, discount_percentage, start_date, end_date) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$code, $percentage, $startDate, $endDate]);
    }

    public function getAllDiscounts()
    {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ?: []; // Trả về mảng rỗng nếu không có kết quả
    }

    public function getDiscountById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE discount_id = ?"); // Thay 'id' thành 'discount_id'
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteDiscount($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE discount_id = ?"); // Thay 'id' thành 'discount_id'
        return $stmt->execute([$id]);
    }

    public function editDiscount($id, $code, $percentage, $startDate, $endDate)
    {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET discount_code = ?, discount_percentage = ?, start_date = ?, end_date = ? WHERE discount_id = ?");
        return $stmt->execute([$code, $percentage, $startDate, $endDate, $id]);
    }
}
