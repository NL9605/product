<?php
class CustomerModel
{
    private $conn;
    private $table = 'Customer';

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Đăng ký người dùng mới
    public function signup($username, $password, $email, $phone, $address, $role = 0)
    {
        // Kiểm tra tên đăng nhập đã tồn tại chưa
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE username = ?");
        $stmt->execute([$username]);

        if ($stmt->rowCount() > 0) {
            return false; // Tên đăng nhập đã tồn tại
        }

        // Băm mật khẩu trước khi lưu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Lưu thông tin người dùng vào cơ sở dữ liệu
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " (username, password, email, phone, address, role) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$username, $hashedPassword, $email, $phone, $address, $role]);
    }

    // Đăng nhập khách hàng
    public function login($username, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra mật khẩu
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Trả về thông tin người dùng nếu đăng nhập thành công
        }
        return false; // Đăng nhập không thành công
    }
}
?>
