<?php require_once 'header.php'; ?>

    <main>
     
    <section class="hero-slider-section p-0">
        <div class="h-100 w-100 position-relative">
            <img src="images/career.395Z.png" alt="Careers at Vogue Tourism" class="w-100 h-100 object-fit-cover"/>
        </div>           
    </section>

    <!-- ======= Career Application Form Section ======= -->
    <section class="section career-form-section bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h2 class="section-title">Join Our Team</h2>
                    <p >
                        We are always looking for passionate and talented individuals to become a part of the Vogue Tourism family. If you have a passion for travel and a commitment to excellence, we would love to hear from you. Fill out the form below to apply.
                    </p>
                </div>
            </div>

            <div class="row align-items-center justify-content-center gy-5 mt-1">
                <!-- Image on the left -->
                <div class="col-lg-5 text-center">
                    <div class="image-wrapper">
                        <div class="thumb-inner">
                            <img src="images/11.png" alt="Join Vogue Tourism Team" class="img-fluid rounded ">
                        </div>
                    </div>
                </div>

                   

                <!-- Form on the right -->
                <div class="col-lg-6">
                    <div class="form-wrapper-card">
                        <form action="#" method="POST" class="row g-4 career-application-form">
                            <!-- Name Field -->
                            <div class="col-12 form-group">
                                <input type="text" id="careerName" name="careerName" class="form-control" placeholder=" " required>
                                <label for="careerName" class="form-label"><i class="bi bi-person"></i> Enter Your Name*</label>
                            </div>
                            <!-- Email Field -->
                            <div class="col-12 form-group">
                                <input type="email" id="careerEmail" name="careerEmail" class="form-control" placeholder=" " required>
                                <label for="careerEmail" class="form-label"><i class="bi bi-envelope"></i> Enter Your Email*</label>
                            </div>
                            <!-- Phone Field -->
                            <div class="col-12 form-group">
                                <input type="tel" id="careerPhone" name="careerPhone" class="form-control" placeholder=" " required>
                                <label for="careerPhone" class="form-label"><i class="bi bi-telephone"></i> Contact Number*</label>
                            </div>
                            <!-- Resume Upload Field -->
                            <div class="col-12">
                               <label for="resumeUpload" class="form-label">Upload Resume*</label>
                                <input type="file" class="form-control" id="resumeUpload" name="resumeUpload" accept=".doc,.docx,.pdf,.png,.jpg,.jpeg" required>
                                <div id="resumeHelpBlock" class="form-text small text-muted mt-2">
                                    Please upload one file with the following type: .doc, .png, .jpg, .jpeg with max file size of 7MB.
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <div class="col-12 text-center mt-3">
                                <button type="submit" class="btn cta-button">Submit Application <i class="bi bi-send"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Career Application Form Section -->

</main>

 
     <?php include 'footer.php'; ?>


</body>
</html>