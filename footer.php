<?php
// This variable is defined in header.php, ensuring our links are always correct.
$baseURL = isset($baseURL) ? $baseURL : '/voguetourism'; 
?>
</main> <!-- This closes the <main> tag that was opened in header.php -->

<footer class="footer">
    <div class="container">
        <div class="row gy-4">
            <!-- About Section -->
            <div class="col-lg-3 col-md-6">
                <img src="https://i.imgur.com/7v5gV4j.png" alt="Vogue Tourism" style="height:40px; margin-bottom: 20px;">
                <p>Crafting unforgettable travel experiences tailored just for you. Explore the world with confidence.</p>
            </div>

            <!-- Quick Links Section -->
            <div class="col-lg-2 col-md-6">
                <h5>Quick Links</h5>
                <!-- CHANGED: All links now use the universal $baseURL -->
                <a href="<?php echo $baseURL; ?>/flight.php">Flights</a>
                <a href="<?php echo $baseURL; ?>/visa-info.php">Visa Info</a>
                <a href="<?php echo $baseURL; ?>/aboutus.php">About Us</a>
                <a href="<?php echo $baseURL; ?>/blogs.php">Blogs</a> 
                <a href="<?php echo $baseURL; ?>/career.php">Career</a> 
                <a href="<?php echo $baseURL; ?>/privacy-policy.php">Privacy Policy</a>
                <a href="#">Terms of Use</a>
            </div>

            <!-- Destinations Section -->
            <div class="col-lg-2 col-md-6">
                <h5>Destinations</h5>
                <!-- CHANGED: All links now point to the clean URLs -->
                <a href="<?php echo $baseURL; ?>/international/">International</a>
                <a href="<?php echo $baseURL; ?>/domestic/">Domestic</a>                    
            </div>

            <!-- Contact Us Section -->
            <div class="col-lg-3 col-md-6">
                <h5>Contact Us</h5>
                <p class="mb-2"><a href="tel:+919509616188"><i class="bi bi-telephone-fill me-2"></i>+91 9509616188</a></p>
                <p class="mb-3"><a href="mailto:info@voguetourism.com"><i class="bi bi-envelope-fill me-2"></i>info@voguetourism.com</a></p>
                <p class="mb-2"><strong>Ahmedabad:</strong> 806, Block-A, Solitaire Park, SG Hwy, 380060</p>
                <p><strong>Ajmer:</strong> Sewa Square, C41B, opp. Nirala Hills, Kotra, 305001</p>
            </div>
            
            <!-- Connect With Us Section -->
            <div class="col-lg-2 col-md-6">
                 <h5>Connect With Us</h5>
                 <p>Let's plan your next adventure!</p>
                 <div class="social-icons">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-youtube"></i></a>
                 </div>
            </div>
        </div>

        <!-- Sub-footer -->
        <div class="sub-footer text-center">
            <p class="mb-0">© <?php echo date('Y'); ?> Vogue Tourism. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<!-- Universal Inquiry Modal for all pages -->
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

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="<?php echo $baseURL; ?>/js/custom.js"></script>

<!-- Universal Script for Modals -->
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

</body>
</html>