<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/json_handler.php';

$message = '';
$error = '';
$schedule = null;

$id = $_GET['id'] ?? '';

if (!$id) {
    header('Location: view_schedules.php');
    exit;
}

$schedule = getScheduleById($id);

if (!$schedule) {
    $error = "Schedule not found!";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitizeInput($_POST['title'] ?? '');
    $date = sanitizeInput($_POST['date'] ?? '');
    $description = sanitizeInput($_POST['description'] ?? '');
    
    if (empty($title) || empty($date)) {
        $error = "Title and Date are required!";
    } else {
        $updatedData = [
            'title' => $title,
            'date' => $date,
            'description' => $description
        ];
        
        if (updateSchedule($id, $updatedData)) {
            $message = "Schedule updated successfully!";
            $schedule = getScheduleById($id); // Refresh data
        } else {
            $error = "Failed to update schedule.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule</title>
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Edit Schedule</h1>
        
        <?php
        if ($message) echo showMessage('success', $message);
        if ($error) echo showMessage('error', $error);
        
        if ($schedule):
        ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="title">Event Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($schedule['title']); ?>" required class="form-control">
            </div>
            
            <div class="form-group">
                <label for="date">Event Date:</label>
                <input type="date" id="date" name="date" value="<?php echo $schedule['date']; ?>" required class="form-control">
            </div>
            
            <div class="form-group">
                <label for="description">Description (Optional):</label>
                <textarea id="description" name="description" class="form-control" rows="3"><?php echo htmlspecialchars($schedule['description'] ?? ''); ?></textarea>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Schedule</button>
                <a href="view_schedules.php" class="btn btn-secondary">Back to List</a>
            </div>
        </form>
        
        <?php endif; ?>
    </div>
</body>
</html>