<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
include_once "../../configs/database.php";
$conn = database();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $reviewerName = $_POST['reviewer_name'];
    $rating = $_POST['rating'];
    $comment = $_POST['review_text'];

    // Validate the inputs
    if (empty($productId) || empty($reviewerName) || empty($rating) || empty($comment)) {
        echo json_encode(['success' => false, 'error' => 'All fields are required.']);
        exit;
    }

    // Insert into the database
    $sql = "INSERT INTO Review (product_id, reviewer_name, rating, comment, created_at) VALUES (:product_id, :reviewer_name, :rating, :comment, NOW())";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->bindParam(':product_id', $productId);
        $stmt->bindParam(':reviewer_name', $reviewerName);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':comment', $comment);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Database error.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
