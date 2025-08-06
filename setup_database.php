<?php
require_once 'dbc.php';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create admins table
    $conn->exec("CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )");
    
    // Insert default admin if not exists
    $checkAdmin = $conn->query("SELECT COUNT(*) FROM admins")->fetchColumn();
    if ($checkAdmin == 0) {
        $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $conn->exec("INSERT INTO admins (username, password) VALUES ('admin', '$defaultPassword')");
        echo "Default admin created.<br>";
    }
    
    // Create categories table
    $conn->exec("CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL UNIQUE
    )");
    
    // Insert default categories if not exists
    $checkCategories = $conn->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    if ($checkCategories == 0) {
        $conn->exec("INSERT INTO categories (name) VALUES ('Domestic'), ('International'), ('Cruise')");
        echo "Default categories created.<br>";
    }
    
    // Create destinations table
    $conn->exec("CREATE TABLE IF NOT EXISTS destinations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        category_id INT NOT NULL,
        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
    )");
    
    // Create tours table
    $conn->exec("CREATE TABLE IF NOT EXISTS tours (
        id INT AUTO_INCREMENT PRIMARY KEY,
        destination_id INT NOT NULL,
        title VARCHAR(100) NOT NULL,
        description TEXT NOT NULL,
        image VARCHAR(255) NOT NULL,
        duration VARCHAR(50) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (destination_id) REFERENCES destinations(id) ON DELETE CASCADE
    )");
    
    // Create inquiries table
    $conn->exec("CREATE TABLE IF NOT EXISTS inquiries (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        destination_id INT,
        tour_id INT,
        message TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (destination_id) REFERENCES destinations(id) ON DELETE SET NULL,
        FOREIGN KEY (tour_id) REFERENCES tours(id) ON DELETE SET NULL
    )");
    
    echo "All tables created successfully!";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>

<p>Database setup complete. <a href="index.php">Return to homepage</a> or <a href="admin/login.php">Login to admin panel</a></p>