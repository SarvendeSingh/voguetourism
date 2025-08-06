<?php
require_once '../dbc.php';
require_once '../admin/includes/functions.php';

$tour = null;
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $tour_slug = isset($_GET['tour_slug']) ? sanitizeInput($_GET['tour_slug']) : null;
    if (!$tour_slug) { throw new Exception("No tour specified."); }
    
    // This logic finds the tour by its URL slug, preserving your site's links
    $stmt = $conn->prepare("SELECT t.*, d.name as destination_name FROM tours t JOIN destinations d ON t.destination_id = d.id");
    $stmt->execute();
    $all_tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($all_tours as $current_tour) {
        if (create_slug($current_tour['title']) === $tour_slug) {
            $tour = $current_tour;
            break;
        }
    }
    if (!$tour) { throw new Exception("The requested tour could not be found."); }
    
} catch(Exception $e) { $error = $e->getMessage(); }

require_once '../header.php';
?>

<main>
    <?php if (isset($error)): ?>
        <section class="section text-center"><div class="container"><div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div></div></section>
    
    <?php elseif ($tour): ?>
        <script>document.title = "<?php echo htmlspecialchars($tour['title']); ?> - Vogue Tourism";</script>
        
        <section class="page-banner hero-slider-section" style="background-image: url('<?php echo $baseURL; ?>/uploads/tours/<?php echo $tour['image']; ?>');">
             <div class="slide-overlay">
                <div class="hero-content">
                    <h1 class="hero-title"><?php echo htmlspecialchars($tour['title']); ?></h1>
                </div>
            </div>
        </section>
        
        <section class="section">
            <div class="container">
                <div class="row gx-lg-5">
                    <div class="col-lg-8">
                        <?php 
                            // Show "What's Included" only if that specific field has content
                            if (!empty(trim($tour['whats_included']))): 
                            ?>
                                <div>
                                    <h5 class="mb-3">What's Included?</h5>
                                    <div class="tour-content">
                                        <?php echo $tour['whats_included']; ?>
                                    </div>
                                </div>
                            <?php endif; ?>


                        <?php
                        // INTELLIGENT CHECK: Has the data been migrated to the new fields?
                        // We check 'overview' as a proxy. If it has content, use the new tab system.
                        $isMigrated = !empty(trim($tour['overview']));

                        if ($isMigrated):
                        ?>
                            <!-- NEW DYNAMIC TAB LAYOUT (for migrated tours) -->
                            <ul class="nav nav-tabs nav-fill mb-4" id="tourTab" role="tablist">
                                <?php if (!empty(trim($tour['overview']))): ?><li class="nav-item" role="presentation"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#overview-pane" type="button" role="tab">Overview</button></li><?php endif; ?>
                                <?php if (!empty(trim($tour['activities']))): ?><li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#activities-pane" type="button" role="tab">Activities</button></li><?php endif; ?>
                                <?php if (!empty(trim($tour['itinerary']))): ?><li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#itinerary-pane" type="button" role="tab">Itinerary</button></li><?php endif; ?>
                                <?php if (!empty(trim($tour['exclusions']))): ?><li class="nav-item" role="presentation"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#exclusions-pane" type="button" role="tab">Exclusion</button></li><?php endif; ?>
                            </ul>
                            <div class="tab-content pt-3" id="tourTabContent">
                                <?php if (!empty(trim($tour['overview']))): ?><div class="tab-pane fade show active" id="overview-pane" role="tabpanel"><div class="tour-content"><?php echo $tour['overview']; ?></div></div><?php endif; ?>
                                <?php if (!empty(trim($tour['activities']))): ?><div class="tab-pane fade" id="activities-pane" role="tabpanel"><div class="tour-content"><?php echo $tour['activities']; ?></div></div><?php endif; ?>
                                <?php if (!empty(trim($tour['itinerary']))): ?><div class="tab-pane fade" id="itinerary-pane" role="tabpanel"><div class="tour-content"><?php echo $tour['itinerary']; ?></div></div><?php endif; ?>
                                <?php if (!empty(trim($tour['exclusions']))): ?><div class="tab-pane fade" id="exclusions-pane" role="tabpanel"><div class="tour-content"><?php echo $tour['exclusions']; ?></div></div><?php endif; ?>
                            </div>

                        <?php else: ?>
                            <!-- FALLBACK LAYOUT (for non-migrated tours) -->
                            <div class="tour-content">
                                <h4>Tour Details</h4>
                                <hr>
                                <?php echo nl2br(htmlspecialchars($tour['description'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="price-inquiry-card">
                            <p class="text-muted mb-1">Starting From</p>
                            <p class="price-tag mb-3"><?php echo formatPrice($tour['price']); ?></p>
                            

                            <div class="d-grid gap-2 mt-4">
                                <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#inquiryModal" data-tour-id="<?php echo $tour['id']; ?>" data-tour-name="<?php echo htmlspecialchars($tour['title']); ?>">Customise & Enquire</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php require_once '../footer.php'; ?>