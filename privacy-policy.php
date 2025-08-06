<?php require_once 'header.php'; ?>

    <main>
        
      

        <section class="section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>Privacy Policy</h2>
                        <p>Vogue Tourism LLP. is committed to ensuring that your privacy is protected. If you provide unique identifying information, such as name, address and other information to us, such information may be used for internal record keeping, various statistical and other purposes. If you visit our site by “clicking-through” from a site operated by one of our partners, and you have registered with that partner, then certain information about you that you have provided to that partner may be transmitted to us. You should review the privacy policy of the Web site from which you reached our site in order to determine what information was collected and how you agreed that our partner could use that information.</p>
                        <p><a rel="noreferrer noopener" href="http://www.voguetourism.com/" target="_blank">www.voguetourism.com</a> will not sell, trade or disclose to third parties any information derived from the customer for, or use of, any online service (including names and addresses) without the consent of the user or customer (except as required by subpoena, search warrant, or other legal process or in the case of imminent physical harm to the user or others). We will allow suppliers like airlines, railways, hotels etc. to access the information for purposes of confirming your reservations or tickets and providing you with benefits you are entitled to. We or any of our partners/affiliate/group companies may contact you from time to time to provide the offers/information of such products/services that we believe may benefit you. From time to time, we may contact you for market research purposes. We may contact you by email, phone, fax or mail.</p>
                        <p>We may change this policy from time to time by updating this section. You should check this section from time to time to keep yourself updated with the latest policy.</p>

                        <h2 class="mt-5">Disclaimer</h2>
                        <p>The information contained in this website is for general information purposes only. The information is provided by Vogue Tourism LLP. and its users and partners; while we try to keep the information up to date and correct, we make no representations or warranties of any kind, express or implied, about the completeness, accuracy, reliability, suitability or availability with respect to the website or the information, products, services, or related graphics contained on the website for any purpose. Any reliance you place on such information is therefore strictly at your own risk.</p>
                        <p>Vogue Tourism LLP. disclaims all warranties of merchantability, relating to the information and description of the tour packages, hotel booking, Visa, cab/taxi, car rental and Air Ticket or any other product or service displayed on this website, its Affiliates and their respective suppliers make no guarantees about the availability of specific products and services.</p>
                        <p>You also acknowledge that through this Site, Vogue Tourism LLP. merely provides intermediary services in order to facilitate high quality services to you. indiabycaranddriver.com is not the last-mile service provider to you and therefore, it shall not be or deemed to be responsible for any lack or deficiency of services provided by any third party (hotel, airline or train).In no event will we be liable for any loss or damage including without limitation, indirect or consequential loss or damage, or any loss or damage whatsoever arising from loss of data or profits arising out of, or in connection with, the use of this website.</p>
                        <p>Every effort is made to keep the website up and running smoothly. However, Vogue Tourism LLP. takes no responsibility for, and will not be liable for, the website being temporarily unavailable due to technical issues beyond our control.</p>
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