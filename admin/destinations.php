<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Process form submission for adding/editing destination
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = sanitizeInput($_POST['name']);
        $category_id = (int)$_POST['category_id'];
        
        // Validate input
        if (empty($name) || $category_id <= 0) {
            $error = "Name and category are required.";
        } else {
            // Check if we're editing or adding
            if (isset($_POST['destination_id']) && !empty($_POST['destination_id'])) {
                // Update existing destination
                $stmt = $conn->prepare("UPDATE destinations SET name = ?, category_id = ? WHERE id = ?");
                $stmt->execute([$name, $category_id, $_POST['destination_id']]);
                $success = "Destination updated successfully.";
            } else {
                // Add new destination
                $stmt = $conn->prepare("INSERT INTO destinations (name, category_id) VALUES (?, ?)");
                $stmt->execute([$name, $category_id]);
                $success = "Destination added successfully.";
            }
        }
    }
    
    // Delete destination
    if (isset($_GET['delete']) && !empty($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        
        // Check if destination has tours
        $stmt = $conn->prepare("SELECT COUNT(*) FROM tours WHERE destination_id = ?");
        $stmt->execute([$id]);
        $tourCount = $stmt->fetchColumn();
        
        if ($tourCount > 0) {
            $error = "Cannot delete destination. It has $tourCount tour(s) associated with it.";
        } else {
            $stmt = $conn->prepare("DELETE FROM destinations WHERE id = ?");
            $stmt->execute([$id]);
            $success = "Destination deleted successfully.";
        }
    }
    
    // Get destination for editing
    $editDestination = null;
    if (isset($_GET['edit']) && !empty($_GET['edit'])) {
        $id = (int)$_GET['edit'];
        $editDestination = getDestination($conn, $id);
    }
    
    // Get all categories
    $categories = getCategories($conn);
    
    // Get all destinations
    $destinations = getDestinations($conn);
    
} catch(PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>

<div class="row">
    <!-- Add/Edit Destination Form -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <?php echo $editDestination ? 'Edit Destination' : 'Add New Destination'; ?>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="post" action="">
                    <?php if ($editDestination): ?>
                        <input type="hidden" name="destination_id" value="<?php echo $editDestination['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Destination Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $editDestination ? $editDestination['name'] : ''; ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>" <?php echo ($editDestination && $editDestination['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                                    <?php echo $category['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $editDestination ? 'Update Destination' : 'Add Destination'; ?>
                        </button>
                    </div>
                    
                    <?php if ($editDestination): ?>
                        <div class="mt-2 text-center">
                            <a href="destinations.php" class="btn btn-sm btn-outline-secondary">Cancel</a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Destinations List -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                Manage Destinations
            </div>
            <div class="card-body">
                <?php if (empty($destinations)): ?>
                    <p class="text-center">No destinations found. Add your first destination.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($destinations as $destination): ?>
                                <tr>
                                    <td><?php echo $destination['id']; ?></td>
                                    <td><?php echo $destination['name']; ?></td>
                                    <td><?php echo $destination['category_name']; ?></td>
                                    <td>
                                        <a href="destinations.php?edit=<?php echo $destination['id']; ?>" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="destinations.php?delete=<?php echo $destination['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this destination?')" data-bs-toggle="tooltip" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                        <a href="tours.php?destination=<?php echo $destination['id']; ?>" class="btn btn-sm btn-info" data-bs-toggle="tooltip" title="View Tours">
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
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>