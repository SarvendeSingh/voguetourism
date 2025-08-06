<?php require_once 'header.php'; ?>

    <main>
     
        <section class="hero-slider-section p-0">
            <div class="h-100 w-100 position-relative">
                <img src="images/banner1.jpg" alt="Blogs" class="w-100 h-100 object-fit-cover"/>
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background-color: rgba(0,0,0,0.5);">
                    <div class="text-center text-white">
                        <h1 class="display-4 fw-bold">Our Travel Blogs</h1>
                        <p class="lead">Discover travel tips, guides, and inspiration</p>
                    </div>
                </div>
            </div>   
        </section>

        <section class="section">
            <div class="container">
                <h2 class="section-title">Latest Travel Stories</h2>
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                        <div class="blog-card">
                            <img src="https://www.traveljunky.in/blog_images/NzQ=/NzQ=-main.webp" class="card-img-top" alt="Blog">
                            <div class="card-body">
                                <h5 class="card-title">Top 3 Bali Honeymoon Tours</h5>
                                <p>Discover the most romantic spots and experiences for newlyweds in beautiful Bali.</p>
                                <a href="#" class="blog-link">Read More <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                        <div class="blog-card">
                            <img src="https://www.traveljunky.in/blog_images/NzM=/NzM=-main.webp" class="card-img-top" alt="Blog">
                            <div class="card-body">
                                <h5 class="card-title">A Guide to the Top 10 Places in Ladakh</h5>
                                <p>Explore the breathtaking landscapes and cultural treasures of this Himalayan region.</p>
                                <a href="#" class="blog-link">Read More <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                        <div class="blog-card">
                            <img src="https://www.traveljunky.in/blog_images/NzI=/NzI=-main.webp" class="card-img-top" alt="Blog">
                            <div class="card-body">
                                <h5 class="card-title">Best Beaches for Water Sports in Bali</h5>
                                <p>Find the perfect spots for surfing, snorkeling, and other exciting water activities.</p>
                                <a href="#" class="blog-link">Read More <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                        <div class="blog-card">
                            <img src="https://www.traveljunky.in/blog_images/Njc=/Njc=-main.webp" class="card-img-top" alt="Blog">
                            <div class="card-body">
                                <h5 class="card-title">Discovering Bali's Best Street Food</h5>
                                <p>A culinary journey through the vibrant and flavorful street food scene of Bali.</p>
                                <a href="#" class="blog-link">Read More <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                        <div class="blog-card">
                            <img src="images/thailand.jpg" class="card-img-top" alt="Blog">
                            <div class="card-body">
                                <h5 class="card-title">Thailand: Beyond the Beaches</h5>
                                <p>Explore the cultural richness and natural wonders beyond Thailand's famous coastlines.</p>
                                <a href="#" class="blog-link">Read More <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                        <div class="blog-card">
                            <img src="images/Dubai-1.jpg" class="card-img-top" alt="Blog">
                            <div class="card-body">
                                <h5 class="card-title">Dubai: A City of Superlatives</h5>
                                <p>Discover the tallest, largest, and most luxurious attractions in this desert metropolis.</p>
                                <a href="#" class="blog-link">Read More <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
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