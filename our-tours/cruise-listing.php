<?php
require_once '../dbc.php';
require_once '../admin/includes/functions.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get the category ID for 'Cruise'
    $stmt = $conn->prepare("SELECT id FROM categories WHERE name = 'Cruise' LIMIT 1");
    $stmt->execute();
    $cruiseCategoryId = $stmt->fetchColumn();
    
    if (!$cruiseCategoryId) {
        throw new Exception("Cruise category not found in the database.");
    }

    // Get all available cruise destinations for the filter dropdown
    $destinationsQuery = $conn->prepare("SELECT id, name FROM destinations WHERE category_id = ? ORDER BY name");
    $destinationsQuery->execute([$cruiseCategoryId]);
    $availableDestinations = $destinationsQuery->fetchAll(PDO::FETCH_ASSOC);

    // Get all unique durations for the filter dropdown
    $durationsQuery = $conn->prepare(
        "SELECT DISTINCT t.duration FROM tours t 
         JOIN destinations d ON t.destination_id = d.id 
         WHERE d.category_id = ? AND t.duration IS NOT NULL AND t.duration != '' 
         ORDER BY t.duration"
    );
    $durationsQuery->execute([$cruiseCategoryId]);
    $availableDurations = $durationsQuery->fetchAll(PDO::FETCH_COLUMN);

    // Get the user's selections from the URL for filtering
    $destinationFilter = isset($_GET['destination']) ? (int)$_GET['destination'] : 0;
    $durationFilter = isset($_GET['duration']) ? sanitizeInput($_GET['duration']) : '';

    // Build the main query with the applied filters
    $toursQuery = "SELECT t.*, d.name as destination_name FROM tours t JOIN destinations d ON t.destination_id = d.id WHERE d.category_id = ?";
    $params = [$cruiseCategoryId];
    
    if ($destinationFilter > 0) {
        $toursQuery .= " AND t.destination_id = ?";
        $params[] = $destinationFilter;
    }
    
    if (!empty($durationFilter)) {
        $toursQuery .= " AND t.duration = ?";
        $params[] = $durationFilter;
    }
    
    $toursQuery .= " ORDER BY t.created_at DESC";
    
    $stmt = $conn->prepare($toursQuery);
    $stmt->execute($params);
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(Exception $e) {
    $error = $e->getMessage();
}

require_once '../header.php';
?>

<script>document.title = "Cruise Tours - Vogue Tourism";</script>

<main>
    <section class="page-banner hero-slider-section" style="background-image: url('<?php echo $baseURL; ?>/images/cruise-banner.webp'); height: 50vh;"></section>
    
    <!-- ============================================= -->
    <!-- === UPDATED FILTER SECTION TO MATCH HOMEPAGE === -->
    <!-- ============================================= -->
    <div class="container">
        <section class="hero-search-bar">
            <form action="cruise-listing.php" method="GET" class="row g-3 align-items-center">
                
                <div class="col-lg-5">
                    <select name="destination" class="form-select">
                        <option value="0">Select Destination</option>
                        <?php foreach ($availableDestinations as $destination): ?>
                            <option value="<?php echo $destination['id']; ?>" <?php echo ($destination['id'] == $destinationFilter) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($destination['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-lg-5">
                     <select name="duration" class="form-select">
                        <option value="">Select Duration</option>
                        <?php foreach ($availableDurations as $duration): ?>
                            <option value="<?php echo htmlspecialchars($duration); ?>" <?php echo ($duration == $durationFilter) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($duration); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-lg-2">
                    <button type="submit" class="btn btn-search">Search</button>
                </div>

            </form>
        </section>
    </div>
    
    <section class="section">
        <div class="container">
            <h2 class="section-title">All Cruise Tour Packages</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if (empty($tours)): ?>
                <div class="alert alert-info text-center mt-4">No cruise packages found matching your criteria.</div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($tours as $tour): ?>
                    <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                        <div class="tour-card">
                            <div class="tour-img-container">
                                <div class="tour-location-badge"><i class="bi bi-geo-alt-fill"></i> <?php echo htmlspecialchars($tour['destination_name']); ?></div>
                                <img src="<?php echo $baseURL; ?>/uploads/tours/<?php echo $tour['image']; ?>" class="card-img-top tour-img" alt="<?php echo htmlspecialchars($tour['title']); ?>">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title h5"><?php echo htmlspecialchars($tour['title']); ?></h3>
                                <p class="tour-duration"><i class="bi bi-clock"></i> <?php echo htmlspecialchars($tour['duration']); ?></p>
                                <p class="card-text flex-grow-1"><?php echo htmlspecialchars(substr($tour['description'], 0, 100)); ?>...</p>
                                
                                <div>
                                    <p class="tour-price mb-0"><?php echo formatPrice($tour['price']); ?></p>
                                    <div class="d-flex align-items-center mt-auto pt-2">
                                        <a href="details.php?id=<?php echo $tour['id']; ?>" class="btn btn-sm btn-primary">View More</a>
                                        <button type="button" class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#inquiryModal" data-tour-id="<?php echo $tour['id']; ?>" data-tour-name="<?php echo htmlspecialchars($tour['title']); ?>">
                                            Customize
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<div class="modal fade" id="inquiryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 1.5rem; border: none;">
            <div class="modal-header" style="border-bottom: none; padding: 1.5rem 2rem 0;">
                <h5 class="modal-title section-title" style="font-size: 1.8rem; text-align: left; padding-bottom: 0; margin-bottom: 0;">Customise: <span class="inquiry-tour-name text-truncate d-inline-block" style="max-width: 250px;">Your Trip</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem 2rem 2rem;">
                <form id="inquiryForm" action="<?php echo $baseURL; ?>/our-tours/process-inquiry.php" method="post" class="row g-3">
                    <input type="hidden" id="tour_id" name="tour_id">
                    <div class="col-12 form-group"><input type="text" id="modal_name" name="name" class="form-control" placeholder=" " required><label for="modal_name" class="form-label"><i class="bi bi-person"></i> Enter Your Name*</label></div>
                    <div class="col-12 form-group"><input type="email" id="modal_email" name="email" class="form-control" placeholder=" " required><label for="modal_email" class="form-label"><i class="bi bi-envelope"></i> Email Address*</label></div>
                    <div class="col-12 form-group"><input type="tel" id="modal_phone" name="phone" class="form-control" placeholder=" " required><label for="modal_phone" class="form-label"><i class="bi bi-telephone"></i> Contact Number*</label></div>
                    <div class="col-12 form-group"><textarea id="modal_message" name="message" class="form-control" placeholder=" " rows="4" style="height: 120px;"></textarea><label for="modal_message" class="form-label"><i class="bi bi-chat-dots"></i> Your Requirements</label></div>
                    <div class="col-12 text-center mt-3"><button type="submit" class="btn cta-button">Submit Inquiry <i class="bi bi-send"></i></button></div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
require_once '../footer.php'; 
?>

<script>
    $(document).ready(function() {
        $('#inquiryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var tourId = button.data('tour-id');
            var tourName = button.data('tour-name');
            var modal = $(this);
            modal.find('.inquiry-tour-name').text(tourName);
            modal.find('#tour_id').val(tourId);
        });
    });
</script>