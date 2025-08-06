<?php
session_start();
require_once dirname(dirname(__DIR__)) . '/dbc.php';

// Check if user is logged in
if (!isset($_SESSION['admin_id']) && basename($_SERVER['PHP_SELF']) != 'login.php') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vogue Tourism Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<?php if (isset($_SESSION['admin_id'])): ?>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebarMenu" class="col-md-3 col-lg-3 d-md-block bg-dark sidebar collapse">
            <div class="position-sticky pt-3">
                 <div class="text-center mb-4">
                    <h5 class="text-white">Vogue Tourism</h5>
                    <p class="small text-white-50">Admin Panel</p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) == 'destinations.php' ? 'active' : ''; ?>" href="destinations.php">
                            <i class="bi bi-geo-alt me-2"></i> Destinations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo (strpos($_SERVER['PHP_SELF'], 'cruise-tours.php') !== false) ? 'active' : ''; ?>" href="cruise-tours.php">
                            <i class="bi bi-tsunami me-2"></i> Cruise Tours
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo (strpos($_SERVER['PHP_SELF'], 'domestic-tours.php') !== false) ? 'active' : ''; ?>" href="domestic-tours.php">
                            <i class="bi bi-map me-2"></i> Domestic Tours
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo (strpos($_SERVER['PHP_SELF'], 'international-tours.php') !== false) ? 'active' : ''; ?>" href="international-tours.php">
                            <i class="bi bi-globe-americas me-2"></i> International Tours
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white <?php echo basename($_SERVER['PHP_SELF']) == 'inquiries.php' ? 'active' : ''; ?>" href="inquiries.php">
                            <i class="bi bi-envelope me-2"></i> Inquiries
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link text-danger" href="logout.php">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <?php 
                    $current_page = basename($_SERVER['PHP_SELF'], '.php');
                    echo ucwords(str_replace(['-'], ' ', $current_page));
                    ?>
                </h1>
            </div>
<?php endif; ?>