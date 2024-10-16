<?php
// controllers/cartController.php

session_start();

// Đảm bảo rằng yêu cầu là POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

// Lấy dữ liệu từ yêu cầu POST
$action = isset($_POST['action']) ? $_POST['action'] : '';
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$color = isset($_POST['color']) ? trim($_POST['color']) : '';

// Xử lý hành động
if ($action === 'add') {
    if ($product_id <= 0 || empty($color)) {
        echo json_encode(['success' => false, 'message' => 'Invalid product or color.']);
        exit;
    }

    // Tạo giỏ hàng nếu chưa tồn tại
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Tạo key duy nhất cho sản phẩm và màu sắc
    $cart_key = $product_id . '_' . md5($color);

    if (isset($_SESSION['cart'][$cart_key])) {
        // Nếu sản phẩm đã có trong giỏ hàng với màu sắc này, tăng số lượng
        $_SESSION['cart'][$cart_key]['quantity'] += 1;
    } else {
        // Thêm sản phẩm mới vào giỏ hàng
        $_SESSION['cart'][$cart_key] = [
            'product_id' => $product_id,
            'color' => $color,
            'quantity' => 1
        ];
    }

    echo json_encode(['success' => true, 'message' => 'Product added to cart.']);
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}
?>
