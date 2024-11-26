<?php
include 'db.php'; // Include the database connection

// Set response to JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $field = $_POST['field'] ?? '';
    $value = $_POST['value'] ?? '';

    // Allowed fields to validate
    $allowedFields = ['phone', 'email', 'linkedin'];

    // Check if the provided field is valid
    if (!in_array($field, $allowedFields)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid field.']);
        exit;
    }

    try {
        // Check for duplicate entries in the database
        $stmt = $conn->prepare("SELECT COUNT(*) FROM profiles WHERE $field = ?");
        $stmt->execute([$value]);
        $exists = $stmt->fetchColumn();

        if ($exists > 0) {
            // Field already exists
            echo json_encode(['status' => 'error', 'message' => ucfirst($field) . ' already exists.']);
        } else {
            // Field is unique
            echo json_encode(['status' => 'success', 'message' => ucfirst($field) . ' is valid.']);
        }
    } catch (PDOException $e) {
        // Handle database errors gracefully
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // Handle invalid request methods
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
