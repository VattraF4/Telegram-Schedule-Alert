<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/json_handler.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitizeInput($_POST['title'] ?? '');
    $date = sanitizeInput($_POST['date'] ?? '');
    $description = sanitizeInput($_POST['description'] ?? '');
    
    if (empty($title) || empty($date)) {
        $error = "Title and Date are required!";
    } else {
        $schedule = [
            'title' => $title,
            'date' => $date,
            'description' => $description
        ];
        
        if (addSchedule($schedule)) {
            $message = "Schedule added successfully!";
        } else {
            $error = "Failed to add schedule.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Schedule</title>
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Add New Schedule</h1>
        
        <?php
        if ($message) echo showMessage('success', $message);
        if ($error) echo showMessage('error', $error);
        ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="title">Event Title:</label>
                <input type="text" id="title" name="title" required class="form-control">
            </div>
            
            <div class="form-group">
                <label for="date">Event Date:</label>
                <input type="date" id="date" name="date" required class="form-control">
            </div>
            
            <div class="form-group">
                <label for="description">Description (Optional):</label>
                <textarea id="description" name="description" class="form-control" rows="3"></textarea>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add Schedule</button>
                <a href="../index.php" class="btn btn-secondary">Back to Home</a>
            </div>
        </form>
    </div>
</body>
</html>