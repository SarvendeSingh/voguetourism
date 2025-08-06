<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';

$categoryName = 'Domestic'; // The category for this page
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt_cat = $conn->prepare("SELECT id FROM categories WHERE name = ?");
    $stmt_cat->execute([$categoryName]);
    $categoryId = $stmt_cat->fetchColumn();

    if (!$categoryId) { throw new Exception("Category '$categoryName' not found."); }
    
    if (isset($_GET['delete'])) {
        // ... (Your existing delete logic from tours.php) ...
    }
    $tours = getToursByCategory($conn, $categoryId);
} catch(Exception $e) { $error = "Error: " . $e->getMessage(); }
?>

<?php if (isset($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>All <?php echo $categoryName; ?> Tours</span>
        <a href="add-tour.php" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Add New Tour</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead><tr><th>Image</th><th>Title</th><th>Destination</th><th>Price</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                    <?php if (empty($tours)): ?>
                        <tr><td colspan="5" class="text-center">No tours found in this category.</td></tr>
                    <?php else: ?>
                        <?php foreach ($tours as $tour): ?>
                        <tr>
                            <td><img src="../uploads/tours/<?php echo $tour['image']; ?>" width="60" class="rounded" alt=""></td>
                            <td><?php echo htmlspecialchars($tour['title']); ?></td>
                            <td><?php echo htmlspecialchars($tour['destination_name']); ?></td>
                            <td><?php echo formatPrice($tour['price']); ?></td>
                            <td class="text-end">
                                <a href="edit-tour.php?id=<?php echo $tour['id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> Edit</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php require_once 'includes/footer.php'; ?>