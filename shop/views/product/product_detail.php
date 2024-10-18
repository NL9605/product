<?php

use models\ProductModel;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
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
        .tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        /* Style for the tab buttons */
        .tablinks {
            background-color: transparent;
            border: none;
            outline: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            color: #555;
            position: relative;
        }

        /* ::after pseudo-element for the underline */
        .tablinks::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px; /* Adjust for desired spacing from the text */
            width: 0;
            height: 2px;
            background-color: #000;
            transition: width 0.4s ease; /* Smooth transition effect */
        }

        /* Hover effect: slide underline in from left to right */
        .tablinks:hover::after {
            width: 100%;
        }

        /* Active tab will have the full underline */
        .tablinks.active::after {
            width: 100%;
        }

        /* Tab content style */
        .tabcontent {
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content horizontally */
            padding: 20px; /* Add some padding */
            width: 100%; /* Ensure it takes full width */
            box-sizing: border-box; /* Include padding in width calculation */
        }

        .document-item {
            display: flex;
            flex-direction: column;
            align-items: center; /* Center items inside the document item */
            text-align: center; /* Center text */
            margin: 20px; /* Space between items */
        }

        .document-item img {
            width: 80px; /* Set a fixed width for icons */
            height: auto; /* Maintain aspect ratio */
            margin-bottom: 10px; /* Space between icon and text */
        }

        h3 {
            margin-bottom: 20px; /* Space below the title */
        }
        /* Style for each document item */
        /* Document titles */
        .document-item p {
            font-size: 16px;
            color: #555;
        }
        .star {
            cursor: pointer;
            font-size: 1.5rem;
            color: #ccc;
        }

        .star.selected {
            color: #FFD700;
        }

        #reviewResults {
            margin-top: 20px;
        }

        .review {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
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
                echo "<p>Product not identified.</p>";
                exit;
            }

            // Kết nối cơ sở dữ liệu và lấy thông tin sản phẩm
            include_once "../../configs/database.php";
            include_once "../../models/ProductModel.php";

            $conn = database();
            $productModel = new ProductModel($conn);
            $product = $productModel->getProductById($productId);

            if ($product) {
                $imageUrls = !empty($product['image']) ? explode(',', $product['image']) : [];
                if (!empty($imageUrls)) {
                    // Đường dẫn ảnh chính
                    $mainImage = '../../' . htmlspecialchars(trim($imageUrls[0]));
                    ?>
                    <img id="main-image" src="<?php echo $mainImage; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                         onerror="this.onerror=null; this.src='../../uploads/default-image.jpg';">
                    <?php if (count($imageUrls) > 1): ?>
                        <div class="thumbnails">
                            <?php
                            foreach ($imageUrls as $image) {
                                $thumbnailPath = '../../' . htmlspecialchars(trim($image));
                                ?>
                                <img src="<?php echo $thumbnailPath; ?>" alt="Thumbnail"
                                     onerror="this.onerror=null; this.src='../../uploads/default-image.jpg';"
                                     onclick="document.getElementById('main-image').src='<?php echo $thumbnailPath; ?>'">
                                <?php
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php
                } else {
                    ?>
                    <img id="main-image" src="../../uploads/default-image.jpg" alt="No Image"
                         onerror="this.onerror=null; this.src='../../uploads/default-image.jpg';">
                    <?php
                }
            } else {
                echo "<p>Product not found.</p>";
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
                <span>Select color:</span>
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
                <span class="selected-color" id="selected-color-name">Not selected</span>
            </div>
            <button class="add-to-cart-btn" data-product-id="<?php echo htmlspecialchars($product['product_id']); ?>" onclick="addToCart('<?php echo htmlspecialchars($product['product_id']); ?>')">Add to cart</button>
            <?php
        }
        ?>
    </div>
</div>
<div class="tabs">
    <button class="tablinks" onclick="openTab(event, 'Review')" id="defaultOpen">REVIEW</button>
    <button class="tablinks" onclick="openTab(event, 'AdditionalInfo')">ADDITIONAL INFORMATION</button>
    <button class="tablinks" onclick="openTab(event, 'SupportDocs')">SUPPORT DOCUMENTS</button>
</div>

<div id="Review" class="tabcontent">
    <h3>Review</h3>
    <div id="reviewResults">
        <form id="reviewForm" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
            <label for="reviewer_name">Reviewer name:</label>
            <input type="text" name="reviewer_name" required>
            <br>
            <label for="rating">Review:</label>
            <div id="rating" class="rating">
                <span class="star" data-value="1" onclick="selectStar(this)">★</span>
                <span class="star" data-value="2" onclick="selectStar(this)">★</span>
                <span class="star" data-value="3" onclick="selectStar(this)">★</span>
                <span class="star" data-value="4" onclick="selectStar(this)">★</span>
                <span class="star" data-value="5" onclick="selectStar(this)">★</span>
            </div>
            <input type="hidden" name="rating" required>

            <label for="review_text">Comment:</label>
            <textarea name="review_text" rows="4" required></textarea>

            <button type="submit">Submit review</button>
        </form>

        <!-- Hiển thị các đánh giá từ cơ sở dữ liệu -->
        <div id="existingReviews">
            <?php
            // Truy vấn các đánh giá từ cơ sở dữ liệu
            $reviewSql = "SELECT reviewer_name, rating, comment, created_at FROM Review WHERE product_id = :product_id";
            $stmt = $conn->prepare($reviewSql);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($reviews) {
                foreach ($reviews as $review) {
                    echo "<div class='review'>";
                    echo "<h4>" . htmlspecialchars($review['reviewer_name']) . " - " . htmlspecialchars($review['rating']) . " Star</h4>";
                    echo "<p>" . nl2br(htmlspecialchars($review['comment'])) . "</p>";
                    echo "<small>Date: " . date('d-m-Y H:i', strtotime($review['created_at'])) . "</small>";
                    echo "</div>";
                }
            } else {
                echo "<p>No reviews yet.</p>";
            }
            ?>
        </div>
        <script>
            function selectStar(element) {
                const stars = document.querySelectorAll('.star');
                const ratingInput = document.querySelector('input[name="rating"]');
                const value = element.getAttribute('data-value');

                // Xóa class "selected" của tất cả các sao
                stars.forEach(star => star.classList.remove('selected'));

                // Gán class "selected" cho các sao tương ứng với đánh giá
                for (let i = 0; i < value; i++) {
                    stars[i].classList.add('selected');
                }

                // Cập nhật giá trị sao vào input ẩn
                ratingInput.value = value;
            }

            document.getElementById('reviewForm').addEventListener('submit', function (event) {
                event.preventDefault();

                const formData = new FormData(this);

                fetch('../../controllers/ReviewController.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json()) // Khẳng định phản hồi là JSON
                    .then(data => {
                        if (data.success) {
                            // Hiển thị đánh giá mới
                            const newReview = `
                    <div class='review'>
                        <h4>${formData.get('reviewer_name')} - ${formData.get('rating')} Star</h4>
                        <p>${formData.get('review_text')}</p>
                        <small>Ngày: ${new Date().toLocaleString()}</small>
                    </div>
                `;
                            document.getElementById('reviewResults').insertAdjacentHTML('afterbegin', newReview);
                            document.getElementById('reviewForm').reset();
                            alert('Review submitted successfully!');
                        } else {
                            alert(data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Response is not JSON:', error);
                        alert('An error occurred. Please try again.');
                    });
            });

        </script>

    </div>

</div>

<div id="AdditionalInfo" class="tabcontent" style="display:none;">
    <h3>Additional Information</h3>
    <p>Here is the additional information about the product.</p>
</div>

<div id="SupportDocs" class="tabcontent" style="display:none;">
    <div class="document-item">
        <a href="https://fanimation.com/wp-content/uploads/2024/01/FP6807-Barlow_ENG-SPA-OM_01_09_24.pdf" target="_blank"> <!-- Link to the Owner's Manual -->
            <img src="https://fanimation.com/wp-content/uploads/2020/02/document.png" alt="Owner's Manual" />
            <p>Owner's Manual</p>
        </a>
    </div>
    <div class="document-item">
        <a href="https://fanimation.com/wp-content/uploads/2023/01/FP8406BL_SS.pdf" target="_blank"> <!-- Link to the Specification Sheet -->
            <img src="https://fanimation.com/wp-content/uploads/2020/02/document.png" alt="Specification Sheet" />
            <p>Specification Sheet</p>
        </a>
    </div>
</div>



<script>
    function openTab(evt, tabName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // Open the default tab on page load
    document.getElementById("defaultOpen").click();

</script>


</body>
</html>
