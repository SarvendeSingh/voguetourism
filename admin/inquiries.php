<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Delete inquiry
    if (isset($_GET['delete']) && !empty($_GET['delete'])) {
        $id = (int)$_GET['delete'];
        $stmt = $conn->prepare("DELETE FROM inquiries WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Inquiry deleted successfully.";
    }
    
    // Get all inquiries
    $inquiries = getInquiries($conn);
    
} catch(PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
?>

<div class="mb-4">
    <h5>Customer Inquiries</h5>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<?php if (isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        Manage Inquiries
    </div>
    <div class="card-body">
        <?php if (empty($inquiries)): ?>
            <p class="text-center">No inquiries found.</p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Destination</th>
                            <th>Tour</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inquiries as $inquiry): ?>
                        <tr>
                            <td><?php echo $inquiry['id']; ?></td>
                            <td><?php echo $inquiry['name']; ?></td>
                            <td><?php echo $inquiry['email']; ?></td>
                            <td><?php echo $inquiry['phone']; ?></td>
                            <td><?php echo $inquiry['destination_name'] ?? 'N/A'; ?></td>
                            <td><?php echo $inquiry['tour_name'] ?? 'N/A'; ?></td>
                            <td><?php echo date('M d, Y', strtotime($inquiry['created_at'])); ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#inquiryModal<?php echo $inquiry['id']; ?>">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <a href="inquiries.php?delete=<?php echo $inquiry['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this inquiry?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        
                        <!-- Modal for viewing inquiry details -->
                        <div class="modal fade" id="inquiryModal<?php echo $inquiry['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Inquiry Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <strong>Name:</strong> <?php echo $inquiry['name']; ?>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Email:</strong> <?php echo $inquiry['email']; ?>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Phone:</strong> <?php echo $inquiry['phone']; ?>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Destination:</strong> <?php echo $inquiry['destination_name'] ?? 'N/A'; ?>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Tour:</strong> <?php echo $inquiry['tour_name'] ?? 'N/A'; ?>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Date:</strong> <?php echo date('F d, Y H:i', strtotime($inquiry['created_at'])); ?>
                                        </div>
                                        <div class="mb-3">
                                            <strong>Message:</strong>
                                            <p class="mt-2"><?php echo nl2br($inquiry['message']); ?></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <a href="mailto:<?php echo $inquiry['email']; ?>" class="btn btn-primary">Reply via Email</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>