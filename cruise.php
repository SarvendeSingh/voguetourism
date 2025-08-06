<?php require_once 'header.php'; ?>

    <main>
     
<section class="hero-slider-section p-0">
    <div class="h-100 w-100 position-relative">
        <img src="images/flight.jpg" alt="About Us" class="w-100 h-100 object-fit-cover"/>
    </div>   
           
</section>



</main>

 
    <section class="section contact-form-section bg-light">
        <div class="container">

            <!-- "Before" Element: Decorative Icons -->
            <div class="intro-icons-wrapper">
                <i class="bi bi-airplane-fill"></i>
                <i class="bi bi-sunrise-fill"></i>
                <i class="bi bi-geo-alt-fill"></i>
            </div>
            
            <h2 class="section-title">Let's Plan Your Perfect Holiday</h2>
            <p class="text-center section-subtitle-text">
                Our experts would love to create a package just for you! Simply fill out the form below and we'll be in touch.
            </p>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="form-wrapper-card">
                        <form action="#" method="POST" class="row g-4">
                            <!-- Name Field -->
                            <div class="col-md-6 form-group">
                                <input type="text" id="name" name="name" class="form-control" placeholder=" " required>
                                <label for="name" class="form-label"><i class="bi bi-person"></i> Enter Your Name*</label>
                            </div>
                            <!-- Destination Field -->
                            <div class="col-md-6 form-group">
                                <input type="text" id="destination" name="destination" class="form-control" placeholder=" " required>
                                <label for="destination" class="form-label"><i class="bi bi-pin-map"></i> Destination*</label>
                            </div>
                            <!-- Contact Number Field -->
                            <div class="col-md-6 form-group">
                                <input type="tel" id="contact" name="contact" class="form-control" placeholder=" " required>
                                <label for="contact" class="form-label"><i class="bi bi-telephone"></i> Contact Number*</label>
                            </div>
                            <!-- Date Field -->
                            <div class="col-md-6 form-group">
                                <!-- JS is used to change input type for better placeholder and date picker functionality -->
                                <input type="text" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" id="date" name="date" class="form-control" placeholder=" " required>
                                <label for="date" class="form-label"><i class="bi bi-calendar-event"></i> dd.mm.yyyy</label>
                            </div>
                            <!-- Email Field -->
                            <div class="col-12 form-group">
                                <input type="email" id="email" name="email" class="form-control" placeholder=" ">
                                <label for="email" class="form-label"><i class="bi bi-envelope"></i> Email Address</label>
                            </div>
                            <!-- Submit Button -->
                            <div class="col-12 text-center mt-3">
                                <button type="submit" class="btn cta-button">Submit Request <i class="bi bi-send"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- "After" Element: Social Proof -->
            <div class="outro-proof">
                <span><i class="bi bi-patch-check-fill"></i> Trusted by 10,000+ Happy Travellers</span>
            </div>
        </div>
    </section>


     <?php include 'footer.php'; ?>


</body>
</html>