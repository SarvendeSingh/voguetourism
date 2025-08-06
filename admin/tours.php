<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Delete tour
    if (isset($_GET['delete']) && !empty($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        
        // Get the image filename before deleting
        $stmt = $conn->prepare("SELECT image FROM tours WHERE id = ?");
        $stmt->execute([$id]);
        $imageFile = $stmt->fetchColumn();
        
        // Delete the tour
        $stmt = $conn->prepare("DELETE FROM tours WHERE id = ?");
        $stmt->execute([$id]);
        
        // Delete the image file if it exists
        if ($imageFile && file_exists("../uploads/tours/" . $imageFile)) {
            unlink("../uploads/tours/" . $imageFile);
        }
        
        $success = "Tour deleted successfully.";
    }
    
    // Filter by destination if specified
    $destinationFilter = null;
    $tours = [];
    
    if (isset($_GET['destination']) && !empty($_GET['destination'])) {
        $destinationFilter = (int)$_GET['destination'];
        $tours = getToursByDestination($conn, $destinationFilter);
        $destinationName = getDestinationName($conn, $destinationFilter);
    } else {
        $tours = getTours($conn);
    }
    
    // Get all categories for filtering
    $categories = getCategories($conn);
    
    // Filter by category if specified
    $categoryFilter = null;
    if (isset($_GET['category']) && !empty($_GET['category'])) {
        $categoryFilter = (int)$_GET['category'];
        $tours = getToursByCategory($conn, $categoryFilter);
    }
    
    // Get all destinations for the add tour form
    $destinations = getDestinations($conn);
    
} catch(PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>

<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <h5>
            <?php if ($destinationFilter): ?>
                Tours for <?php echo $destinationName; ?>
            <?php elseif ($categoryFilter): ?>
                Tours for <?php echo getCategoryName($conn, $categoryFilter); ?>
            <?php else: ?>
                All Tours
            <?php endif; ?>
        </h5>
        <div>
            <a href="add-tour.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Tour
            </a>
        </div>
    </div>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<?php if (isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-header">
        Filter Tours
    </div>
    <div class="card-body">
        <form method="get" action="" class="row g-3">
            <div class="col-md-5">
                <label for="category" class="form-label">By Category</label>
                <select class="form-select" id="category" name="category" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo ($categoryFilter == $category['id']) ? 'selected' : ''; ?>>
                            <?php echo $category['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-5">
                <label for="destination" class="form-label">By Destination</label>
                <select class="form-select" id="destination" name="destination" onchange="this.form.submit()">
                    <option value="">All Destinations</option>
                    <?php foreach ($destinations as $destination): ?>
                        <option value="<?php echo $destination['id']; ?>" <?php echo ($destinationFilter == $destination['id']) ? 'selected' : ''; ?>>
                            <?php echo $destination['name']; ?> (<?php echo $destination['category_name']; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-2 d-flex align-items-end">
                <a href="tours.php" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Tours List -->
<div class="card">
    <div class="card-header">
        Manage Tours
    </div>
    <div class="card-body">
        <?php if (empty($tours)): ?>
            <p class="text-center">No tours found. <?php echo !$destinationFilter ? 'Add your first tour.' : ''; ?></p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Destination</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tours as $tour): ?>
                        <tr>
                            <td><?php echo $tour['id']; ?></td>
                            <td>
                                <img src="../uploads/tours/<?php echo $tour['image']; ?>" alt="<?php echo $tour['title']; ?>" width="50" height="50" style="object-fit: cover;">
                            </td>
                            <td><?php echo $tour['title']; ?></td>
                            <td><?php echo isset($tour['destination_name']) ? $tour['destination_name'] : getDestinationName($conn, $tour['destination_id']); ?></td>
                            <td><?php echo $tour['duration']; ?></td>
                            <td><?php echo formatPrice($tour['price']); ?></td>
                            <td>
                                <a href="edit-tour.php?id=<?php echo $tour['id']; ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="tours.php?delete=<?php echo $tour['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this tour?')" data-bs-toggle="tooltip" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </a>
                                <a href="../our-tours/details.php?id=<?php echo $tour['id']; ?>" target="_blank" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>