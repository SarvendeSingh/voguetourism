<?php
require_once '../dbc.php';
require_once '../admin/includes/functions.php';

// Initialize response array
$response = [
    'success' => false,
    'message' => ''
];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Connect to database
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Get and sanitize form data
        $name = isset($_POST['name']) ? sanitizeInput($_POST['name']) : '';
        $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : '';
        $message = isset($_POST['message']) ? sanitizeInput($_POST['message']) : '';
        $tourId = isset($_POST['tour_id']) ? (int)$_POST['tour_id'] : 0;
        $destinationId = isset($_POST['destination_id']) ? (int)$_POST['destination_id'] : 0;
        
        // Validate required fields
        if (empty($name) || empty($email) || empty($phone)) {
            throw new Exception("Please fill in all required fields.");
        }
        
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Please enter a valid email address.");
        }
        
        // If tour_id is provided but destination_id is not, get the destination_id from the tour
        if ($tourId > 0 && $destinationId == 0) {
            $stmt = $conn->prepare("SELECT destination_id FROM tours WHERE id = ?");
            $stmt->execute([$tourId]);
            $destinationId = $stmt->fetchColumn();
        }
        
        // Insert inquiry into database
        $stmt = $conn->prepare("INSERT INTO inquiries (name, email, phone, message, tour_id, destination_id, created_at) 
                              VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $phone, $message, $tourId ?: null, $destinationId ?: null]);
        
        // Set success response
        $response['success'] = true;
        $response['message'] = "Thank you for your inquiry! We will contact you shortly.";
        
    } catch (Exception $e) {
        // Set error response
        $response['message'] = $e->getMessage();
    }
}

// Determine if this is an AJAX request
$isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

if ($isAjax) {
    // Return JSON response for AJAX requests
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
} else {
    // For non-AJAX requests, set session message and redirect
    session_start();
    
    if ($response['success']) {
        $_SESSION['success_message'] = $response['message'];
    } else {
        $_SESSION['error_message'] = $response['message'] ?: 'An error occurred. Please try again.';
    }
    
    // Redirect back to the referring page or to the home page
    $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';
    header("Location: $redirect");
    exit;
}