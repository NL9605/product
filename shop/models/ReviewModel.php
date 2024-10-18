<?php

class ReviewModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addReview($productId, $reviewerName, $rating, $comment) {
        $query = "INSERT INTO Review (product_id, reviewer_name, rating, comment) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$productId, $reviewerName, $rating, $comment]);
    }
}
