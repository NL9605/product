<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="./assets/css/product.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0 70px;
            padding-bottom: 100px;
            background-color: white;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 20px;
            margin: 20px auto 0 auto;
            padding: 20px;
        }

        .product-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: calc(20% - 16px);
            height: auto;
            overflow: hidden;
            position: relative;
            text-align: center;
            padding: 10px;
            margin: 0;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-10px);
        }

        .product-images {
            position: relative;
            width: 100%;
            height: 270px;
            margin-bottom: 10px;
        }

        .product-images img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .quick-view {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 40px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            text-align: center;
            line-height: 40px;
            font-size: 16px;
            opacity: 0;
            transition: opacity 0.4s ease, transform 0.4s ease;
            transform: translateX(-100%);
        }

        .product-card:hover .quick-view {
            opacity: 1;
            transform: translateX(0);
        }

        h2 {
            font-size: 1.1rem;
            margin: 5px 0;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .price {
            font-size: 1rem;
            color: #666;
            margin-bottom: 10px;
        }

        /* Modal styles */
        .modal {
            display: none; /* Bắt đầu với trạng thái ẩn */
            position: fixed; /* Đảm bảo modal luôn cố định trên màn hình */
            z-index: 1000; /* Đảm bảo modal hiển thị trên tất cả các nội dung khác */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Làm tối phần nền */
            overflow: auto; /* Đảm bảo nội dung modal có thể cuộn nếu vượt quá chiều cao màn hình */
        }

        .modal-content {
            display: flex;
            flex-direction: row;
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 1200px;
            height: auto;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding-right: 30px;
        }

        #modal-product-image {
            width: 100%;
            max-width: 500px;
            height: auto;
        }

        .modal-right {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        #modal-product-name {
            font-size: 2rem;
            margin-bottom: 15px;
        }

        #modal-product-description {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        #modal-product-price {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 30px;
        }

        .color-box {
            display: inline-block;
            width: 40px;
            height: 40px;
            margin-right: 10px;
            border-radius: 50%;
            border: 1px solid #ccc;
        }

        .color-name {
            font-size: 1rem;
            margin-top: 10px;
        }

        .thumbnails {
            display: flex;
            flex-direction: row;
            margin-top: 15px;
            overflow-x: auto;
        }

        .thumbnails button {
            border: 2px solid transparent;
            border-radius: 5px;
            transition: border-color 0.3s ease;
            width: 80px;
            height: 80px;
            margin-right: 5px;
            background-size: cover;
            background-position: center;
            background-color: #f0f0f0;
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
            margin-top: 20px;
        }

        .add-to-cart-btn:hover {
            background-color: #133447;
            transform: scale(1.05);
        }

        .add-to-cart-btn:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
<h1 style="text-align: center;">Product</h1>
<div class="product-container">
    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <div class="product-images">
                <?php
                $productId = isset($product['product_id']) ? htmlspecialchars($product['product_id']) : '#';
                $productName = isset($product['product_name']) ? htmlspecialchars($product['product_name']) : 'Tên sản phẩm không có';
                $imageUrls = !empty($product['image_urls']) ? explode(',', htmlspecialchars($product['image_urls'])) : [];
                ?>
                <?php if (!empty($imageUrls) && count($imageUrls) > 0): ?>
                    <a href="http://localhost/Fanimation/shop/views/product/product_detail.php?id=<?php echo $productId; ?>">
                        <img src="<?php echo htmlspecialchars(trim($imageUrls[0])); ?>"
                             alt="<?php echo htmlspecialchars($productName . ' - Hình ảnh sản phẩm'); ?>"
                             onerror="this.onerror=null; this.src='../../app/uploads/default-image.jpg';"
                             data-hover-image="<?php echo htmlspecialchars(trim($imageUrls[1] ?? '../../app/uploads/default-image.jpg')); ?>">
                    </a>
                <?php else: ?>
                    <img src="../../app/uploads/default-image.jpg" alt="Hình ảnh không có"
                         onerror="this.onerror=null; this.src='../../app/uploads/default-image.jpg';">
                <?php endif; ?>
                <span class="quick-view"
                      data-name="<?php echo htmlspecialchars($productName); ?>"
                      data-description="<?php
                      $dataDescription = isset($product['description']) ? htmlspecialchars($product['description']) : 'Mô tả không có';
                      $lines = explode("\n", $dataDescription);
                      $formattedDescription = "";
                      foreach ($lines as $line) {
                          $formattedDescription .= '• ' . trim($line) . '<br>';
                      }
                      echo $formattedDescription;
                      ?>"
                      data-price="<?php echo number_format($product['price'], 0, ',', '.'); ?> $"
                      data-colors="<?php echo isset($product['colors']) ? htmlspecialchars($product['colors']) : ''; ?>"
                      data-image="<?php echo htmlspecialchars(implode(',', $imageUrls)); ?>"
                      data-product-id="<?php echo htmlspecialchars($productId); ?>">
                    Quick View
                </span>
            </div>
            <h2><?php echo $productName; ?></h2>
            <p class="price"><?php echo number_format($product['price'], 0, ',', '.'); ?> $</p>
        </div>
    <?php endforeach; ?>
</div>

<div id="quick-view-modal" class="modal" style="display:none;">

    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-left">
            <img id="modal-product-image" src="" alt="Product Image" />
            <div id="image-thumbnails" class="thumbnails"></div>
        </div>

        <div class="modal-right">
            <h2 id="modal-product-name"></h2>
            <p id="modal-product-description"></p>
            <p id="modal-product-price"></p>
            <div id="modal-product-color" class="color-boxes"></div>
            <div class="color-name" id="selected-color-name"></div>
            <button class="add-to-cart-btn">Thêm vào giỏ hàng</button>
        </div>

    </div>
</div>


<script>
    document.querySelectorAll('.product-card img').forEach((img) => {
        const originalSrc = img.src;
        const hoverSrc = img.getAttribute('data-hover-image');

        img.addEventListener('mouseenter', () => {
            img.src = hoverSrc;
        });

        img.addEventListener('mouseleave', () => {
            img.src = originalSrc;
        });
    });

    const modal = document.getElementById('quick-view-modal');
    const closeModal = document.querySelector('.close');
    const modalProductName = document.getElementById('modal-product-name');
    const modalProductDescription = document.getElementById('modal-product-description');
    const modalProductPrice = document.getElementById('modal-product-price');
    const modalProductImage = document.getElementById('modal-product-image');
    const modalProductColors = document.getElementById('modal-product-color');
    const selectedColorName = document.getElementById('selected-color-name');
    const thumbnailsContainer = document.getElementById('image-thumbnails');

    document.querySelectorAll('.quick-view').forEach((quickView) => {
        quickView.addEventListener('click', () => {
            modalProductName.textContent = quickView.getAttribute('data-name');
            modalProductDescription.innerHTML = quickView.getAttribute('data-description');
            modalProductPrice.textContent = quickView.getAttribute('data-price');
            const imageUrls = quickView.getAttribute('data-image').split(',');
            modalProductImage.src = imageUrls[0];

            thumbnailsContainer.innerHTML = '';
            imageUrls.forEach((url) => {
                const button = document.createElement('button');
                button.style.backgroundImage = `url(${url})`;
                button.addEventListener('click', () => {
                    modalProductImage.src = url;
                });
                thumbnailsContainer.appendChild(button);
            });

            const colors = quickView.getAttribute('data-colors').split(',');
            modalProductColors.innerHTML = '';
            colors.forEach((color) => {
                const colorBox = document.createElement('div');
                colorBox.className = 'color-box';
                colorBox.style.backgroundColor = color;
                modalProductColors.appendChild(colorBox);
            });

            selectedColorName.textContent = colors.length > 0 ? 'Màu sắc đã chọn' : 'Không có màu sắc nào';
            modal.style.display = 'block';
        });
    });

    closeModal.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });

</script>
</body>
</html>
