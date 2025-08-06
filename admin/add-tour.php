<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get destinations for the dropdown
    $destinations = getDestinations($conn);
    
    // Process form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate basic input
        $destination_id = (int)$_POST['destination_id'];
        $title = sanitizeInput($_POST['title']);
        $duration = sanitizeInput($_POST['duration']);
        $price = (float)$_POST['price'];
        
        // Get content from the new rich text editor fields
        $whats_included = $_POST['whats_included'];
        $overview = $_POST['overview'];
        $activities = $_POST['activities'];
        $itinerary = $_POST['itinerary'];
        $exclusions = $_POST['exclusions'];
        
        // Use the old description field for the new overview field by default if it's empty
        // This helps with initial data entry if you choose to just use the big description field first.
        $description = $overview; 

        if (empty($title) || $price <= 0 || $destination_id <= 0) {
            $error = "Destination, Title, and a valid Price are required.";
        } else {
            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $uploadResult = uploadImage($_FILES['image']);
                
                if ($uploadResult['success']) {
                    $image = $uploadResult['file_name'];
                    
                    // Insert all data, including new fields, into the database
                    $stmt = $conn->prepare(
                        "INSERT INTO tours (destination_id, title, description, image, duration, price, whats_included, overview, activities, itinerary, exclusions) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                    );
                    $stmt->execute([
                        $destination_id, $title, $description, $image, $duration, $price, 
                        $whats_included, $overview, $activities, $itinerary, $exclusions
                    ]);
                    
                    $success = "Tour added successfully!";
                } else {
                    $error = $uploadResult['message'];
                }
            } else {
                $error = "Please select an image for the tour.";
            }
        }
    }
    
} catch(PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>

<div class="card">
    <div class="card-header">
        <h5>Add New Tour</h5>
    </div>
    <div class="card-body">
        <?php if (isset($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
        <?php if (isset($success)): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>

        <form method="post" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Tour Title</label><input type="text" class="form-control" name="title" required></div>
                <div class="col-md-6 mb-3"><label class="form-label">Destination</label><select class="form-select" name="destination_id" required><option value="" selected disabled>Select a Destination...</option><?php foreach ($destinations as $dest): ?><option value="<?php echo $dest['id']; ?>"><?php echo htmlspecialchars($dest['name']) . " (" . htmlspecialchars($dest['category_name']) . ")"; ?></option><?php endforeach; ?></select></div>
                <div class="col-md-4 mb-3"><label class="form-label">Duration</label><input type="text" class="form-control" name="duration" placeholder="e.g., 7 Nights - 8 Days"></div>
                <div class="col-md-4 mb-3"><label class="form-label">Price (INR)</label><input type="number" step="0.01" class="form-control" name="price" required></div>
                <div class="col-md-4 mb-3"><label class="form-label">Tour Image</label><input type="file" class="form-control" name="image" required></div>
            </div>

            <hr class="my-4">

            <div class="mb-3"><label class="form-label fw-bold">What's Included?</label><textarea name="whats_included" class="form-control wysiwyg"></textarea></div>
            <div class="mb-3"><label class="form-label fw-bold">Overview</label><textarea name="overview" class="form-control wysiwyg"></textarea></div>
            <div class="mb-3"><label class="form-label fw-bold">Activities</label><textarea name="activities" class="form-control wysiwyg"></textarea></div>
            <div class="mb-3"><label class="form-label fw-bold">Itinerary</label><textarea name="itinerary" class="form-control wysiwyg"></textarea></div>
            <div class="mb-3"><label class="form-label fw-bold">Exclusions</label><textarea name="exclusions" class="form-control wysiwyg"></textarea></div>

            <div class="mt-4"><button type="submit" class="btn btn-primary">Add Tour</button></div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>