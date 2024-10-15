<?php
class CategoryModel {
    private $conn;
    private $table = 'Categories';

    // Hàm khởi tạo nhận kết nối $conn
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Lấy tất cả các danh mục
    public function getAllCategories() {
        // Câu lệnh SQL đã được sửa với khoảng trắng đúng
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $kq = $stmt->fetchAll();
        return $kq;
    }
    public function delcategory($id) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE category_id = ?");
        $stmt->execute([$id]);
    }
    public function getcategory($id){
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE category_id = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $kq1 = $stmt->fetchAll();
        return $kq1;

    }
    public function updatecategory($id,$name) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET category_name = ?  WHERE category_id = ?");
        $stmt->execute([$name, $id]);

    }
    public function createCategory($name) {
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " (category_name) VALUES (?)");
        $stmt->execute([$name]);
    }



}
?>
