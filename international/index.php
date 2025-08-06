<?php
require_once '../dbc.php';
require_once '../admin/includes/functions.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // CHANGE 1: CATEGORY NAME
    $stmt_cat = $conn->prepare("SELECT id FROM categories WHERE name = 'International' LIMIT 1");
    $stmt_cat->execute();
    $categoryId = $stmt_cat->fetchColumn();
    if (!$categoryId) { throw new Exception("International category not found."); }

    $destinationsQuery = $conn->prepare("SELECT id, name FROM destinations WHERE category_id = ? ORDER BY name");
    $destinationsQuery->execute([$categoryId]);
    $availableDestinations = $destinationsQuery->fetchAll(PDO::FETCH_ASSOC);

    $durationsQuery = $conn->prepare("SELECT DISTINCT duration FROM tours t JOIN destinations d ON t.destination_id = d.id WHERE d.category_id = ? AND duration != '' ORDER BY duration");
    $durationsQuery->execute([$categoryId]);
    $availableDurations = $durationsQuery->fetchAll(PDO::FETCH_COLUMN);

    $destinationFilter = isset($_GET['destination']) ? (int)$_GET['destination'] : 0;
    $durationFilter = isset($_GET['duration']) ? sanitizeInput($_GET['duration']) : '';

    $toursQuery = "SELECT t.*, d.name as destination_name FROM tours t JOIN destinations d ON t.destination_id = d.id WHERE d.category_id = ?";
    $params = [$categoryId];
    if ($destinationFilter > 0) { $toursQuery .= " AND t.destination_id = ?"; $params[] = $destinationFilter; }
    if (!empty($durationFilter)) { $toursQuery .= " AND t.duration = ?"; $params[] = $durationFilter; }
    $toursQuery .= " ORDER BY t.created_at DESC";
    
    $stmt = $conn->prepare($toursQuery);
    $stmt->execute($params);
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(Exception $e) { $error = $e->getMessage(); }

require_once '../header.php';
?>

<script>document.title = "International Tours - Vogue Tourism";</script>

<main>
    <section class="page-banner hero-slider-section" style="background-image: url('<?php echo $baseURL; ?>/images/international-banner.webp'); height: 50vh;"></section>
    
    <div class="container">
        <section class="hero-search-bar">
            <!-- CHANGE 2: FORM ACTION URL -->
            <form action="<?php echo $baseURL; ?>/international/" method="GET" class="row g-3 align-items-center">
                <div class="col-lg-5"><select name="destination" class="form-select"><option value="0">Select Destination</option><?php foreach ($availableDestinations as $d): ?><option value="<?php echo $d['id']; ?>" <?php if ($d['id'] == $destinationFilter) echo 'selected'; ?>><?php echo htmlspecialchars($d['name']); ?></option><?php endforeach; ?></select></div>
                <div class="col-lg-5"><select name="duration" class="form-select"><option value="">Select Duration</option><?php foreach ($availableDurations as $d): ?><option value="<?php echo htmlspecialchars($d); ?>" <?php if ($d == $durationFilter) echo 'selected'; ?>><?php echo htmlspecialchars($d); ?></option><?php endforeach; ?></select></div>
                <div class="col-lg-2"><button type="submit" class="btn btn-search">Search</button></div>
            </form>
        </section>
    </div>
    
    <section class="section">
        <div class="container">
            <h2 class="section-title">All International Tour Packages</h2>
            <?php if (isset($error)): ?><div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
            
            <?php if (empty($tours)): ?>
                <div class="alert alert-info text-center mt-4">No international packages found matching your criteria.</div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($tours as $t): $t['slug'] = create_slug($t['title']); ?>
                    <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                        <div class="tour-card">
                            <div class="tour-img-container"><div class="tour-location-badge"><i class="bi bi-geo-alt-fill"></i> <?php echo htmlspecialchars($t['destination_name']); ?></div><img src="<?php echo $baseURL; ?>/uploads/tours/<?php echo $t['image']; ?>" class="card-img-top tour-img" alt="<?php echo htmlspecialchars($t['title']); ?>"></div>
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title h5"><?php echo htmlspecialchars($t['title']); ?></h3>
                                <p class="tour-duration"><i class="bi bi-clock"></i> <?php echo htmlspecialchars($t['duration']); ?></p>
                                <p class="card-text flex-grow-1"><?php echo htmlspecialchars(substr($t['description'], 0, 100)); ?>...</p>
                                <div>
                                    <p class="tour-price mb-0"><?php echo formatPrice($t['price']); ?></p>
                                    <div class="d-flex align-items-center mt-auto pt-3">
                                        <!-- CHANGE 3: VIEW MORE LINK -->


<a href="<?php echo $baseURL; ?>/cruise/<?php echo $t['slug']; ?>/" class="btn btn-sm btn-primary">View More</a>  
<button type="button" class="btn btn-sm btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#inquiryModal" data-tour-id="<?php echo $t['id']; ?>" data-tour-name="<?php echo htmlspecialchars($t['title']); ?>">Customize</button>
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

<?php require_once '../footer.php'; ?>