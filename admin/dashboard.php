<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get dashboard counts
    $counts = getDashboardCounts($conn);
    
    // Get recent tours
    $stmt = $conn->prepare("SELECT t.*, d.name as destination_name 
                          FROM tours t 
                          JOIN destinations d ON t.destination_id = d.id 
                          ORDER BY t.created_at DESC LIMIT 5");
    $stmt->execute();
    $recentTours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get recent inquiries
    $stmt = $conn->prepare("SELECT i.*, d.name as destination_name, t.title as tour_name 
                          FROM inquiries i 
                          LEFT JOIN destinations d ON i.destination_id = d.id 
                          LEFT JOIN tours t ON i.tour_id = t.id 
                          ORDER BY i.created_at DESC LIMIT 5");
    $stmt->execute();
    $recentInquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!-- Dashboard Stats -->
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Destinations</h5>
                        <h2 class="mb-0"><?php echo $counts['destinations']; ?></h2>
                    </div>
                    <i class="bi bi-geo-alt" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Tours</h5>
                        <h2 class="mb-0"><?php echo $counts['tours']; ?></h2>
                    </div>
                    <i class="bi bi-briefcase" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Inquiries</h5>
                        <h2 class="mb-0"><?php echo $counts['inquiries']; ?></h2>
                    </div>
                    <i class="bi bi-envelope" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Category Stats -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Destinations by Category</span>
                <a href="destinations.php" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($counts['by_category'])): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Destinations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($counts['by_category'] as $category): ?>
                                <tr>
                                    <td><?php echo $category['name']; ?></td>
                                    <td><?php echo $category['count']; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center">No categories found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Recent Tours -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Recent Tours</span>
                <a href="tours.php" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recentTours)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tour</th>
                                    <th>Destination</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentTours as $tour): ?>
                                <tr>
                                    <td><?php echo $tour['title']; ?></td>
                                    <td><?php echo $tour['destination_name']; ?></td>
                                    <td><?php echo formatPrice($tour['price']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center">No tours found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Recent Inquiries -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Recent Inquiries</span>
                <a href="inquiries.php" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                <?php if (!empty($recentInquiries)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Destination</th>
                                    <th>Tour</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentInquiries as $inquiry): ?>
                                <tr>
                                    <td><?php echo $inquiry['name']; ?></td>
                                    <td><?php echo $inquiry['email']; ?></td>
                                    <td><?php echo $inquiry['phone']; ?></td>
                                    <td><?php echo $inquiry['destination_name'] ?? 'N/A'; ?></td>
                                    <td><?php echo $inquiry['tour_name'] ?? 'N/A'; ?></td>
                                    <td><?php echo date('M d, Y', strtotime($inquiry['created_at'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center">No inquiries found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>