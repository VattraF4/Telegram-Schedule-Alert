<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/json_handler.php';

$message = '';
$error = '';

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
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        if (deleteSchedule($id)) {
            $message = "Schedule deleted successfully!";
            $schedule = null;
        } else {
            $error = "Failed to delete schedule.";
        }
    } else {
        header('Location: view_schedules.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Schedule</title>
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Delete Schedule</h1>
        
        <?php
        if ($message) echo showMessage('success', $message);
        if ($error) echo showMessage('error', $error);
        
        if ($schedule):
        ?>
        
        <div class="alert alert-warning">
            <h3>Are you sure you want to delete this schedule?</h3>
            <p><strong>Title:</strong> <?php echo htmlspecialchars($schedule['title']); ?></p>
            <p><strong>Date:</strong> <?php echo $schedule['date']; ?></p>
            <?php if ($schedule['description']): ?>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($schedule['description']); ?></p>
            <?php endif; ?>
        </div>
        
        <form method="POST" action="">
            <input type="hidden" name="confirm" value="yes">
            <div class="form-group">
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                <a href="view_schedules.php" class="btn btn-secondary">No, Cancel</a>
            </div>
        </form>
        
        <?php endif; ?>
    </div>
</body>
</html>