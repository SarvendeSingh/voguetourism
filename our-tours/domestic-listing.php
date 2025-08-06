<?php
require_once '../dbc.php';
require_once '../admin/includes/functions.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get domestic category ID
    $stmt = $conn->prepare("SELECT id FROM categories WHERE name = 'Domestic'");
    $stmt->execute();
    $domesticCategoryId = $stmt->fetchColumn();
    
    if (!$domesticCategoryId) {
        throw new Exception("Domestic category not found");
    }
    
    // Get all domestic destinations
    $stmt = $conn->prepare("SELECT * FROM destinations WHERE category_id = ? ORDER BY name");
    $stmt->execute([$domesticCategoryId]);
    $destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get filter parameters
    $durationFilter = isset($_GET['duration']) ? sanitizeInput($_GET['duration']) : '';
    
    // Prepare base query for tours
    $toursQuery = "SELECT t.*, d.name as destination_name 
                  FROM tours t 
                  JOIN destinations d ON t.destination_id = d.id 
                  WHERE d.category_id = ?";
    $params = [$domesticCategoryId];
    
    // Add duration filter if provided
    if (!empty($durationFilter)) {
        $toursQuery .= " AND t.duration LIKE ?"; 
        $params[] = "%$durationFilter%";
    }
    
    $toursQuery .= " ORDER BY t.created_at DESC";
    
    $stmt = $conn->prepare($toursQuery);
    $stmt->execute($params);
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(Exception $e) {
    $error = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domestic Tours - Vogue Tourism</title>
    <meta name="description" content="Explore the best domestic tour packages with Vogue Tourism. Find tours to popular destinations across India.">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Additional styles for tour listings */
        .destination-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }
        .destination-card:hover {
            transform: translateY(-5px);
        }
        .destination-img {
            height: 200px;
            object-fit: cover;
        }
        .tour-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 30px;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .tour-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .tour-img {
            height: 200px;
            object-fit: cover;
        }
        .tour-price {
            font-size: 1.25rem;
            font-weight: 600;
            color: #007bff;
        }
        .tour-duration {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .page-banner {
            background-color: #f8f9fa;
            padding: 50px 0;
            margin-bottom: 50px;
        }
        .filter-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .inquiry-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
    </style>
</head>
<body>

    <header>
        <div class="header-top-bar">
            <div class="container d-flex justify-content-between align-items-center">
                <div><i class="bi bi-clock"></i> Mon - Sat: 10am - 7pm</div>
                <div class="headercontact text-white"><a href="tel:+919899928979" class="text-white"><i class="bi bi-telephone"></i> +91-98999-28979</a></div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg main-header sticky-top">
            <div class="container">
                <a class="navbar-brand" href="../index.php"><img src="https://i.imgur.com/7v5gV4j.png" alt="Vogue Tourism Logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">International</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="international-listing.php">All International</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <?php 
                                // Get international destinations for dropdown
                                $stmt = $conn->prepare("SELECT d.* FROM destinations d JOIN categories c ON d.category_id = c.id WHERE c.name = 'International' ORDER BY d.name LIMIT 10");
                                $stmt->execute();
                                $intDestinations = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach ($intDestinations as $dest): 
                                ?>
                                <li><a class="dropdown-item" href="details.php?destination=<?php echo $dest['id']; ?>"><?php echo $dest['name']; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">Domestic</a>
                             <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="domestic-listing.php">All Domestic</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <?php foreach ($destinations as $dest): ?>
                                <li><a class="dropdown-item" href="details.php?destination=<?php echo $dest['id']; ?>"><?php echo $dest['name']; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cruise-listing.php">Cruise</a>                             
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../flight.php">Flights</a>                             
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../visa-info.php">Visa Info</a>                             
                        </li>
                        <li class="nav-item"><a class="nav-link" href="../aboutus.php">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="../contact.php">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- Page Banner -->
        <section class="page-banner">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <h1>Domestic Tour Packages</h1>
                        <p class="lead">Explore the beauty of India with our carefully crafted domestic tour packages.</p>
                    </div>
                    <div class="col-lg-5">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-lg-end">
                                <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Domestic Tours</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Filter Section -->
        <section class="container mb-5">
            <div class="filter-section">
                <form method="get" action="" class="row g-3">
                    <div class="col-md-8">
                        <label for="duration" class="form-label">Filter by Duration</label>
                        <input type="text" class="form-control" id="duration" name="duration" placeholder="e.g. 3 Days" value="<?php echo $durationFilter; ?>">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">Filter</button>
                        <a href="domestic-listing.php" class="btn btn-secondary">Reset</a>
                    </div>
                </form>
            </div>
        </section>
        
        <!-- Destinations Section -->
        <section class="container mb-5">
            <h2 class="text-center mb-4">Popular Domestic Destinations</h2>
            <div class="row">
                <?php foreach ($destinations as $destination): ?>
                <div class="col-md-4 mb-4">
                    <div class="destination-card">
                        <?php 
                        // Get a tour image for this destination
                        $stmt = $conn->prepare("SELECT image FROM tours WHERE destination_id = ? LIMIT 1");
                        $stmt->execute([$destination['id']]);
                        $tourImage = $stmt->fetchColumn();
                        $imagePath = $tourImage ? "../uploads/tours/$tourImage" : "../images/placeholder.jpg";
                        
                        // Count tours for this destination
                        $stmt = $conn->prepare("SELECT COUNT(*) FROM tours WHERE destination_id = ?");
                        $stmt->execute([$destination['id']]);
                        $tourCount = $stmt->fetchColumn();
                        ?>
                        <img src="<?php echo $imagePath; ?>" class="card-img-top destination-img" alt="<?php echo $destination['name']; ?>">
                        <div class="card-body text-center">
                            <h3 class="card-title"><?php echo $destination['name']; ?></h3>
                            <p class="card-text"><?php echo $tourCount; ?> tour packages available</p>
                            <a href="details.php?destination=<?php echo $destination['id']; ?>" class="btn btn-primary">View Packages</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        
        <!-- Tours Section -->
        <section class="container mb-5">
            <h2 class="text-center mb-4">All Domestic Tour Packages</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if (empty($tours)): ?>
                <div class="alert alert-info">No tour packages found. Please check back later or try a different filter.</div>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($tours as $tour): ?>
                    <div class="col-md-4 mb-4">
                        <div class="tour-card">
                            <img src="../uploads/tours/<?php echo $tour['image']; ?>" class="card-img-top tour-img" alt="<?php echo $tour['title']; ?>">
                            <div class="card-body">
                                <h3 class="card-title h5"><?php echo $tour['title']; ?></h3>
                                <p class="tour-duration"><i class="bi bi-clock"></i> <?php echo $tour['duration']; ?></p>
                                <p class="card-text"><?php echo substr($tour['description'], 0, 100); ?>...</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="tour-price"><?php echo formatPrice($tour['price']); ?></span>
                                    <div>
                                        <a href="details.php?id=<?php echo $tour['id']; ?>" class="btn btn-sm btn-primary">View More</a>
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#inquiryModal" data-tour-id="<?php echo $tour['id']; ?>" data-tour-name="<?php echo $tour['title']; ?>">
                                            Customise
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <!-- Inquiry Modal -->
    <div class="modal fade" id="inquiryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Customise Your Tour</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="inquiryForm" action="process-inquiry.php" method="post">
                        <input type="hidden" id="tour_id" name="tour_id">
                        <input type="hidden" id="destination_id" name="destination_id">
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="message" class="form-label">Your Requirements</label>
                            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Tell us about your specific requirements, preferred dates, number of travelers, etc."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Submit Inquiry</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer bg-dark text-white pt-5 pb-3">
        <div class="container">
            <div class="row">
                <!-- Contact Information -->
                <div class="col-md-4 mb-4">
                    <h5 class="mb-4">Contact Us</h5>
                    <p><i class="bi bi-geo-alt me-2"></i> 123 Tourism Street, New Delhi, India</p>
                    <p><i class="bi bi-telephone me-2"></i> +91-98999-28979</p>
                    <p><i class="bi bi-envelope me-2"></i> info@voguetourism.com</p>
                    <div class="social-icons mt-4">
                        <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-md-4 mb-4">
                    <h5 class="mb-4">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="../index.php" class="text-white">Home</a></li>
                        <li class="mb-2"><a href="domestic-listing.php" class="text-white">Domestic Tours</a></li>
                        <li class="mb-2"><a href="international-listing.php" class="text-white">International Tours</a></li>
                        <li class="mb-2"><a href="cruise-listing.php" class="text-white">Cruise Tours</a></li>
                        <li class="mb-2"><a href="../aboutus.php" class="text-white">About Us</a></li>
                        <li class="mb-2"><a href="../contact.php" class="text-white">Contact Us</a></li>
                    </ul>
                </div>
                
                <!-- Newsletter -->
                <div class="col-md-4 mb-4">
                    <h5 class="mb-4">Newsletter</h5>
                    <p>Subscribe to our newsletter for the latest updates and offers.</p>
                    <form>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Your Email" aria-label="Your Email">
                            <button class="btn btn-primary" type="button">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sub-footer -->
            <div class="sub-footer text-center mt-4 pt-4 border-top border-secondary">
                <p class="mb-0">© 2024 Vogue Tourism. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap, jQuery & Swiper JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="../js/custom.js"></script>

    <script>
        // Handle inquiry modal
        $('#inquiryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var tourId = button.data('tour-id');
            var tourName = button.data('tour-name');
            
            var modal = $(this);
            modal.find('.modal-title').text('Customise: ' + tourName);
            modal.find('#tour_id').val(tourId);
        });
    </script>

</body>
</html>