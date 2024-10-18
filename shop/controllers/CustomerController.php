<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "../../configs/database.php";
include_once "../../models/CustomerModel.php";

class CustomerController
{
    private $customerModel;

    public function __construct()
    {
        $conn = database(); // Kết nối cơ sở dữ liệu
        $this->customerModel = new CustomerModel($conn);
    }

    // Phương thức để đăng ký khách hàng
    public function signup($username, $password, $email, $phone, $address)
    {
        if ($this->customerModel->signup($username, $password, $email, $phone, $address)) {
            // Đăng ký thành công, chuyển hướng về trang đăng nhập
            header("Location: ../../views/customer/login.php"); // Đảm bảo đường dẫn chính xác
            exit(); // Dừng script sau khi chuyển hướng
        } else {
            return "Tên đăng nhập đã tồn tại!";
        }
    }

    // Phương thức để đăng nhập khách hàng
    public function login($username, $password)
    {
        $user = $this->customerModel->login($username, $password);
        if ($user) {
            // Kiểm tra vai trò của người dùng
            session_start();
            $_SESSION['user'] = $user; // Lưu trữ thông tin người dùng trong session

            if ($user['role'] == 1) {
                // Nếu là admin, chuyển hướng về trang admin
                header("Location: ../../../app/index.php");
            } else {
                header("Location: ../../index.php");
            }
            exit(); // Dừng script sau khi chuyển hướng
        } else {
            return "Đăng nhập không thành công!";
        }
    }
}
?>
