<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>review</title>
</head>
<body>

<div id="reviewResults">
    <h3>Review:</h3>
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
</body>
</html>