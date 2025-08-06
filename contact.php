<?php require_once 'header.php'; ?>

    <main>
     
    <section class="hero-slider-section p-0">
        <div class="h-100 w-100 position-relative">
            <img src="images/career.395Z.png" alt="Contact Vogue Tourism" class="w-100 h-100 object-fit-cover"/>
        </div>   
    </section>

    <!-- ======= Contact Details Section ======= -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Get In Touch</h2>
            <p class="text-center section-subtitle-text mb-5">
                We're here to assist you. Reach out via phone, email, or visit our offices.
            </p>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 d-flex">
                    <div class="contact-info-card w-100">
                        <i class="bi bi-telephone"></i>
                        <h5>Call Us</h5>
                        <p><a href="tel:+919509616188">+91 9509616188</a></p>
                    </div>
                </div>
                <div class="col-lg-4 d-flex">
                    <div class="contact-info-card w-100">
                        <i class="bi bi-envelope"></i>
                        <h5>Email Us</h5>
                        <p><a href="mailto:info@voguetourism.com">info@voguetourism.com</a></p>
                    </div>
                </div>
                <div class="col-lg-4 d-flex">
                    <div class="contact-info-card w-100">
                        <i class="bi bi-geo-alt"></i>
                        <h5>Address</h5>
                        <p>806, Block-A, Solitaire Park, SG Hwy, Ahmedabad, Gujarat 380060</p>
                    </div>
                </div>
            </div>
            
            <div class="row g-5 mt-4">
                <div class="col-lg-6">
                    <div class="map-wrapper-shadow">
                        <h5>Ahmedabad Office</h5>
                    <p>806, Block-A, Solitaire Park, SG Hwy, Ahmedabad, Gujarat 380060</p>
                    <div class="map-wrapper shadow">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3670.893155708899!2d72.50854237531473!3d23.06443681498687!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e9b33a5b63391%3A0x26002f5344381861!2sSolitaire%20park!5e0!3m2!1sen!2sin!4v1674563210987!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    </div>
                </div>
                 <div class="col-lg-6">
                    <div class="map-wrapper-shadow">
                        <h5>Ajmer Office</h5>
                    <p>Sewa Square, C41B, opp. Nirala Hills, Kotra, Ajmer, Rajasthan 305001</p>
                    <div class="map-wrapper shadow">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3574.453396954203!2d74.6065463754218!3d26.37617948215984!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396be74f17a99999%3A0x7f8e8f8f8f8f8f8f!2sSewa%20Square!5e0!3m2!1sen!2sin!4v1674563333456!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section contact-form-section bg-light">
        <div class="container">
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
                            <div class="col-md-6 form-group">
                                <input type="text" id="name" name="name" class="form-control" placeholder=" " required>
                                <label for="name" class="form-label"><i class="bi bi-person"></i> Enter Your Name*</label>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" id="destination" name="destination" class="form-control" placeholder=" " required>
                                <label for="destination" class="form-label"><i class="bi bi-pin-map"></i> Destination*</label>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="tel" id="contact" name="contact" class="form-control" placeholder=" " required>
                                <label for="contact" class="form-label"><i class="bi bi-telephone"></i> Contact Number*</label>
                            </div>
                            <div class="col-md-6 form-group">
                                <input type="text" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" id="date" name="date" class="form-control" placeholder=" " required>
                                <label for="date" class="form-label"><i class="bi bi-calendar-event"></i> dd.mm.yyyy</label>
                            </div>
                            <div class="col-12 form-group">
                                <input type="email" id="email" name="email" class="form-control" placeholder=" ">
                                <label for="email" class="form-label"><i class="bi bi-envelope"></i> Email Address</label>
                            </div>
                            <div class="col-12 text-center mt-3">
                                <button type="submit" class="btn cta-button">Submit Request <i class="bi bi-send"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="outro-proof">
                <span><i class="bi bi-patch-check-fill"></i> Trusted by 10,000+ Happy Travellers</span>
            </div>
        </div>
    </section>

     <?php include 'footer.php'; ?>


</body>
</html>