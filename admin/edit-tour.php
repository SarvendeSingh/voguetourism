<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';

$tour_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($tour_id === 0) {
    header('Location: dashboard.php');
    exit;
}

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $destination_id = (int)$_POST['destination_id'];
        $title = sanitizeInput($_POST['title']);
        $duration = sanitizeInput($_POST['duration']);
        $price = (float)$_POST['price'];
        $whats_included = $_POST['whats_included'];
        $overview = $_POST['overview'];
        $activities = $_POST['activities'];
        $itinerary = $_POST['itinerary'];
        $exclusions = $_POST['exclusions'];
        $image = $_POST['current_image'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadResult = uploadImage($_FILES['image']);
            if ($uploadResult['success']) {
                $image = $uploadResult['file_name'];
            } else { $error = $uploadResult['message']; }
        }

        if (!isset($error)) {
            $stmt = $conn->prepare(
                "UPDATE tours SET
                    destination_id = ?, title = ?, duration = ?, price = ?, image = ?,
                    whats_included = ?, overview = ?, activities = ?, itinerary = ?, exclusions = ?
                 WHERE id = ?"
            );
            $stmt->execute([
                $destination_id, $title, $duration, $price, $image,
                $whats_included, $overview, $activities, $itinerary, $exclusions,
                $tour_id
            ]);
            $success = "Tour updated successfully!";
        }
    }

    $tour = getTour($conn, $tour_id);
    $destinations = getDestinations($conn);
    if (!$tour) {
        header('Location: dashboard.php');
        exit;
    }

} catch(PDOException $e) { $error = "Database error: " . $e->getMessage(); }
?>

<div class="card">
    <div class="card-header"><h5>Edit Tour: <?php echo htmlspecialchars($tour['title']); ?></h5></div>
    <div class="card-body">
        <?php if (isset($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
        <?php if (isset($success)): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>

        <form method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($tour['image']); ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Tour Title</label><input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($tour['title']); ?>" required></div>
                <div class="col-md-6 mb-3"><label class="form-label">Destination</label><select class="form-select" name="destination_id" required><?php foreach ($destinations as $dest): ?><option value="<?php echo $dest['id']; ?>" <?php echo ($dest['id'] == $tour['destination_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($dest['name']) . " (" . htmlspecialchars($dest['category_name']) . ")"; ?></option><?php endforeach; ?></select></div>
                <div class="col-md-4 mb-3"><label class="form-label">Duration</label><input type="text" class="form-control" name="duration" value="<?php echo htmlspecialchars($tour['duration']); ?>"></div>
                <div class="col-md-4 mb-3"><label class="form-label">Price (INR)</label><input type="number" class="form-control" name="price" value="<?php echo $tour['price']; ?>" required></div>
                <div class="col-md-4 mb-3"><label class="form-label">Change Image</label><input type="file" class="form-control" name="image"></div>
            </div>

            <hr class="my-4">

            <div class="alert alert-warning"><strong>Action Required:</strong> Copy content from the "Old Description" box into the new fields below.</div>
            <div class="mb-4">
                <label class="form-label fw-bold">Old Description (For Reference Only)</label>
                <textarea class="form-control bg-light" rows="8" readonly><?php echo htmlspecialchars($tour['description']); ?></textarea>
            </div>

            <div class="mb-3"><label class="form-label">What's Included?</label><textarea name="whats_included" class="form-control wysiwyg"><?php echo htmlspecialchars($tour['whats_included'] ?? ''); ?></textarea></div>
            <div class="mb-3"><label class="form-label">Overview</label><textarea name="overview" class="form-control wysiwyg"><?php echo htmlspecialchars($tour['overview'] ?? ''); ?></textarea></div>
            <div class="mb-3"><label class="form-label">Activities</label><textarea name="activities" class="form-control wysiwyg"><?php echo htmlspecialchars($tour['activities'] ?? ''); ?></textarea></div>
            <div class="mb-3"><label class="form-label">Itinerary</label><textarea name="itinerary" class="form-control wysiwyg"><?php echo htmlspecialchars($tour['itinerary'] ?? ''); ?></textarea></div>
            <div class="mb-3"><label class="form-label">Exclusions</label><textarea name="exclusions" class="form-control wysiwyg"><?php echo htmlspecialchars($tour['exclusions'] ?? ''); ?></textarea></div>

            <div class="mt-4"><button type="submit" class="btn btn-primary">Update Tour</button></div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>