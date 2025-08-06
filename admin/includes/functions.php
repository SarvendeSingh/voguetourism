<?php
// Database helper functions

/**
 * Get all categories
 */
function getCategories($conn) {
    $stmt = $conn->prepare("SELECT * FROM categories ORDER BY name");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all destinations
 */
function getDestinations($conn) {
    $stmt = $conn->prepare("SELECT d.*, c.name as category_name 
                          FROM destinations d 
                          JOIN categories c ON d.category_id = c.id 
                          ORDER BY d.name");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get destinations by category
 */
function getDestinationsByCategory($conn, $categoryId) {
    $stmt = $conn->prepare("SELECT * FROM destinations WHERE category_id = ? ORDER BY name");
    $stmt->execute([$categoryId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get single destination
 */
function getDestination($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM destinations WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Get all tours
 */
function getTours($conn) {
    $stmt = $conn->prepare("SELECT t.*, d.name as destination_name, c.name as category_name 
                          FROM tours t 
                          JOIN destinations d ON t.destination_id = d.id 
                          JOIN categories c ON d.category_id = c.id 
                          ORDER BY t.created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get tours by destination
 */
function getToursByDestination($conn, $destinationId) {
    $stmt = $conn->prepare("SELECT * FROM tours WHERE destination_id = ? ORDER BY title");
    $stmt->execute([$destinationId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get tours by category
 */
function getToursByCategory($conn, $categoryId) {
    $stmt = $conn->prepare("SELECT t.*, d.name as destination_name 
                          FROM tours t 
                          JOIN destinations d ON t.destination_id = d.id 
                          WHERE d.category_id = ? 
                          ORDER BY t.created_at DESC");
    $stmt->execute([$categoryId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get single tour
 */
function getTour($conn, $id) {
    $stmt = $conn->prepare("SELECT t.*, d.name as destination_name, d.category_id 
                          FROM tours t 
                          JOIN destinations d ON t.destination_id = d.id 
                          WHERE t.id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Get all inquiries
 */
function getInquiries($conn) {
    $stmt = $conn->prepare("SELECT i.*, d.name as destination_name, t.title as tour_name 
                          FROM inquiries i 
                          LEFT JOIN destinations d ON i.destination_id = d.id 
                          LEFT JOIN tours t ON i.tour_id = t.id 
                          ORDER BY i.created_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get counts for dashboard
 */
function getDashboardCounts($conn) {
    $counts = [];
    
    // Count destinations
    $stmt = $conn->prepare("SELECT COUNT(*) FROM destinations");
    $stmt->execute();
    $counts['destinations'] = $stmt->fetchColumn();
    
    // Count tours
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tours");
    $stmt->execute();
    $counts['tours'] = $stmt->fetchColumn();
    
    // Count inquiries
    $stmt = $conn->prepare("SELECT COUNT(*) FROM inquiries");
    $stmt->execute();
    $counts['inquiries'] = $stmt->fetchColumn();
    
    // Count by category
    $stmt = $conn->prepare("SELECT c.name, COUNT(d.id) as count 
                          FROM categories c 
                          LEFT JOIN destinations d ON c.id = d.category_id 
                          GROUP BY c.id");
    $stmt->execute();
    $counts['by_category'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $counts;
}

/**
 * Upload image
 */
function uploadImage($file) {
    $target_dir = dirname(dirname(__DIR__)) . "/uploads/tours/";
    $fileName = basename($file["name"]);
    $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    // Generate unique filename
    $uniqueName = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $uniqueName;
    
    // Check if image file is a actual image
    $check = getimagesize($file["tmp_name"]);
    if($check === false) {
        return ["success" => false, "message" => "File is not an image."];
    }
    
    // Check file size (limit to 5MB)
    if ($file["size"] > 5000000) {
        return ["success" => false, "message" => "File is too large. Max 5MB allowed."];
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        return ["success" => false, "message" => "Only JPG, JPEG, PNG & GIF files are allowed."];
    }
    
    // Upload file
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return ["success" => true, "file_name" => $uniqueName];
    } else {
        return ["success" => false, "message" => "There was an error uploading your file."];
    }
}

/**
 * Format price
 */
function formatPrice($price) {
    return '₹' . number_format($price, 2);
}

/**
 * Sanitize input
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Get category name by ID
 */
function getCategoryName($conn, $id) {
    $stmt = $conn->prepare("SELECT name FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}

/**
 * Get destination name by ID
 */
function getDestinationName($conn, $id) {
    $stmt = $conn->prepare("SELECT name FROM destinations WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}

/**
 * =============================================
 * === NEW FUNCTION TO FIX THE FATAL ERROR ===
 * =============================================
 * Create a URL-friendly "slug" from a string.
 */
function create_slug($string){
   $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($string));
   return trim($slug, '-');
}

?>