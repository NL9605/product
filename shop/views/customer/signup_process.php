<?php
include_once "../../controllers/CustomerController.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Khởi tạo controller và gọi phương thức đăng ký
    $customerController = new CustomerController();
    $result = $customerController->signup($username, $password, $email, $phone, $address);

    // Xử lý kết quả trả về
    if ($result === "Tên đăng nhập đã tồn tại!") {
        echo $result;
    }
}
?>
