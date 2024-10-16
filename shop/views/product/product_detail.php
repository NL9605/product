<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="../../shop/assets/css/product_detail.css"> <!-- Tạo file CSS riêng cho chi tiết sản phẩm -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding-top: 0;
            padding-bottom: 100px;
            background-color: white;
        }

        .detail-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 50px;
            margin: 30px auto;
            padding: 20px;
            max-width: 1200px;
        }

        .detail-left, .detail-right {
            flex: 1;
            min-width: 300px;
        }

        .detail-images img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .thumbnails {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .thumbnails img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 2px solid transparent;
            border-radius: 5px;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .thumbnails img:hover {
            border-color: #354B59;
        }

        .detail-right h2 {
            font-size: 2rem;
            margin-bottom: 15px;
            color: #333;
        }

        .detail-right .price {
            font-size: 1.5rem;
            color: black;
            margin-bottom: 20px;
        }

        .detail-right .description {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 20px;
        }

        .color-options {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .color-box {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid #ccc;
            margin-right: 10px;
            cursor: pointer;
            transition: transform 0.2s ease, border-color 0.3s ease;
        }

        .color-box:hover {
            transform: scale(1.1);
        }

        .color-box.selected {
            border-color: #354B59;
            transform: scale(1.1);
        }

        .selected-color {
            font-size: 1rem;
            color: #333;
            margin-left: 10px;
        }

        .add-to-cart-btn {
            background-color: #354B59;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px 20px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
            max-width: 300px;
        }

        .add-to-cart-btn:hover {
            background-color:#133447;
            transform: scale(1.05);
        }

        .add-to-cart-btn:active {
            transform: scale(0.98);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .detail-container {
                flex-direction: column;
                align-items: center;
            }

            .detail-left, .detail-right {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="detail-container">
    <div class="detail-left">
        <div class="detail-images">
            <?php
            // Kiểm tra và lấy thông tin sản phẩm
            if (isset($_GET['id'])) {
                $productId = htmlspecialchars($_GET['id']);
            } else {
                echo "<p>Không xác định được sản phẩm.</p>";
                exit;
            }

            // Kết nối cơ sở dữ liệu và lấy thông tin sản phẩm
            include_once "../../configs/database.php";
            include_once "../../models/ProductModel.php";

            $conn = database();
            $productModel = new ProductModel($conn);
            $product = $productModel->getProductById($productId);

            if ($product) {
                $imageUrls = !empty($product['image_urls']) ? explode(',', $product['image_urls']) : [];
                if (!empty($imageUrls)) {
                    // Phương Án 1: Điều Chỉnh Đường Dẫn
                    $mainImage = '../../' . htmlspecialchars(trim($imageUrls[0]));
                    ?>
                    <img id="main-image" src="<?php echo $mainImage; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" onerror="this.onerror=null; this.src='../../uploads/default-image.jpg';">
                    <?php if (count($imageUrls) > 1): ?>
                        <div class="thumbnails">
                            <?php
                            foreach ($imageUrls as $image) {
                                $thumbnailPath = '../../' . htmlspecialchars(trim($image));
                                echo '<img src="' . $thumbnailPath . '" alt="Thumbnail" onerror="this.onerror=null; this.src=\'../../uploads/default-image.jpg\';" onclick="document.getElementById(\'main-image\').src=\'' . $thumbnailPath . '\'">';
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php
                } else {
                    // Nếu không có hình ảnh, hiển thị hình mặc định
                    ?>
                    <img id="main-image" src="../../uploads/default-image.jpg" alt="Hình ảnh không có" onerror="this.onerror=null; this.src='../../uploads/default-image.jpg';">
                    <?php
                }
            } else {
                echo "<p>Không tìm thấy sản phẩm.</p>";
                exit;
            }
            ?>
        </div>
    </div>
    <div class="detail-right">
        <?php
        if ($product) {
            ?>
            <h2><?php echo htmlspecialchars($product['product_name']); ?></h2>
            <p class="price"><?php echo number_format($product['price'], 0, ',', '.') . ' $'; ?></p>
            <p class="description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            <div class="color-options">
                <span>Chọn màu:</span>
                <?php
                $colors = !empty($product['colors']) ? explode(',', $product['colors']) : [];
                $colorMapping = [
                    'Antique graphite' => '#5B5C57',
                    'Black' => '#000000',
                    'Red' => '#FF0000',
                    'Blue' => '#0000FF',
                    'White' => '#FFFFFF',
                    'Green' => '#008000',
                    'Yellow' => '#FFFF00',
                    'Purple' => '#800080',
                    // Thêm các màu sắc khác nếu cần
                ];
                foreach ($colors as $color) {
                    $color = trim($color);
                    $colorHex = isset($colorMapping[$color]) ? $colorMapping[$color] : '#ccc';
                    echo '<div class="color-box" style="background-color: ' . $colorHex . ';" title="' . htmlspecialchars($color) . '" onclick="selectColor(this, \'' . htmlspecialchars($color) . '\')"></div>';
                }
                ?>
                <span class="selected-color" id="selected-color-name">Chưa chọn</span>
            </div>
            <button class="add-to-cart-btn" data-product-id="<?php echo htmlspecialchars($product['product_id']); ?>" onclick="addToCart('<?php echo htmlspecialchars($product['product_id']); ?>')">Thêm vào giỏ hàng</button>
            <?php
        }
        ?>
    </div>
</div>

<script>
    function selectColor(element, colorName) {
        // Xóa lớp 'selected' khỏi tất cả các color-box
        const colorBoxes = document.querySelectorAll('.color-box');
        colorBoxes.forEach(box => box.classList.remove('selected'));

        // Thêm lớp 'selected' vào color-box được nhấp
        element.classList.add('selected');

        // Hiển thị tên màu đã chọn
        document.getElementById('selected-color-name').innerText = colorName;
    }

    function addToCart(productId) {
        // Lấy màu đã chọn
        const selectedColor = document.getElementById('selected-color-name').innerText;
        if (selectedColor === 'Chưa chọn') {
            alert('Vui lòng chọn màu trước khi thêm vào giỏ hàng.');
            return;
        }

        // Gửi yêu cầu thêm sản phẩm vào giỏ hàng
        fetch('../../controllers/cartController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=add&product_id=' + encodeURIComponent(productId) + '&color=' + encodeURIComponent(selectedColor)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Sản phẩm đã được thêm vào giỏ hàng!');
                    // Cập nhật giỏ hàng trên giao diện nếu cần
                } else {
                    alert('Lỗi: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đã xảy ra lỗi khi thêm vào giỏ hàng.');
            });
    }
</script>
</body>
</html>
