<?php
include_once "../../controllers/CustomerController.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Khởi tạo controller và gọi phương thức đăng nhập
    $customerController = new CustomerController();
    $result = $customerController->login($username, $password);

    // Xử lý kết quả trả về
    if (is_array($result) && $result['message'] === "Login successfully!") {
        echo "Login successfully!";
    } else {
        echo $result;
    }
}
?>
