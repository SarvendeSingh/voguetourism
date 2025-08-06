<?php
require_once '../dbc.php';
require_once '../admin/includes/functions.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $tourId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    if ($tourId <= 0) { throw new Exception("Invalid Tour ID provided."); }

    $stmt = $conn->prepare("SELECT t.*, d.name as destination_name FROM tours t JOIN destinations d ON t.destination_id = d.id WHERE t.id = ?");
    $stmt->execute([$tourId]);
    $tour = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$tour) { throw new Exception("The requested tour could not be found."); }
    
} catch(Exception $e) {
    $error = $e->getMessage();
}

require_once '../header.php';
?>

<main>
    <?php if (isset($error)): ?>
        <section class="section text-center">
            <div class="container">
                <h2 class="section-title">Error</h2>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <a href="javascript:history.back()" class="btn btn-primary mt-3">Go Back</a>
            </div>
        </section>
    <?php else: ?>
        <script>document.title = "<?php echo htmlspecialchars($tour['title']); ?> - Vogue Tourism";</script>
        
        <section class="page-banner hero-slider-section" style="background-image: url('<?php echo $baseURL; ?>/uploads/tours/<?php echo $tour['image']; ?>'); height: 60vh;">
            <div class="slide-overlay">
                <div class="hero-content">
                    <h1 class="hero-title"><?php echo htmlspecialchars($tour['title']); ?></h1>
                    <p class="hero-subtitle"><?php echo htmlspecialchars($tour['destination_name']); ?></p>
                </div>
            </div>
        </section>
        
        <section class="section">
            <div class="container">
                <div class="row gx-lg-5">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center mb-4">
                            <span class="tour-meta-item me-4"><i class="bi bi-clock-fill"></i> <?php echo htmlspecialchars($tour['duration']); ?></span>
                            <span class="tour-meta-item"><i class="bi bi-geo-alt-fill"></i> <?php echo htmlspecialchars($tour['destination_name']); ?></span>
                        </div>
                        <hr class="mb-4">
                        <h2 class="mb-3" style="text-align: left; font-size: 2.2rem;">Tour Description</h2>
                        <div class="tour-content" style="line-height: 1.8;">
                            <?php echo nl2br(htmlspecialchars($tour['description'])); ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="price-inquiry-card sticky-top" style="top: 120px;">
                            <p class="text-muted mb-1">Starting From</p>
                            <p class="price-tag mb-3"><?php echo formatPrice($tour['price']); ?></p>
                            <p class="text-muted small">*Price per person, subject to change.</p>
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#inquiryModal" data-tour-id="<?php echo $tour['id']; ?>" data-tour-name="<?php echo htmlspecialchars($tour['title']); ?>">
                                    Customise & Enquire
                                </button>
                                <a href="tel:+919899928979" class="btn btn-outline-secondary btn-lg"><i class="bi bi-telephone"></i> Call Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php 
// This single line now handles the footer, the inquiry modal, and all scripts.
require_once '../footer.php'; 
?>
<?php
// This variable is defined in header.php, ensuring our links are always correct.
$baseURL = isset($baseURL) ? $baseURL : '/voguetourism'; 
?>
</main> <!-- This closes the <main> tag that was opened in header.php -->


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

        if (document.querySelector('.hero-slider')) {
            new Swiper('.hero-slider', {
                loop: true, effect: 'creative', creativeEffect: { prev: { shadow: true, translate: [0, 0, -400], }, next: { translate: ['100%', 0, 0], }, },
                autoplay: { delay: 5000, disableOnInteraction: false }, navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' }, pagination: { el: '.swiper-pagination', clickable: true },
            });
        }
        if (document.querySelector('.destination-slider')) {
             new Swiper('.destination-slider', {
                loop: true, slidesPerView: 1, spaceBetween: 20, navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                breakpoints: { 640: { slidesPerView: 2 }, 768: { slidesPerView: 4 }, 1024: { slidesPerView: 5 } }
            });
        }
    });
</script>

</body>
</html>