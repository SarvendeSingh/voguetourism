<?php
// Make sure this file is included from the root or one level down
if (file_exists('dbc.php')) {
    require_once 'dbc.php';
} else if (file_exists('../dbc.php')) {
    require_once '../dbc.php';
} else {
    die('Critical error: Database configuration file not found.');
}

// Establish the database connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}

// Define the base URL for your site
$baseURL = '/voguetourism'; // This should match the RewriteBase in your .htaccess

// Fetch International Destinations for the dropdown
try {
    $stmt_int = $conn->prepare("SELECT d.id, d.name FROM destinations d JOIN categories c ON d.category_id = c.id WHERE c.name = 'International' ORDER BY d.name LIMIT 10");
    $stmt_int->execute();
    $intDestinations = $stmt_int->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { $intDestinations = []; }

// Fetch Domestic Destinations for the dropdown
try {
    $stmt_dom = $conn->prepare("SELECT d.id, d.name FROM destinations d JOIN categories c ON d.category_id = c.id WHERE c.name = 'Domestic' ORDER BY d.name LIMIT 10");
    $stmt_dom->execute();
    $domDestinations = $stmt_dom->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) { $domDestinations = []; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Book your next holiday with Vogue Tourism.">
    
    <!-- CSS Links using Root-Relative paths -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $baseURL; ?>/css/style.css">
    <title>Vogue Tourism</title>
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
                <a class="navbar-brand" href="<?php echo $baseURL; ?>/index.php"><img src="https://i.imgur.com/7v5gV4j.png" alt="Vogue Tourism Logo"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">International</a>
                            <ul class="dropdown-menu">
                                <!-- CHANGED: Link now points to the clean URL -->
                                <li><a class="dropdown-item" href="<?php echo $baseURL; ?>/international/">All International</a></li>
                                <?php if (!empty($intDestinations)): ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <?php foreach ($intDestinations as $dest): ?>
                                    <!-- CHANGED: Link now filters the clean URL -->
                                    <li><a class="dropdown-item" href="<?php echo $baseURL; ?>/international/?destination=<?php echo $dest['id']; ?>"><?php echo htmlspecialchars($dest['name']); ?></a></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Domestic</a>
                             <ul class="dropdown-menu">
                                <!-- CHANGED: Link now points to the clean URL -->
                                <li><a class="dropdown-item" href="<?php echo $baseURL; ?>/domestic/">All Domestic</a></li>
                                <?php if (!empty($domDestinations)): ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <?php foreach ($domDestinations as $dest): ?>
                                    <!-- CHANGED: Link now filters the clean URL -->
                                    <li><a class="dropdown-item" href="<?php echo $baseURL; ?>/domestic/?destination=<?php echo $dest['id']; ?>"><?php echo htmlspecialchars($dest['name']); ?></a></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <!-- CHANGED: Link now points to the clean URL -->
                            <a class="nav-link" href="<?php echo $baseURL; ?>/cruise/">Cruise</a>                             
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $baseURL; ?>/flight.php">Flights</a>                             
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $baseURL; ?>/visa-info.php">Visa Info</a>                             
                        </li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $baseURL; ?>/aboutus.php">About Us</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $baseURL; ?>/contact.php">Contact Us</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
<main>