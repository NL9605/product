<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List_Product</title>
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
            display: grid;
            grid-template-columns: repeat(5, 1fr); /* 5 cột mỗi hàng */
            gap: 20px; /* Khoảng cách giữa các sản phẩm */
            margin: 20px auto 0 auto;
            padding: 20px;
        }

        .product-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%; /* Chiếm toàn bộ chiều rộng của cột lưới */
            height: auto;
            overflow: hidden;
            position: relative;
            text-align: center;
            padding: 10px;
            margin: 0;
            transition: transform 0.3s ease;
            cursor: pointer;
            box-sizing: border-box; /* Bao gồm padding và border trong width */
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

        /* Modal styles (giữ nguyên) */
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
            cursor: pointer;
        }

        .thumbnails button:hover {
            border-color: #354B59;
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

        /* Thêm style cho phân trang */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 0 5px;
        }

        .pagination a {
            display: block;
            padding: 8px 12px;
            text-decoration: none;
            color: #354B59;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .pagination a.active {
            background-color: #354B59;
            color: white;
            border-color: #354B59;
        }

        .pagination a:hover:not(.active) {
            background-color: #f0f0f0;
        }
        .filter-container {
            margin-bottom: 20px;
        }

        .filter-container h3 {
            margin: 10px 0 5px;
        }

        #filters {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }


        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .product-container {
                grid-template-columns: repeat(4, 1fr); /* 4 cột mỗi hàng */
            }
        }

        @media (max-width: 992px) {
            .product-container {
                grid-template-columns: repeat(3, 1fr); /* 3 cột mỗi hàng */
            }
        }

        @media (max-width: 768px) {
            .product-container {
                grid-template-columns: repeat(2, 1fr); /* 2 cột mỗi hàng */
            }
        }

        @media (max-width: 576px) {
            .product-container {
                grid-template-columns: 1fr; /* 1 cột mỗi hàng */
            }
        }

    </style>
</head>
<body>
<div id="filter-container" class="filter-container">
    <button id="toggle-filter-btn">Show Filter</button>
    <div id="filters" style="display: none;">
        <h3>Filter by Category</h3>
        <select id="category-filter">
            <option value="">All Categories</option>
            <option value="category1">Category 1</option>
            <option value="category2">Category 2</option>
        </select>

        <h3>Filter by Color</h3>
        <select id="color-filter">
            <option value="">All Colors</option>
            <option value="red">Red</option>
            <option value="blue">Blue</option>
        </select>

        <h3>Filter by Size</h3>
        <select id="size-filter">
            <option value="">All Sizes</option>
            <option value="s">Small</option>
            <option value="m">Medium</option>
            <option value="l">Large</option>
        </select>

        <h3>Filter by Price</h3>
        <input type="number" id="min-price" placeholder="Min Price" />
        <input type="number" id="max-price" placeholder="Max Price" />

        <button id="apply-filters">Apply Filters</button>
    </div>
</div>
<script>
    document.getElementById('toggle-filter-btn').addEventListener('click', function() {
        const filters = document.getElementById('filters');
        const isVisible = filters.style.display === 'block';

        // Hiển thị hoặc ẩn bộ lọc
        filters.style.display = isVisible ? 'none' : 'block';
        this.textContent = isVisible ? 'Show Filter' : 'Hide Filter';
    });

    document.getElementById('apply-filters').addEventListener('click', function() {
        const category = document.getElementById('category-filter').value;
        const color = document.getElementById('color-filter').value;
        const size = document.getElementById('size-filter').value;
        const minPrice = parseFloat(document.getElementById('min-price').value) || 0;
        const maxPrice = parseFloat(document.getElementById('max-price').value) || Infinity;

        // Lọc sản phẩm dựa trên các tiêu chí đã chọn
        filterProducts(category, color, size, minPrice, maxPrice);
    });

    function filterProducts(category, color, size, minPrice, maxPrice) {
        // Giả sử bạn có một danh sách các sản phẩm trong một mảng
        const products = [
            // Cấu trúc sản phẩm ví dụ
            { name: 'Product 1', category: 'category1', color: 'red', size: 'm', price: 100 },
            { name: 'Product 2', category: 'category2', color: 'blue', size: 'l', price: 200 },
            // Thêm nhiều sản phẩm khác
        ];

        const filteredProducts = products.filter(product => {
            return (
                (category === '' || product.category === category) &&
                (color === '' || product.color === color) &&
                (size === '' || product.size === size) &&
                (product.price >= minPrice && product.price <= maxPrice)
            );
        });

        // Hiển thị sản phẩm đã lọc
        displayProducts(filteredProducts);
    }

    function displayProducts(products) {
        // Gọi hàm để hiển thị sản phẩm trong giao diện người dùng
        console.log(products); // Ví dụ đơn giản là in ra console
    }

</script>
<h1 style="text-align: center;">Product</h1>
<div class="product-container">
    <?php foreach ($products as $product): ?>
        <div class="product-card">
            <div class="product-images">
                <?php
                $productId = isset($product['product_id']) ? htmlspecialchars($product['product_id']) : '#';
                $productName = isset($product['product_name']) ? htmlspecialchars($product['product_name']) : 'Tên sản phẩm không có';
                $imageUrls = !empty($product['image']) ? explode(',', htmlspecialchars($product['image'])) : [];
                ?>
                <?php if (!empty($imageUrls) && count($imageUrls) > 0): ?>
                    <a href="http://localhost/Fanimation/shop/views/product/product_detail.php?id=<?php echo $productId; ?>">
                        <img src="http://localhost/Fanimation/shop/<?php echo htmlspecialchars(trim($imageUrls[0])); ?>"
                             alt="<?php echo htmlspecialchars($productName . ' - Hình ảnh sản phẩm'); ?>"
                             onerror="this.onerror=null; this.src='http://localhost/Fanimation/app/uploads/default-image.jpg';"
                             data-hover-image="http://localhost/Fanimation/shop/<?php echo htmlspecialchars(trim($imageUrls[1] ?? '../../../app/uploads/default-image.jpg')); ?>">
                    </a>
                <?php else: ?>
                    <img src="http://localhost/Fanimation/app/uploads/default-image.jpg" alt="Hình ảnh không có"
                         onerror="this.onerror=null; this.src='http://localhost/Fanimation/app/uploads/default-image.jpg';">
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



<!-- Modal -->
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
            <p id="modal-product-discount-price"></p>
            <div id="modal-product-color" class="color-boxes"></div>
            <div class="color-name" id="selected-color-name"></div>
            <button class="add-to-cart-btn">Add to cart</button>
            <div id="cart-message" style="color: green; margin-top: 10px; display: none;"></div>

        </div>

    </div>
</div>
<?php if ($totalPages > 1): ?>
    <ul class="pagination">
        <?php if ($currentPage > 1): ?>
            <li><a href="?page=<?php echo $currentPage - 1; ?>">&laquo; Previous</a></li>
        <?php endif; ?>
        <?php
        // Xác định số trang hiển thị
        $maxLinks = 5;
        $start = max($currentPage - floor($maxLinks / 2), 1);
        $end = min($start + $maxLinks - 1, $totalPages);
        if ($end - $start + 1 < $maxLinks) {
            $start = max($end - $maxLinks + 1, 1);
        }

        for ($i = $start; $i <= $end; $i++): ?>
            <li><a href="?page=<?php echo $i; ?>" class="<?php echo ($i === $currentPage) ? 'active' : ''; ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>
        <?php if ($currentPage < $totalPages): ?>
            <li><a href="?page=<?php echo $currentPage + 1; ?>">Next &raquo;</a></li>
        <?php endif; ?>
    </ul>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Hover effect for product images
        document.querySelectorAll('.product-card img').forEach((img) => {
            const originalSrc = img.src;
            const hoverSrc = img.getAttribute('data-hover-image');

            img.addEventListener('mouseenter', () => {
                if (hoverSrc) {
                    img.src = hoverSrc;
                }
            });

            img.addEventListener('mouseleave', () => {
                img.src = originalSrc;
            });
        });

        // Quick View Modal
        const modal = document.getElementById('quick-view-modal');
        const closeModal = document.querySelector('.close');
        const modalProductName = document.getElementById('modal-product-name');
        const modalProductDescription = document.getElementById('modal-product-description');
        const modalProductPrice = document.getElementById('modal-product-price');
        const modalProductDiscountPrice = document.getElementById('modal-product-discount-price');
        const modalProductImage = document.getElementById('modal-product-image');
        const modalProductColors = document.getElementById('modal-product-color');
        const selectedColorName = document.getElementById('selected-color-name');
        const thumbnailsContainer = document.getElementById('image-thumbnails');
        const cartMessage = document.getElementById('cart-message');

        let selectedColor = null; // Variable to store selected color

        // Handle "Quick View" button click
        document.querySelectorAll('.quick-view').forEach((quickView) => {
            quickView.addEventListener('click', () => {
                const productName = quickView.getAttribute('data-name');
                const productDescription = quickView.getAttribute('data-description');
                const productPrice = parseFloat(quickView.getAttribute('data-price'));
                const productDiscount = parseFloat(quickView.getAttribute('data-discount')) || 0;
                const imageUrls = quickView.getAttribute('data-image').split(',');

                // Debug: Check image URLs
                console.log("Image URLs: ", imageUrls);

                // Update modal content
                modalProductName.textContent = productName;
                modalProductDescription.innerHTML = productDescription;

                // Set product price
                modalProductPrice.textContent = `Giá: ${productPrice.toLocaleString()} $`;
                modalProductDiscountPrice.textContent = productDiscount ? `Giá khuyến mãi: ${productDiscount.toLocaleString()} $` : '';

                // Set the main product image and thumbnails
                modalProductImage.src = `http://localhost/Fanimation/shop/${imageUrls[0]}`;
                thumbnailsContainer.innerHTML = ''; // Clear previous thumbnails

                imageUrls.forEach((url, index) => {
                    const thumbnail = document.createElement('img');
                    thumbnail.src = `http://localhost/Fanimation/shop/${url}`;
                    thumbnail.className = 'thumbnail-image';
                    thumbnail.style.width = '50px';
                    thumbnail.style.height = '50px';
                    thumbnail.style.margin = '5px';

                    thumbnail.addEventListener('click', () => {
                        modalProductImage.src = `http://localhost/Fanimation/shop/${url}`;
                    });

                    thumbnailsContainer.appendChild(thumbnail);
                });

                // Handle colors (if any)
                const colors = quickView.getAttribute('data-colors') ? quickView.getAttribute('data-colors').split(',') : [];
                modalProductColors.innerHTML = '';
                selectedColor = null;

                if (colors.length > 0) {
                    colors.forEach((color) => {
                        const colorBox = document.createElement('div');
                        colorBox.className = 'color-box';
                        colorBox.style.backgroundColor = color;

                        colorBox.addEventListener('click', () => {
                            selectedColor = color;
                            selectedColorName.textContent = `Màu đã chọn: ${color}`;
                        });

                        modalProductColors.appendChild(colorBox);
                    });
                    selectedColorName.textContent = 'Chọn màu:';
                } else {
                    selectedColorName.textContent = 'Sản phẩm này không có màu.';
                }

                // Display the modal
                modal.style.display = 'block';

                // Handle Add to Cart
                const productId = quickView.getAttribute('data-product-id');
                const addToCartBtn = document.querySelector('.add-to-cart-btn');
                addToCartBtn.onclick = () => {
                    if (colors.length > 0 && !selectedColor) {
                        alert('Vui lòng chọn màu trước khi thêm vào giỏ hàng!');
                        return;
                    }

                    addToCart(productId, productName, productDiscount || productPrice, selectedColor);
                };
            });
        });

        // Close modal on clicking "X" or outside modal
        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Add product to cart
        function addToCart(productId, productName, productPrice, selectedColor) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const existingProductIndex = cart.findIndex(item => item.id === productId && item.color === selectedColor);

            if (existingProductIndex !== -1) {
                cart[existingProductIndex].quantity += 1;
            } else {
                cart.push({ id: productId, name: productName, price: productPrice, color: selectedColor || 'Không màu', quantity: 1 });
            }

            localStorage.setItem('cart', JSON.stringify(cart));

            cartMessage.textContent = `${productName} ${selectedColor ? `màu ${selectedColor}` : 'không có màu'} đã được thêm vào giỏ hàng!`;
            cartMessage.style.display = 'block';

            setTimeout(() => {
                cartMessage.style.display = 'none';
            }, 3000);
        }
    });

</script>

</body>
</html>
